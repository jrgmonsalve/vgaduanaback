<?php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * $data must be array
     */
    public function successful($data,$code=200,$message=""){
        
        $response = [
                    "success"=> true,
                    "message"=> $message,
                    "data"=> $data
                ];

        return response()->json($response,$code);
        
    }


    public function fail($message,$code=400,$data=[]){

        $response = [
                    "success"=> false,
                    "message"=> $message,
                    "error_code"=> $code,
                    "data"=> $data
                ];
         return response()->json($response,$code);

    }
}