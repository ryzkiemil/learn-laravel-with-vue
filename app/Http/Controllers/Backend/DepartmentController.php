<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentStoreRequest;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Database\QueryException;

class DepartmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departments = Department::all();
        if($request->has('search')) {
            $departments = Department::Where('name', 'like', "%{$request->search}%")->get();
        }
        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentStoreRequest $request)
    {
        Department::create($request->validated());

        return redirect()->route('departments.index')->with('message','Adding department is success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        return view('departments.edit',compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentStoreRequest $request, Department $department)
    {
        $department->update([
            'name' =>$request->name,
        ]);
        return redirect()->route('departments.index')->with('message','Updating department is success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        try{
            $department->delete();
            return redirect()->route('departments.index')->with('message', 'Deleting department is success');
        }catch(QueryException $e){
            // $error = $e->errorInfo[2];echo $error;
            return redirect()->route('departments.index')->with('error', 'Deleting department is failed');
        }
    }
}
