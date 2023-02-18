<?php

namespace App\Http\Controllers;

use App\Models\Universities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
class UniversitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institutes = Universities::OrderBy('name', 'ASC')->get();
        return view('pages.others.institutes_index', compact('institutes'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:universities',            
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $institute = new Universities;
        $institute->name = $request->name;
        $institute->created_at = Carbon::now();
        $institute->save();

        return Redirect()->back()->with('success', 'New Institute Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Universities  $universities
     * @return \Illuminate\Http\Response
     */
    public function show(Universities $universities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Universities  $universities
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $institute = Universities::find($id);
        return view('pages.others.institutes_edit', compact('institute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Universities  $universities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $institute = Universities::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:universities,name,'.$institute->id,
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = array();
        $data['name']=$request->name;
        $update = Universities::where('id', $id)->update($data);

        if($update) {
            return redirect()->route('institute.index')->with('success', 'Institute Update Successfully.');
        }
        else {
            return redirect()->back()->with('error', 'Error occurred! Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Universities  $universities
     * @return \Illuminate\Http\Response
     */
    public function destroy(Universities $universities)
    {
        //
    }
}
