<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityStoreRequest;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;
use Illuminate\Database\QueryException;

class CityController extends Controller
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
        $cities = City::all();
        if($request->has('search')) {
            $cities = City::Where('name', 'like', "%{$request->search}%")->get();
        }
        return view('cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::all();
        
        return view('cities.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityStoreRequest $request)
    {
        City::create($request->validated());
        
        return redirect()->route('cities.index')->with('message', 'Adding new city is success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        $states = State::all();
        return view('cities.edit', compact('city','states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CityStoreRequest $request, City $city)
    {
        $city->update([
            'state_id'  => $request->state_id,
            'name'      => $request->name,
        ]);

        return redirect()->route('cities.index')->with('message', 'Updating city is success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        try{
            $city->delete();
            return redirect()->route('cities.index')->with('message', 'Deleting city is success');
        }catch(QueryException $e){
            // $error = $e->errorInfo[2];echo $error;
            return redirect()->route('cities.index')->with('error', 'Deleting city is failed');
        }
    }
}
