<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function success($data,$message='success',$code=200){
        return Response([
            'success'=>true,
            'message'=>$message,
            'data'=>$data
        ],$code);
    }
    public function failure($errors,$message='error',$code=400){
        return response([
          'success'=>false,
          'message'=>$message,
          'error'=>$errors
        ],$code);
  }
}
