<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use Illuminate\Support\Facades\DB;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $states = State::all();
        $states = DB::table('states')
                    ->join('countries', 'country_id', '=', 'countries.id')
                    ->select('states.*', 'countries.name as c_name')
                    ->get();
        
        return $states;
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
        $newState = State::create([
            'country_id' => $request->countryId,
            'name' => $request->name
        ]);

        return $newState;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $states = DB::table('states')
                    ->join('countries', 'country_id', '=', 'countries.id')
                    ->where('states.country_id', '=', $id)
                    ->select('states.*')
                    ->get();
        
        return $states;
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
        $existing = State::find($id);

        if ($existing) {
            $existing->country_id = $request->state['countryId'];
            $existing->name = $request->state['name'];
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
        $deleted = State::find($id)->delete();
        return $deleted;
    }
}
