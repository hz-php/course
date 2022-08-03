<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomeCreateRequest;
use App\Http\Resources\HomeResource;
use App\Models\Credit;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): object
    {
        $homes = \Cache::remember('homes', 60*60*12, function () {
            return Home::all();
        });

        return response([
            'Homes' => HomeResource::collection($homes),
            'message' => 'Success'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeCreateRequest $request): object
    {
        $data = $request->all();

        $data['seller_id'] = Auth::user()->id;
        $home = Home::create($data);

        return response([
            'home' => new HomeResource($data),
            'message' => 'Success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Home $home
     * @return \Illuminate\Http\Response
     */
    public function show($id): object
    {
        $home = Home::findOrFail($id);
        $credits = Credit::select('name_bank', 'percent', 'name_credit')
            ->where('min_summ', '<=', $home->currency)
            ->where('max_summ', '>=', $home->currency)
            ->get();
        return response([
            'home' => new HomeResource($home),
            'banks' => $credits,
            'message' => 'Succes'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Home $home
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Home $home): object
    {
        $home->update($request->all());

        return response([
            'home' => new HomeResource($home),
            'message' => 'Success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Home $home
     * @return \Illuminate\Http\Response
     */
    public function destroy(Home $home)
    {
        $home->delete();

        return response(['message' => 'Home deleted']);
    }
}
