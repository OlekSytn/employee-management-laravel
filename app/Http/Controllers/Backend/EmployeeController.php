<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $employees = Employee::orderByDesc('id')->get();
        
        if ($request->has('search')) {
            $employees = Employee::where('first_name', 'like', "%{$request->search}%")
                        ->orWhere('last_name', 'like', "%{$request->search}%")
                        ->get();
        }

        return $employees;
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
        $newEmployee = Employee::create([
            'last_name' => $request->lastName,
            'first_name' => $request->firstName,
            'middle_name' => $request->middleName,
            'address' => $request->address,
            'department_id' => $request->departmentId,
            'country_id' => $request->countryId,
            'state_id' => $request->stateId,
            'city_id' => $request->cityId,
            'zipcode' => $request->zipcode,
            // 'birthdate' => $request->birthdate,
            // 'date_hired' => $request->dateHired
        ]);

        return $newEmployee;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $existing = Employee::find($id);

        if ($existing) {
            $existing->last_name = $request->employee['lastName'];
            $existing->first_name = $request->employee['firstName'];
            $existing->middle_name = $request->employee['middleName'];
            $existing->address = $request->employee['address'];
            $existing->department_id = $request->employee['departmentId'];
            $existing->country_id = $request->employee['countryId'];
            $existing->state_id = $request->employee['stateId'];
            $existing->city_id = $request->employee['cityId'];
            $existing->zipcode = $request->employee['zipcode'];
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
        $deleted = Employee::find($id)->delete();
        return $deleted;
    }
}
