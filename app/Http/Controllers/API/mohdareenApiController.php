<?php

namespace App\Http\Controllers\API;

use App\mohdr;
use App\category;
use App\Permission;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
class mohdareenApiController extends Controller

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

                $enabled = $permission->mohdreen;
                if ($enabled == 'yes') {
                    $mohdrs = null;
                    $categories = null;


                    if ($user->parent_id !=null) {
                        $mohdrs = mohdr::query()->where('parent_id',  $user->parent_id)->get();
                    } else {
                        $mohdrs = mohdr::query()->where('parent_id',  $user->id)->get();
                    }

                    return $this->sendResponse(200, ' ',array('mohdrs'=>$mohdrs));
                } else {
                    return $this->sendResponse(403, 'لا تتملك الصلاحيه لدخول هذه الصفحه',null);
                }
            }else{
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ',null);
            }
        }
    }
    public function store(Request $request)
    {
        $input = $request->all();

        $validate  =   $this->makeValidate($input,
            [
                'api_token'=>'required',
                'court_mohdareen' => 'required',
                'paper_type' => 'required',
                'deliver_data' => 'required',
                'paper_Number' => 'required',
                'session_Date' => 'required',
                'mokel_Name' => 'required|exists:clients,client_name',
                'khesm_Name' => 'required|exists:clients,client_name',
                'case_number' => 'required',
                'cat_id' => 'required|exists:categories,id',
                'notes' => 'required',

            ]);

        if (!is_array($validate))
        {

            $api_token =$request->input('api_token');
            $auth_user = User::where('api_token',$api_token)->first();
            if(empty($auth_user))
            {
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ',null);
            }
            if ($auth_user->parent_id !=null)
            {
                $input['parent_id'] = $auth_user->parent_id;
            }
            else
            {
                $input['parent_id'] = $auth_user->id;
            }
            $mohdr= mohdr::create($input);

            return $this->sendResponse(200, 'تم الاضافه بنجاح' ,$mohdr);
        }
        else
        {
            return $this->sendResponse(403, $validate ,null);
        }

    }

    public function update(Request $request)
    {

        $input = $request->all();
        $id = $request->moh_id;
//        dd($request->moh_id);
        $validate  =   $this->makeValidate($input,
            [
                'api_token'=>'required',
                'moh_id'=>'required|exists:mohdrs,moh_id',
                'court_mohdareen' => 'required',
                'paper_type' => 'required',
                'deliver_data' => 'required',
                'paper_Number' => 'required',
                'session_Date' => 'required',
                'mokel_Name' => 'required',
                'khesm_Name' => 'required',
                'case_number' => 'required',
                'cat_id' => 'required',
                'notes' => 'required',

            ]);

        if (!is_array($validate))
        {

            $api_token =$request->input('api_token');
            $auth_user = User::where('api_token',$api_token)->first();
            if(empty($auth_user))
            {
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ',null);
            }

            $mohdrs = mohdr::find(intval($id))->update($input);

            return $this->sendResponse(200, 'تم التعديل  بنجاح' ,$mohdrs);
        }
        else
        {
            return $this->sendResponse(403, $validate ,null);
        }

    }

    public function destroy(Request $request)
    {
        $input = $request->all();
        $id = $request->moh_id;
        $validate  =   $this->makeValidate($input,
            [
                'api_token'=>'required',
                'moh_id'=>'required|exists:mohdrs,moh_id',

            ]);
        if (!is_array($validate))
        {

            $api_token =$request->input('api_token');
            $auth_user = User::where('api_token',$api_token)->first();
            if(empty($auth_user))
            {
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ',null);
            }

            $permission = Permission::where('user_id',$id)->delete();
            $mohdr = mohdr::find(intval($id))->delete();

            return $this->sendResponse(200, 'تم حذف المٌحضر  بنجاح' ,$mohdr);
        }
        else
        {
            return $this->sendResponse(403, $validate ,null);
        }


    }
}
