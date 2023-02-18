<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Image;

class CRMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $crms = User::Where('type', 'crm')->OrderBy('id', 'DESC')->get();
        return view('pages.crm.index', compact('crms'));
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
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed|min:8',
            
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = array();
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['type']= 'crm';
        $data['email_verified_at']= Carbon::now();
        $data['is_active']= 1;
        $data['password']=Hash::make($request->password);

        $insert = DB::table('users')->insert($data);

        if($insert) {
            return Redirect()->back()->with('success', 'CRM Added Successfully.');
        }
        else {
            return Redirect()->back()->with('error', 'Error occurred! Please try again.');
        }

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
        $user_info = User::find($id);
        return view('pages.crm.edit', compact('user_info'));
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
        
        $crm_info = User::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|max:255|unique:users,email,'.$crm_info->id,
            
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = array();
        $data['name']=$request->name;
        $data['email']=$request->email;
        
        $update_crm = User::where('id', $id)->update($data);

        if($update_crm) {
            return redirect()->route('admin.crm')->with('success', 'CRM Update Successfully.');
        }
        else {
            return redirect()->back()->with('error', 'Error occurred! Please try again.');
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
        //
    }

    //Begin:: Deactive CRM
    public function DeactiveCRM($id) {
        $data = array(
            'is_active' => 0,
        );
        $Q = User::where('id', $id)->update($data);
        if($Q) {
            return Redirect()->back()->with('success', 'CRM Deactive Successfully.');
        }
        else {
            return Redirect()->back()->with('error', 'Error occurred! Please try again.');
        }
    }
    //End:: Deactive CRM

    //Begin:: Active CRM
    public function ActiveCRM($id) {
        $data = array(
            'is_active' => 1,
        );

        $Q = User::where('id', $id)->update($data);
        if($Q) {
            return Redirect()->back()->with('success', 'CRM Active Successfully.');
        }
        else {
            return Redirect()->back()->with('error', 'Error occurred! Please try again.');
        }
    }
    //End:: Active CRM

}
