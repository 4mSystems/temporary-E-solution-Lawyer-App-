<?php

namespace App\Http\Controllers\API;

use App\Case_client;
use App\Cases;
use App\Client_Note;
use App\Clients;
use App\Permission;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ClientProfileController extends Controller
{


    public function sendResponse($code = null, $msg = null, $data = null)
    {

        return response(
            [
                'code' => $code,
                'msg' => $msg,
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

    public function makeValidate($inputs, $rules)
    {

        $validator = Validator::make($inputs, $rules);
        if ($validator->fails()) {
            return $this->validationErrorsToString($validator->messages());
        } else {
            return true;
        }
    }


    public function client_cases(Request $request)
    {
        $rules = [
            'api_token' => 'required',
            'id' => 'required|exists:clients,id',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->sendResponse(401, 'يرجى تسجيل الدخول ', null);
        } else {
            $api_token = $request->input('api_token');
            $user = User::where('api_token', $api_token)->first();
            if ($user != null) {
                $user_id = $user->id;

                $permission = Permission::where('user_id', $user_id)->first();

                $enabled = $permission->clients;
                if ($enabled == 'yes') {


                    $cases_id = Case_client::where('client_id', $request->id)->pluck('case_id')->toArray();
                    $clientCases = Cases::whereIn('id', $cases_id)
                        ->with(array('to_whome'=>function($query){
                        $query->select('id','name');
                    }))->get();
                    return $this->sendResponse(200, ' ', array('clients' => $clientCases));
                } else {
                    return $this->sendResponse(403, 'لا تتملك الصلاحيه لدخول هذه الصفحه', null);
                }
            } else {
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ', null);
            }
        }

    }

    public function client_notes(Request $request)
    {
        $rules = [
            'api_token' => 'required',
            'id' => 'required|exists:clients,id',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->sendResponse(401, 'برجاء التاكد من البيانات', null);
        } else {
            $api_token = $request->input('api_token');
            $user = User::where('api_token', $api_token)->first();
            if ($user != null) {
                $user_id = $user->id;

                $permission = Permission::where('user_id', $user_id)->first();

                $enabled = $permission->clients;
                if ($enabled == 'yes') {
//                 $clientNotes =   Client_Note::where('client_id', $request->id)->with('user_id')->get();
                 $clientNotes =   Client_Note::where('client_id', $request->id)
                     ->with(array('user_id'=>function($query){
                     $query->select('id','name');
                 }))->get();

                        return $this->sendResponse(200, ' ', array('clients' => $clientNotes));
                } else {
                    return $this->sendResponse(403, 'لا تتملك الصلاحيه لدخول هذه الصفحه', null);
                }
            } else {
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ', null);
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
                'notes' => 'required',
                'id' => 'required|exists:clients,id',
            ]);
        if (!is_array($validate_api)) {
            $api_token = $request->input('api_token');
            $auth_user = User::where('api_token', $api_token)->first();
            if (empty($auth_user)) {
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ', null);
            }
//            if ($auth_user->type == 'User') {

                $input['user_id'] = $auth_user->id;
                $input['client_id'] = $request->id;
                if ($auth_user->parent_id != null) {
                    $input['parent_id'] = $auth_user->parent_id;
                } else {
                    $input['parent_id'] = $auth_user->id;
                }
               $data = Client_Note::create($input);

                return $this->sendResponse(200, 'تم الاضافه بنجاح', $data);
//            } else {
//
//                return $this->sendResponse(403, 'لا يمكنك الاضافه ', null);
//
//            }

        }
        return $this->sendResponse(401, "برجاء التاكد من البيانات", null);
    }

    public function Edit_Note(Request $request)
    {
        $input = $request->all();
        $validate = null;
        $validate_api = $this->makeValidate($input,
            [
                'api_token' => 'required',
                'notes' => 'required',
                'id' => 'required|exists:client__notes,id',
             ]);
        if (!is_array($validate_api)) {
            $api_token = $request->input('api_token');
            $auth_user = User::where('api_token', $api_token)->first();
            if (empty($auth_user)) {

                return $this->sendResponse(403, 'يرجى تسجيل الدخول ', null);
            }
            if ($auth_user->type == 'admin') {

            $data = Client_Note::find($request->id)->update($input);
            $data = Client_Note::find($request->id)->with(array('user_id'=>function($query){
                $query->select('id','name');
            }))->first();

            return $this->sendResponse(200, 'تم التعديل بنجاح', $data);
            } else {

                return $this->sendResponse(403, 'لا تمتلك الصلاحيه للتعديل ', null);

            }

        }
        return $this->sendResponse(401, "برجاء التاكد من البيانات", null);
    }

    public function delte_Note(Request $request)
    {
        $input = $request->all();
        $validate = null;
        $validate_api = $this->makeValidate($input,
            [
                'api_token' => 'required',
                'id' => 'required|exists:client__notes,id',
            ]);
        if (!is_array($validate_api)) {
            $api_token = $request->input('api_token');
            $auth_user = User::where('api_token', $api_token)->first();
            if (empty($auth_user)) {

                return $this->sendResponse(403, 'يرجى تسجيل الدخول ', null);
            }
            if ($auth_user->type == 'admin') {

                 Client_Note::find(intval($request->id))->delete();


                return $this->sendResponse(200, 'تم الحذف بنجاح', null);
            } else {

                return $this->sendResponse(403, 'لا تمتلك الصلاحيه للتعديل ', null);

            }

        }
        return $this->sendResponse(401, "برجاء التاكد من البيانات", null);
    }


}
