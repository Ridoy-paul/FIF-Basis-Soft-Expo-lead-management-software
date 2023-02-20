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
                // ->addColumn('action', function($row){
                //     return '<a href="'.route('visitor.edit', $row->id).'"   class="btn btn-primary btn-sm">Edit</a> <a href="'.route('visitor.send.message', ['what'=>'whatsapp', 'id'=>$row->id]).'"   class="btn btn-success btn-rounded btn-sm"><i class="nav-main-link-icon fab fa-whatsapp"></i></a> <a href="'.route('visitor.send.message', ['what'=>'sms', 'id'=>$row->id]).'"   class="btn btn-warning btn-rounded btn-sm"><i class="nav-main-link-icon fas fa-sms"></i></a> <a href="'.route('visitor.send.message', ['what'=>'mail', 'id'=>$row->id]).'"   class="btn btn-dark btn-rounded btn-sm"><i class="nav-main-link-icon fas fa-envelope"></i></a>';
                // })
                ->addColumn('visitor_info', function($row){
                    $output = '<span>'.$row->name.', [ '.$row->phone.', '.optional($row)->email.' ]<br>'.optional($row)->address.'</span>';
                    $output .= '<br><a href="'.route('visitor.edit', $row->id).'" class="btn btn-primary btn-rounded btn-sm"><i class="fas fa-edit"></i></a> <a href="'.route('visitor.send.message', ['what'=>'whatsapp', 'id'=>$row->id]).'"   class="btn btn-success btn-rounded btn-sm"><i class="nav-main-link-icon fab fa-whatsapp"></i></a> <a href="'.route('visitor.send.message', ['what'=>'sms', 'id'=>$row->id]).'"   class="btn btn-warning btn-rounded btn-sm"><i class="nav-main-link-icon fas fa-sms"></i></a> <a href="'.route('visitor.send.message', ['what'=>'mail', 'id'=>$row->id]).'"   class="btn btn-dark btn-rounded btn-sm"><i class="nav-main-link-icon fas fa-envelope"></i></a>';
                    return $output;
                })
                ->addColumn('added_by', function($row){
                    return '<span>'.optional($row->added_by_info)->name.'<br>'.date("d-m-Y h:i:s A", strtotime($row->created_at)).'</span>';
                })
                
                ->rawColumns([ 'visitor_info', 'added_by'])
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
        $mail_status = Mail::to($email)->send(new SendMail($details));
        return $mail_status;
    }

    // public function whatsappNotification(string $recipient)
    // {
    //     $sid    = getenv("TWILIO_AUTH_SID");
    //     $token  = getenv("TWILIO_AUTH_TOKEN");
    //     $wa_from= getenv("TWILIO_WHATSAPP_FROM");
    //     $twilio = new Client($sid, $token);
        
    //     $body = "Hello, welcome to codelapan.com.";

    //     return $twilio->messages->create("whatsapp:$recipient",["from" => "whatsapp:$wa_from", "body" => $body]);
    // }

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
            $this->send_whatsapp_mesage($request->name, $request->phone);
            if($request->email <> '') {
                $this->send_email($request->name, $request->email);
            }
        }

        return redirect()->route('visitor.create')->with('success', 'Registion Complete.');

    }

    public function send_individual_message($what, $id) {
        if($this->check_authenticate() != true) {
            return redirect()->back()->with('error', 'You can not access this page.');
        }

        $visitor_info = BusinessData::find($id);
        if(is_null($visitor_info)) {
            return redirect()->back()->with('error', 'Invalid visitor info.');
        }

        if($what == 'whatsapp') {
            $this->send_whatsapp_mesage($visitor_info->name, $visitor_info->phone);
            return redirect()->back()->with('success', 'WhatsApp message sent successfully.');
        }
        else if($what == 'mail') {
            if($visitor_info->email <> null) {
                $this->send_email($visitor_info->name, $visitor_info->email);
                return redirect()->back()->with('success', 'Email sent successfully.');
            }
            else {
                return redirect()->back()->with('error', 'No Email Found!');
            }
        }
        else if($what == 'sms') {
            $this->send_sms($visitor_info->phone, $visitor_info->name);
            return redirect()->back()->with('success', 'SMS sent successfully.');
        }
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

        $visitor_info = BusinessData::find($id);
        return view('pages.students.edit', compact('visitor_info'));
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

        $data = BusinessData::find($id);

        $validator = Validator::make($request->all(), [
            'phone' => 'required|unique:business_data,phone,'.$data->id,
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data->name = $request->name;
        $data->company_name = $request->company_name;
        $data->designation = $request->designation;
        $data->phone = $request->phone;
        $data->email = $request->email;

        $data->address = $request->address;
        $data->interested_service = $request->interested_service;
        
        $data->note = $request->note;
        $data->update();
        return redirect()->route('visitor.index')->with('success', 'Visitor Info Updated.');
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
