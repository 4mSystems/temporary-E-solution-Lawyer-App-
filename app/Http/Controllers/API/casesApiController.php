<?php

namespace App\Http\Controllers\API;

use App\attachment;
use App\mohdr;
use App\Permission;
use App\Session_Notes;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Case_client;
use App\Cases;
use App\Sessions;
use Validator;

class casesApiController extends Controller
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

    //Cases Functions
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
                    $cases= null;

                    if ($user->parent_id !=null) {

                        $cases = Cases::query()
                            ->where('to_whome', '=', $user->cat_id)
                            ->where('parent_id', '=', $user->parent_id)
                            ->with('clients')
                            ->get();
                    } else {
                        $cases = Cases::query()->with('clients')
                            ->where('parent_id', '=',$user->id)
                            ->get();
                    }

                    return $this->sendResponse(200, 'تم',array('cases'=>$cases));
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
                        'invetation_num' => 'required',
                        'circle_num' => 'required',
                        'first_session_date' => 'required',
                        'inventation_type' => 'required',
                        'descion' => 'required',
                        'court' => 'required',
                        'mokel_Name' => 'exists:clients,id',
                        'khesm_Name' => 'exists:clients,id',
                    ]);
                $input['to_whome'] = $auth_user->cat_id;
                $input['parent_id'] = $auth_user->parent_id;
            } else {
                $validate = $this->makeValidate($input,
                    [
                        'invetation_num' => 'required',
                        'circle_num' => 'required',
                        'first_session_date' => 'required',
                        'inventation_type' => 'required',
                        'descion' => 'required',
                        'court' => 'required',
                        'mokel_Name' => 'exists:clients,id',
                        'khesm_Name' => 'exists:clients,id',
                    ]);
                $data['to_whome'] = $request->to_whome;
                $input['parent_id'] = $auth_user->id;

            }

            if (!is_array($validate)) {
//                $input['parent_id']= getQuery();
                if ($request->mokel_Name != null && $request->khesm_Name != null) {
                    $month = date('m', strtotime($request->first_session_date));
                    $year = date('Y', strtotime($request->first_session_date));
//            // saving case data

                    $case = Cases::create($input);
                    $case['month'] = $month;
                    $case['year'] = $year;
                    $case->save();
                    //saving session data
                    $sessions = new Sessions();
                    $sessions->session_date = $request->first_session_date;
                    $sessions->case_Id = $case->id;
                    $sessions->month = $month;
                    $sessions->year = $year;

                    if ($auth_user->parent_id != null) {
                        $sessions->parent_id = $auth_user->parent_id;
                    } else {
                        $sessions->parent_id = $auth_user->id;
                    }
                    $sessions->save();
                    // saving case clients data

                    $res = array_merge($request->mokel_Name, $request->khesm_Name);

                    foreach ($res as $client) {
                        Case_client::create(['case_id' => $case->id, 'client_id' => $client]);
                    }
                    return $this->sendResponse(200, 'تم الاضافه بنجاح', $case);
                } else {

                    return $this->sendResponse(403, "من فضلك قم بافراغ خانه الموكلين والخصوم واخترهم",null);
                }

            } else {
                return $this->sendResponse(403, $validate, null);
            }
        }
        return $this->sendResponse(403, "برجاء تسجيل الدخول", null);
    }

    public function update(Request $request)
    {

        $input = $request->all();
        $id = $request->case_id;
//        dd($request->moh_id);
        $validate  =   $this->makeValidate($input,
            [
                'api_token'=>'required',
                'case_id'=>'required|exists:cases,id',
                'invetation_num' => 'required',
                'circle_num' => 'required',
                'court' => 'required',
                'inventation_type' => 'required',
                'to_whome' => 'required'

            ]);

        if (!is_array($validate))
        {

            $api_token =$request->input('api_token');
            $auth_user = User::where('api_token',$api_token)->first();
            if(empty($auth_user))
            {
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ',null);
            }

            $case = Cases::find(intval($id))->update($input);

            return $this->sendResponse(200, 'تم التعديل  بنجاح' ,$case);
        }
        else
        {
            return $this->sendResponse(403, $validate ,null);
        }

    }

    public function caseData(Request $request)
    {
        $rules = [
            'api_token'=>'required',
            'case_id'=>'required|exists:cases,id',
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
                    $case= null;
                    $case = Cases::findOrFail($request->case_id);

                    return $this->sendResponse(200, 'تم',array('cases'=>$case));
                } else {
                    return $this->sendResponse(403, 'لا تمتلك الصلاحيه لدخول هذه الصفحه',null);
                }
            }else{
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ',null);
            }
        }
    }

    public function destroy(Request $request)
    {
        $input = $request->all();
        $id = $request->case_id;
        $validate  =   $this->makeValidate($input,
            [
                'api_token'=>'required',
                'case_id'=>'required|exists:cases,id',

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

                //---------------------------------------
                $caseclient = Case_client::where('case_id', $id)->get();

                foreach ($caseclient as $caseclient) {
                    $caseclient->delete();
                }

                $caseSessions = Sessions::where('case_id', $id)->get();

                foreach ($caseSessions as $caseSessions) {
                    $session_id = $caseSessions->id;

                    $session_note = Session_Notes::where('session_Id', $session_id)->get();

                    foreach ($session_note as $session_note) {
                        $session_note->delete();
                    }
                    $caseSessions->delete();

                }

                Cases::where('id', $id)->delete();
                //---------------------------------------


                return $this->sendResponse(200, 'تم حذف الدعوى  بنجاح' ,null);
            } else {
                return $this->sendResponse(403, 'لا تمتلك الصلاحيه لدخول هذه الصفحه',null);
            }



        }
        else
        {
            return $this->sendResponse(403, $validate ,null);
        }


    }

    //Case Clients Functions
    public function caseClientsData(Request $request)
    {
        $rules = [
            'api_token'=>'required',
            'case_id'=>'required|exists:cases,id',
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
                    $case = Cases::findOrFail($request->case_id);
                    $clients = $case->clients;

                    return $this->sendResponse(200, 'تم',array('clients'=>$clients));
                } else {
                    return $this->sendResponse(403, 'لا تمتلك الصلاحيه لدخول هذه الصفحه',null);
                }
            }else{
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ',null);
            }
        }
    }

}
