<?php

namespace App\Http\Controllers\API;

use App\Permission;
use App\User;
use App\attachment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class attachmentApiController extends Controller
{
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

    public function makeValidate($inputs,$rules)
    {

        $validator = Validator::make($inputs,$rules);
        if($validator->fails())
        {
            return $this->validationErrorsToString($validator->messages());
        }
        else
        {
            return true;
        }
    }

    public function index(Request $request)
    {
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
            $api_token = $request->input('api_token');
            $user = User::where('api_token',$api_token)->first();
            if($user != null){
                $user_id= $user->id;

                $permission = Permission::where('user_id', $user_id)->first();

                $enabled = $permission->search_case;
                if ($enabled == 'yes') {

                        $attachments = attachment::query()->where('case_id', $request->case_id)->get();


                    return $this->sendResponse(200, ' ',array('attachments'=>$attachments));
                } else {
                    return $this->sendResponse(403, 'لا تمتلك الصلاحيه لدخول هذه الصفحه',null);
                }
            }else{
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ',null);
            }
        }
    }

}
