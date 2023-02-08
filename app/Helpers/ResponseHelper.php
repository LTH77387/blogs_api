<?php
namespace App\Helpers;
class ResponseHelper {
    public static function success($data=[],$msg="success"){
        return response()->json([
            'data'=>$data,
            'message'=>$msg,
        ],200);
    }

public static function validationFail ($msg){
    return response()->json([
        'message'=>$msg,
    ],422);
}
}

?>
