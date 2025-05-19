<?php

namespace App\Helpers;



class ApiResponse
{


    static function sendResponse($code, $message, $data)
    {
        $response = [
            'status' => $code,
            'message' => $message,
            'data' => $data
        ];
        return response()->json($response, $code);
    }
}
