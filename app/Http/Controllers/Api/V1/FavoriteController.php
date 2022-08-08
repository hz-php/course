<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use App\Models\Favorite;
use App\Models\Home;
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
    public function index(): object
    {
        $user_id = Auth::id();
        $products = Favorite::all()->where('user_id', '=', $user_id);
        if (empty(Redis::get('favorite' . ' ' . $user_id))) {

            foreach ($products as $home) {
                $home_r[] = Home::where('id', '=', $home->home_id)->get();
                Redis::set('favorite' . ' ' . $user_id, json_encode($home_r));
            }
        }
        $favorite_table = Redis::get('favorite' . ' ' . $user_id);
        if (empty(Redis::get('favorite' . ' ' . $user_id))) {
            $favorite_prod_id = Favorite::select('home_id')
                ->where('user_id', '=', Auth::id())->get();
           if (count($favorite_prod_id) > 1) {
               foreach ($favorite_prod_id as $pr_id) {
                   $favorite_table[] = Home::all()->where('id', '=', $pr_id->home_id);
               }
           } else {
               $favorite_table = Home::all()->where('id', '=', $favorite_prod_id[0]->home_id);
           }
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
    public function store(Request $request): object
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
    public function destroy(Request $request): object
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
