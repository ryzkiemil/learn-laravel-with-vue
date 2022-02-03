<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeSingleResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = Employee::all();
        // if($request->has('search') && ($request->has('search') != null) ) {
        //     $employees = Employee::Where('first_name', 'like', "%{$request->search}%")
        //                             ->orWhere('last_name', 'like', "%{$request->search}%")->get();
        // } elseif ($request->department_id) {
        //     $employees = Employee::where('department_id', $request->department_id)->get();
        // }
        if(($request->has('search')) && ($request->search != null) && ($request->department_id)) {
            $employees = Employee::join('departments', 'employees.department_id', '=', 'departments.id')
                                    ->Where('employees.first_name', 'like', "%{$request->search}%")
                                    ->orWhere('employees.last_name', 'like', "%{$request->search}%")
                                    ->Where('departments.id', $request->department_id)
                                    ->get();
        } elseif (($request->has('search')) && ($request->search != null) ) {
                $employees = Employee::Where('first_name', 'like', "%{$request->search}%")
                                        ->orWhere('last_name', 'like', "%{$request->search}%")->get();
        } elseif ($request->department_id) {
            $employees = Employee::where('department_id', $request->department_id)->get();
        }
        return EmployeeResource::collection($employees);
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
    public function store(EmployeeStoreRequest $request)
    {
        $employee = Employee::create($request->validated());
        return response()->json($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return new EmployeeSingleResource($employee);
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
    public function update(EmployeeStoreRequest $request, Employee $employee)
    {
        $employee->update($request->validated());


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json('Update Employee is success');
    }
}
