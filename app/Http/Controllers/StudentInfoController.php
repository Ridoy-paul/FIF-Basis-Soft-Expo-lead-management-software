<?php

namespace App\Http\Controllers;

use App\Models\BusinessData;
use App\Models\StudentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subjects;
use App\Models\Universities;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Twilio\Rest\Client;
//require_once "Twilio/autoload.php";


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
                $data = BusinessData::orderBy('id', 'desc')->get();
            }
            else {
                $data = BusinessData::Where('added_by', $user->id)->orderBy('id', 'desc')->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a href="'.route('visitor.edit', $row->id).'"   class="btn btn-primary btn-sm">Edit</a>';
                })
                ->addColumn('visitor_info', function($row){
                    return '<span>'.$row->name.', [ '.$row->phone.', '.optional($row)->email.' ]<br>'.optional($row)->address.'</span>';
                })
                ->addColumn('added_by', function($row){
                    return '<span>'.optional($row->added_by_info)->name.'<br>'.date("d-m-Y h:i:s A", strtotime($row->created_at)).'</span>';
                })
                
                ->rawColumns(['action', 'visitor_info', 'added_by'])
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

        //$subjects = Subjects::OrderBy('name', 'ASC')->get();
        //$institutes = Universities::OrderBy('name', 'ASC')->get();
        return view('pages.students.create');
    }


    public function send_sms($number, $name) {
        $msg = 'Thank you Mr. '.$name.', for visiting Fara IT Limited at Basis Softexpo. For any kind of query please visit: www.faraitltd.com or call our hotline: 01780504501';
        $send_sms = BusinessData::send_sms($msg, $number);
        //return $send_sms;
    }

    public function send_email($name, $email) {
        $details = [
            'name' => $name,
            'email' => $email,
        ];
        $mail_status = Mail::send(new SendMail($name, $email));
        return $mail_status;
    }

    public function whatsappNotification(string $recipient)
    {
        $sid    = getenv("TWILIO_AUTH_SID");
        $token  = getenv("TWILIO_AUTH_TOKEN");
        $wa_from= getenv("TWILIO_WHATSAPP_FROM");
        $twilio = new Client($sid, $token);
        
        $body = "Hello, welcome to codelapan.com.";

        return $twilio->messages->create("whatsapp:$recipient",["from" => "whatsapp:$wa_from", "body" => $body]);
    }

    public function send_whatsapp_mesage($name, $phone) {

            $sid    = env("TWILIO_AUTH_SID"); 
            $token  = env("TWILIO_AUTH_TOKEN"); 
            $twilio = new Client($sid, $token); 
            
            $message = $twilio->messages 
                            ->create("whatsapp:+88".$phone, // to 
                                    array( 
                                        "from" => "whatsapp:+14155238886",       
                                        "body" => "Thank you Mr. ".$name.", for visiting Fara IT Limited at Basis Softexpo. For any kind of query please visit: www.faraitltd.com or call our hotline: 01780504501." 
                                    ) 
                            ); 
            
            //print($message->sid);

        //$send_sms = BusinessData::send_whatsapp();
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

        return $this->send_whatsapp_mesage($request->name, $request->phone);
        return 0;

        $validator = Validator::make($request->all(), [
            'phone' => 'required|unique:business_data',            
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = new BusinessData;
        $data->name = $request->name;
        $data->company_name = $request->company_name;
        $data->designation = $request->designation;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->interested_service = $request->interested_service;
        
        $data->note = $request->note;
        $data->added_by = Auth::user()->id;
        $data->created_at = Carbon::now();
        $status = $data->save();
        if($status) {
            $this->send_sms($request->phone, $request->name);
            if($request->email <> '') {
                $this->send_email($request->name, $request->email);
            }
        }

        return redirect()->route('visitor.index')->with('success', 'Registion Complete.');

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
            'phone' => 'required|unique:visitor_infos,phone,'.$student->id,
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
