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

    public static function send_whatsapp() {
        
        $phone='+8801880884848';
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://graph.facebook.com/v15.0/112279381787412/messages',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "messaging_product": "whatsapp",
            "to": '. $phone.',
            "type": "template",
            "template": {
                "name": "hello_world",
                "language": {
                    "code": "en_US"
                }
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer EAAWMZCLo6xD8BAKSlWk8mLcp4UEZC1ENlIw0RNRSDMV3x2T5daepqr81ZCUC4eOBA1LaziViZC09mVZCucHgXxrqEbYx9J8LHRuJGXgrkptiXAEaqv2fzbxlVM6AjKEvq9QZAo2ghLE6eAwepmma7t0vgdYIXtgBv5fqsrUrE1ZBuNoKjUQ7yblDZAiA1cAYqywBeHbI8ZCbjQwZDZD',
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        echo $response;

    }



}
