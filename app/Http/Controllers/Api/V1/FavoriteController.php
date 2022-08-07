<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $products = Favorite::select('home_id')->where('user_id', '=', $user_id)->get()->toJson();
        if (empty(Redis::get('favorite' . ' ' . $user_id))) {
            Redis::set('favorite' . ' ' . $user_id, $products);
        }
        $favorite_table = Redis::get('favorite' . ' ' . $user_id);
        if (empty('favorite' . ' ' . $user_id)) {
            $favorite_table = Favorite::all();
        }
        return response([
            'Favorite' => json_decode($favorite_table),
            'message' => 'Success'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        Favorite::create($data);
        return response([
            'Favorite products' => new FavoriteResource($data),
            'message' => 'Success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $user_id = Auth::id();
      $prod = Favorite::where('user_id', '=', $user_id)
          ->where('home_id', '=', $request->product_id)->delete();
      if ($prod) {
          return response([
              'message' => "Favorite product deleted"
          ], 200);
      } else {
          return response([
              'message' => 'You don\'t have any selected products'
          ], 200);
      }

    }
}
