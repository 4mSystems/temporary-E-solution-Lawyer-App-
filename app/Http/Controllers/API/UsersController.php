<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\category;
use App\Permission;
use App\User;
use Validator;

class UsersController extends Controller
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

                $permission = Permission::where('user_id', $user_id)->first();

                $enabled = $permission->users;
                if ($enabled == 'yes') {
                    $users = null;
                    $categories = null;


                    if ($user->parent_id != null) {
                        $users = User::query()->where('parent_id', $user->parent_id)->get();
                        $categories = category::where('parent_id', $user->parent_id)->select('id', 'name')->get();
                    } else {
                        $users = User::query()->where('parent_id', $user_id)->orWhere('id', $user_id)->get();
                        $categories = category::where('parent_id', $user_id)->select('id', 'name')->get();
                    }


                    return $this->sendResponse(200, ' ', array('users' => $users, 'categories' => $categories));
                } else {
                    return $this->sendResponse(403, 'لا تمتلك الصلاحيه لدخول هذه الصفحه', null);
                }
            } else {
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ', null);
            }
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validate = $this->makeValidate($input,
            [
                'api_token' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'phone' => 'required|numeric|unique:users',
                'address' => 'required',
                'password' => 'required|min:6',
                'type' => 'required|in:admin,User',
                'cat_id' => 'required'

            ]);

        if (!is_array($validate)) {

            $api_token = $request->input('api_token');
            $auth_user = User::where('api_token', $api_token)->first();
            if (empty($auth_user)) {
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ', null);
            }
            $input['password'] = bcrypt(request('password'));
            if ($auth_user->parent_id != null) {
                $input['parent_id'] = $auth_user->parent_id;
            } else {
                $input['parent_id'] = $auth_user->id;
            }
            $input['package_id'] = $auth_user->package_id;
            $user = User::create($input);
            $user_id = $user->id;
            $permissions['user_id'] = $user_id;
            $per = Permission::create($permissions);
            $per->save();
            return $this->sendResponse(200, 'تم الاضافه بنجاح', $user);
        } else {
            return $this->sendResponse(403, $validate, null);
        }

    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $id = $request->id;
        $validate = $this->makeValidate($input,
            [

                'api_token' => 'required',
                'id' => 'required|exists:users,id',
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'phone' => 'required|numeric|unique:users,phone,' . $id,
                'address' => 'required',
                'type' => 'required|in:admin,User',
                'cat_id' => 'required'

            ]);

        if (!is_array($validate)) {

            $api_token = $request->input('api_token');
            $auth_user = User::where('api_token', $api_token)->first();
            if (empty($auth_user)) {
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ', null);
            }

            $user = User::find(intval($id))->update($input);

            return $this->sendResponse(200, 'تم التعديل  بنجاح', $user);
        } else {
            return $this->sendResponse(403, $validate, null);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $input = $request->all();
        $id = $request->id;
        $validate = $this->makeValidate($input,
            [
                'api_token' => 'required',
                'id' => 'required|exists:users,id',

            ]);
        if (!is_array($validate)) {

            $api_token = $request->input('api_token');
            $auth_user = User::where('api_token', $api_token)->first();
            if (empty($auth_user)) {
                return $this->sendResponse(403, 'يرجى تسجيل الدخول ', null);
            }

            $permission = Permission::where('user_id', $id)->delete();
            $user = User::find(intval($id))->delete();

            return $this->sendResponse(200, 'تم حذف المستخدم  بنجاح', null);
        } else {
            return $this->sendResponse(403, $validate, null);
        }


    }
}
