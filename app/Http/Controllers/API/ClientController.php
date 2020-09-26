<?php

namespace App\Http\Controllers\API;

use App\category;
use App\Clients;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Permission;
use App\User;
use Validator;

class ClientController extends Controller
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


    public function index(Request $request)
    {
        $rules = [
            'api_token' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->sendResponse(401, 'يرجى تسجيل الدخول ', null);
        } else {
            $api_token = $request->input('api_token');
            $user = User::where('api_token', $api_token)->first();
            if ($user != null) {
                $user_id = $user->id;
                $user_type = $user->type;
                $permission = Permission::where('user_id', $user_id)->first();

                $enabled = $permission->clients;
                if ($enabled == 'yes') {
                    $clients = null;


                    if ($user->parent_id != null) {
                        if ($user_type == 'admin') {
                            $clients = Clients::query()->where('parent_id', $user->parent_id)->get();
                        } else {
                            //type = user ->get all client with same cat_id of this user
                            $clients = Clients::where('cat_id', $user->cat_id)->latest()->get();
                        }
                    } else {
                        $clients = Clients::query()->where('parent_id', $user_id)->get();
                    }


                    return $this->sendResponse(200, ' ', array('clients' => $clients));
                } else {
                    return $this->sendResponse(403, 'لا تتملك الصلاحيه لدخول هذه الصفحه', null);
                }
            } else {
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ', null);
            }
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
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
                        'client_Name' => 'required',
                        'client_Unit' => 'required',
                        'client_Address' => 'required',
                        'notes' => 'required',
                        'type' => 'required|in:client,khesm'
                    ]);

                $input['cat_id'] = $auth_user->cat_id;


            } else {
                $validate = $this->makeValidate($input,
                    [
                        'client_Name' => 'required',
                        'client_Unit' => 'required',
                        'client_Address' => 'required',
                        'notes' => 'required',
                        'type' => 'required|in:client,khesm',
                        'cat_id' => 'required'
                    ]);
//                $input['cat_id'] = $input->cat_id;

            }
            if (!is_array($validate)) {
                if ($auth_user->parent_id != null) {
                    $input['parent_id'] = $auth_user->parent_id;
                } else {
                    $input['parent_id'] = $auth_user->id;
                }

                $data = Clients::create($input);
                return $this->sendResponse(200, 'تم الاضافه بنجاح', $data);
            } else {
                return $this->sendResponse(403, $validate, null);
            }
        }
        return $this->sendResponse(403, "برجاء تسجيل الدخول", null);
    }

    public function update(Request $request)
    {
        // if Type == User -> cannot Edit ...
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
                return $this->sendResponse(403, 'لا تمتلك الصلاحيه للتعديل', null);

            } else {
                $validate = $this->makeValidate($input,
                    [
                        'id' => 'required|exists:clients,id',
                        'client_Name' => 'required',
                        'client_Unit' => 'required',
                        'client_Address' => 'required',
                        'notes' => 'required',
                        'type' => 'required|in:client,khesm',
                        'cat_id' => 'required'
                    ]);
                if (!is_array($validate)) {
                    Clients::find($request->id)->update($input);
                    return $this->sendResponse(200, "تم التعديل بنجاح", $input);
                } else {
                    return $this->sendResponse(401, "برجاء التاكد من البيانات", null);
                }
            }


        }
        return $this->sendResponse(403, "برجاء تسجيل الدخول", null);
    }

    public function destroy(Request $request)
    {
        // if Type == User -> cannot Edit ...
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
                return $this->sendResponse(403, 'لا تمتلك الصلاحيه للتعديل', null);

            } else {
                $validate = $this->makeValidate($input,
                    [
                        'id' => 'required|exists:clients,id',

                    ]);
                if (!is_array($validate)) {
                    Clients::find(intval($request->id))->delete();
                    return $this->sendResponse(200, "تم حذف العميل بنجاح", null);
                } else {
                    return $this->sendResponse(401, "برجاء التاكد من البيانات", null);
                }
            }


        }
        return $this->sendResponse(403, "برجاء تسجيل الدخول", null);
    }
}
