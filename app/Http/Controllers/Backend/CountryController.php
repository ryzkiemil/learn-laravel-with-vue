<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountryStoreRequest;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Database\QueryException;

class CountryController extends Controller
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
    
    public function index(Request $request) {
        $countries = Country::all();
        if( $request->has('search') ) {
            $countries = Country::where( 'country_code', 'like', "%{$request->search}%")->orWhere( 'name', 'like', "%{$request->search}%" )->get();
        }
        return view('countries.index', compact('countries'));
    }

    public function create() {
        return view('countries.create');
    }

    public function store(CountryStoreRequest $request) {
        Country::create($request->validated());
        return redirect()->route('countries.index')->with('message', 'adding country is success');
    }

    public function edit(Country $country) {
        return view('countries.edit', compact('country'));
    }
    
    public function update(CountryStoreRequest $request, Country $country) {
        $country->update($request->validated());

        return redirect()->route('countries.index')->with('message', 'updating country is success');
    }

    public function destroy(Country $country) {
        try{
            $country->delete();
            return redirect()->route('countries.index')->with('message', 'Delete country is success');
        }catch(QueryException $e){
            // $error = $e->errorInfo[2];echo $error;
            return redirect()->route('countries.index')->with('error', 'Delete country is Failed');
        }
    }
}
