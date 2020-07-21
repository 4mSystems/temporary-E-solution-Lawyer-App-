<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Validator;
use Auth; 
use App\Permission;


class AuthController extends Controller
{
    public $objectName;


    public function __construct(User $model){
        $this->objectName = $model;

    }
    public function sendResponse($code=null,$msg=null, $data = null)
     {
         
             return response(
                 [
                     'code' => $code,
                     'msg'=>$msg,
                     'data' => $data
                 ]
             );
          
     }

     public function validationErrorsToString($errArray)
     {
         $valArr = array();
         foreach ($errArray->toArray() as $key => $value) { 
              $errStr = $value[0]; 
             array_push($valArr, $errStr);
         } 
         return $valArr;
     }

     
     public function login(Request $request)
       {
     $rules = [
         'email'=>'required|email',
         'password'=>'required',
     ];
     $validator = Validator::make($request->all(),$rules);
     if($validator->fails())
     {
         return $this->sendResponse(401, $this->validationErrorsToString($validator->messages()),null);
     }
     else
     {

         if(Auth::attempt([
         'email'=>$request->input('email'),
         'password'=>$request->input('password')
         ]))
         {


             $user = auth()->user();

             $user->api_token = str_random(60);
             $api_token = $user->api_token;
             $user->save();
            $permission = Permission::where('user_id',$user->id)->first();
             
              return $this->sendResponse(200, 'تم تسجيل الدخول بنجاح',array('user'=>$user,'permission'=>$permission));  
         }
         else
         {
             return $this->sendResponse(401, 'البريد الالكترونى او الرقم السري غير صحيح',null);
         }
     }
 }
 public function logout(Request $request){
    $rules = [
        'api_token'=>'required',
        
    ];
    $validator = Validator::make($request->all(),$rules);
    if($validator->fails())
    {
        return $this->sendResponse(401, 'يرجى تسجيل الدخول ',null);
    }
    else
    {
                $api_token =$request->input('api_token');
                $user = User::where('api_token',$api_token)->first();

                if(empty($user)){
                    return $this->sendResponse(403, 'يرجى تسجيل الدخول ',null);
                }


            $user->api_token = null;
                if($user->save()){
                    return $this->sendResponse(200, 'تم تسجيل الخروج بنجاح',null);
                }else{
                    return $this->sendResponse(401, 'يرجى تسجيل الدخول ',null);
                }
    }
 }



 
}
