<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessData extends Model
{
    use HasFactory;

    public function added_by_info() {
        return $this->belongsTo(User::class, 'added_by');
    }

    //send sms
    public static function send_sms($msg, $number) {
        $number = preg_replace('#[ -]+#', '', $number);
        $number = preg_replace('#[=]+#', '', $number);
        if(strlen($number)==10 || strlen($number)==13){
            $number = "0".$number; 
        }
        $msg = str_replace("<br>","\n",$msg);
        $msg = strip_tags($msg);
        $url = "https://isms.mimsms.com/smsapi";
        $data = [
            "api_key" => env('SMS_API_KEY'),
            "type" => "text",
            "contacts" => $number,
            "senderid" => env('SMS_SENDER_ID'),
            "msg" => $msg,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }



}
