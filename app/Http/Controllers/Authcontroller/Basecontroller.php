<?php

namespace App\Http\Controllers\Authcontroller;

use App\Http\Controllers\Controller;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;

class Basecontroller extends Controller
{
    public function sendresponse($result, $message)
    {
        $response = [
            'success' => true,
            'Data' => $result,
            'message' => $message
        ];
        return response()->json($response, 200);
    }

    public function senderror($error, $errormessage = [], $code = 404)
    {
        $response = [
            'success' => false,
            'data' => $error,
            'status' =>'404 Not Found'
        ];
        if (!empty($errormessage)) {
            $response['data'] = $errormessage;
            return response()->json($response, $code);
        }
    }
}
