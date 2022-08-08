<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompareListResource;
use App\Models\Compare;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): object
    {
        $product_id = Compare::select('product_id')
            ->where('user_id', '=', Auth::id())->get();
        if (count($product_id) > 1) {
            foreach ($product_id as $id) {
                $compare_list[] = Home::where('id', '=', $id->product_id)->get();
            }
        } else {
            $compare_list[] = Home::where('id', '=', $product_id->product_id)->get();
        }
        return response([
            'Compare list' => new CompareListResource($compare_list),
            'message' => 'Success'
        ]);
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
        Compare::create($data);

        return response([
            'Add with compare' => new CompareListResource($data),
            'message' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Auth $user_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(): object
    {
        $user_id = Auth::id();
        $compare_list = Compare::all()
            ->where('user_id', '=', $user_id);
        Compare::destroy($compare_list);

        return response([
            'message' => 'Compare list deleted'
        ]);
    }

    /**
     * @param Request $reques
     * @return \Illuminate\Http\Response
     */
    public function deleteOne(Request $request): object
    {
        $user_id = Auth::id();
        $product_compare = Compare::all()
            ->where('user_id', '=', $user_id)
            ->where('product_id', '=', $request->product_id);
        Compare::destroy($product_compare);
        return response([
            'Message' => 'Deleted'
        ]);
    }
}
