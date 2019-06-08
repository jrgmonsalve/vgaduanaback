<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function successful(){
        

        $response = [
                    "success"=> true,
                    "message"=> "",
                    "data"=> []
                ];

        return response()->json($response);
        
    }

    public function fail(){

        $response = [
                    "success"=> false,
                    "message"=> "",
                    "error_code"=> "",
                    "data"=> []
                ];
         return response()->json($response);

    }
}