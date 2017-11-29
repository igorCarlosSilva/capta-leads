<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HttpRequest extends Controller
{
    public $url;
    public $data;
    public $headers;


    public function get(){

    }

    public function post(){

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $this->data,
            CURLOPT_HTTPHEADER => $this->headers,
        ));


        $result = curl_exec($ch);

        curl_close($ch);

        return $result;

    }
}
