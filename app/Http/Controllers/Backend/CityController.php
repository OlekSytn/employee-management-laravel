<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = DB::table('cities')
                    ->join('states', 'state_id', '=', 'states.id')
                    ->join('countries', 'states.country_id', '=', 'countries.id')
                    ->select('cities.*', 'states.name as s_name', 'countries.name as c_name')
                    ->get();
        
        return $cities;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newCity = City::create([
            'state_id' => $request->stateId,
            'name' => $request->name
        ]);

        return $newCity;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cities = DB::table('cities')
                    ->join('states', 'state_id', '=', 'states.id')
                    ->where('cities.state_id', '=', $id)
                    ->select('cities.*')
                    ->get();

        return $cities;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $existing = City::find($id);

        if ($existing) {
            $existing->state_id = $request->city['stateId'];
            $existing->name = $request->city['name'];
            $existing->save();

            return $existing;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = City::find($id)->delete();
        return $deleted;
    }
}
