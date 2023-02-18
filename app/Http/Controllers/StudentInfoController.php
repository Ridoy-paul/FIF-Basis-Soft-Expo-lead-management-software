<?php

namespace App\Http\Controllers;

use App\Models\StudentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subjects;
use App\Models\Universities;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use DataTables;
class StudentInfoController extends Controller
{

    public function check_authenticate() {
        $user = Auth::user();
        if(optional($user)->is_active == 1) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->check_authenticate() != true) {
            return redirect()->back()->with('error', 'You can not access this page.');
        }

        return view('pages.students.index');
    }

    public function index_data(Request $request){
        if ($request->ajax()) {
            $user = Auth::user();
            if($user->type == 'admin') {
                $data = StudentInfo::orderBy('id', 'desc')->get();
            }
            else {
                $data = StudentInfo::Where('added_by', $user->id)->orderBy('id', 'desc')->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a href="'.route('student.edit', $row->id).'"   class="btn btn-primary btn-sm">Edit</a>';
                })
                ->addColumn('student_info', function($row){
                    return '<span>'.$row->name.', [ '.$row->phone.', '.optional($row)->email.' ]<br>'.optional($row)->address.'<br><b>Subject: </b>'.optional($row->subject_info)->name.'<br><b>Class: </b>'.optional($row)->class_or_semester.'<br><b>Institute: </b>'.optional($row->institute_info)->name.'<br><span class="badge badge-primary">'.optional($row)->interested_course.'</span></span>';
                })
                ->addColumn('added_by', function($row){
                    return '<span>'.optional($row->added_by_info)->name.'<br><b>Time: </b>'.date("d-m-Y h:i:s A", strtotime($row->date)).'</span>';
                })
                
                ->rawColumns(['action', 'student_info', 'added_by'])
                ->make(true);
        }
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if($this->check_authenticate() != true) {
            return redirect()->back()->with('error', 'You can not access this page.');
        }

        $subjects = Subjects::OrderBy('name', 'ASC')->get();
        $institutes = Universities::OrderBy('name', 'ASC')->get();
        return view('pages.students.create', compact('subjects', 'institutes'));
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->check_authenticate() != true) {
            return redirect()->back()->with('error', 'You can not access this page.');
        }

        $validator = Validator::make($request->all(), [
            'phone' => 'required|unique:student_infos',            
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $student = new StudentInfo;
        $student->name = $request->name;
        $student->phone = $request->phone;
        $student->email = $request->email;
        $student->address = $request->address;
        $student->subject_id = $request->subject_id;

        if($request->institute_id == 'add_new' & $request->institute_name != '') {
            $check_institute = Universities::Where('name', $request->institute_name)->first();
            if(!is_null($check_institute)) {
                $student->institute_id = $check_institute->id;
            }
            else {
                $new_institute = new Universities;
                $new_institute->name = $request->institute_name;
                $new_institute->created_at = Carbon::now();
                $new_institute->save();
                $student->institute_id = $new_institute->id;
            }
        }
        else {
            $student->institute_id = $request->institute_id;
        }

        $student->class_or_semester = $request->class_or_semester;
        $student->interested_course = $request->interested_course;
        $student->added_by = Auth::user()->id;
        $student->date = Carbon::now();
        $student->save();
        return redirect()->route('student.index')->with('success', 'Registion Complete.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentInfo  $studentInfo
     * @return \Illuminate\Http\Response
     */
    public function show(StudentInfo $studentInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentInfo  $studentInfo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($this->check_authenticate() != true) {
            return redirect()->back()->with('error', 'You can not access this page.');
        }

        $subjects = Subjects::OrderBy('name', 'ASC')->get();
        $institutes = Universities::OrderBy('name', 'ASC')->get();
        $studentInfo = StudentInfo::find($id);
        return view('pages.students.edit', compact('studentInfo', 'subjects', 'institutes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentInfo  $studentInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($this->check_authenticate() != true) {
            return redirect()->back()->with('error', 'You can not access this page.');
        }

        $student = StudentInfo::find($id);

        $validator = Validator::make($request->all(), [
            'phone' => 'required|unique:student_infos,phone,'.$student->id,
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $student->name = $request->name;
        $student->phone = $request->phone;
        $student->email = $request->email;
        $student->address = $request->address;
        $student->subject_id = $request->subject_id;

        if($request->institute_id == 'add_new' & $request->institute_name != '') {
            $check_institute = Universities::Where('name', $request->institute_name)->first();
            if(!is_null($check_institute)) {
                $student->institute_id = $check_institute->id;
            }
            else {
                $new_institute = new Universities;
                $new_institute->name = $request->institute_name;
                $new_institute->created_at = Carbon::now();
                $new_institute->save();
                $student->institute_id = $new_institute->id;
            }
        }
        else {
            $student->institute_id = $request->institute_id;
        }

        $student->class_or_semester = $request->class_or_semester;
        $student->interested_course = $request->interested_course;
        $student->update();
        return redirect()->route('student.index')->with('success', 'Student Info Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentInfo  $studentInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentInfo $studentInfo)
    {
        //
    }
}