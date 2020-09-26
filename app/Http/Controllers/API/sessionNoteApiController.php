<?php

namespace App\Http\Controllers\API;

use App\Permission;
use App\Session_Notes;
use App\Sessions;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class sessionNoteApiController extends Controller
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
            'session_id'=>'required|exists:sessions,id',
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
                    $session_Notes = Session_Notes::where("session_id", "=", $request->session_id)->get();


                    return $this->sendResponse(200, 'تم',array('session_Notes'=>$session_Notes));
                } else {
                    return $this->sendResponse(403, 'لا تمتلك الصلاحيه لدخول هذه الصفحه',null);
                }
            }else{
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ',null);
            }
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validate = null;
        $validate_api = $this->makeValidate($input,
            [
                'api_token' => 'required',

            ]);
        if (!is_array($validate_api)) {
            $api_token = $request->input('api_token');
            $auth_user = User::where('api_token', $api_token)->first();
            if (empty($auth_user)) {
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ', null);
            }
            if ($auth_user->type == 'User') {
                $validate = $this->makeValidate($input,
                    [
                        'note' => 'required',
                        'session_Id' => 'required|exists:sessions,id',
                    ]);
                $input['parent_id'] = $auth_user->parent_id;
            } else {
                $validate = $this->makeValidate($input,
                    [
                        'note' => 'required',
                        'session_Id' => 'required|exists:sessions,id',
                    ]);
                $input['parent_id'] = $auth_user->id;
            }
            if (!is_array($validate)) {
                if ($request->note != null ) {
                    $session_Notes = Session_Notes::create($input);

                    return $this->sendResponse(200, 'تم الاضافه بنجاح', $session_Notes);
                } else {

                    return $this->sendResponse(403, "من فضلك قم بأختيار تاريخ الجلسة",null);
                }

            } else {
                return $this->sendResponse(403, $validate, null);
            }
        }
        return $this->sendResponse(403, "برجاء تسجيل الدخول", null);
    }

    public function changeNoteStatus(Request $request)
    {

        $input = $request->all();
        $id = $request->note_id;
        $validate  =   $this->makeValidate($input,
            [
                'api_token'=>'required',
                'note_id'=>'required|exists:Session__Notes,id',
            ]);

        if (!is_array($validate))
        {

            $api_token =$request->input('api_token');
            $auth_user = User::where('api_token',$api_token)->first();
            if(empty($auth_user))
            {
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ',null);
            }

            $status = false;
            $session_Notes = Session_Notes::find($id);
            if ($session_Notes->status== trans('site_lang.public_no_text')) {
                $session_Notes->status = "Yes";
                $status = true;
            } else {
                $session_Notes->status = "No";
                $status = false;
            }
            $session_Notes->update();

            return $this->sendResponse(200, 'تم التعديل  الحالة بنجاح' ,$status);
        }
        else
        {
            return $this->sendResponse(403, $validate ,null);
        }
    }

    public function edit(Request $request)
    {

        $input = $request->all();
        $id = $request->note_Id;
        $validate  =   $this->makeValidate($input,
            [
                'api_token'=>'required',
                'note' => 'required',
                'note_Id' => 'required|exists:Session__Notes,id',

            ]);

        if (!is_array($validate))
        {

            $api_token =$request->input('api_token');
            $auth_user = User::where('api_token',$api_token)->first();
            if(empty($auth_user))
            {
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ',null);
            }

            $session_Notes = Session_Notes::find(intval($id))->update($input);

            return $this->sendResponse(200, 'تم التعديل  بنجاح' ,$session_Notes);
        }
        else
        {
            return $this->sendResponse(403, $validate ,null);
        }

    }

    public function destroy(Request $request)
    {
        $input = $request->all();
        $validate  =   $this->makeValidate($input,
            [
                'api_token'=>'required',
                'session_note_id'=>'required|exists:Session__Notes,id',

            ]);
        if (!is_array($validate))
        {

            $api_token =$request->input('api_token');
            $auth_user = User::where('api_token',$api_token)->first();

            if(empty($auth_user))
            {
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ',null);
            }
            $user_id= $auth_user->id;
            $permission = Permission::where('user_id', $user_id)->first();

            $enabled = $permission->search_case;
            if ($enabled == 'yes') {

                $session_Note = Session_Notes::find(intval($request->session_note_id))->delete();

                return $this->sendResponse(200, 'تم حذف ملاحظة الجلسة' ,$session_Note);
            } else {
                return $this->sendResponse(403, 'لا تمتلك الصلاحيه لدخول هذه الصفحه',null);
            }



        }
        else
        {
            return $this->sendResponse(403, $validate ,null);
        }

    }

}
