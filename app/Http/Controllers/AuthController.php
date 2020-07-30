<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterFormRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use Hash;

class AuthController extends Controller
{
    public function register(RegisterFormRequest $request)
    {
        $params = $request->only('email', 'name', 'password', 'address', 'phone_number');
        $user = new User();
        $user->email = $params['email'];
        $user->name = $params['name'];
        $user->address = $params['address'];
        $user->phone_number = $params['phone_number'];
        $user->password = bcrypt($params['password']);
        $user->save();

        return response()->json($user, Response::HTTP_OK);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!($token = JWTAuth::attempt($credentials))) {
            return response()->json([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], Response::HTTP_BAD_REQUEST);
        }
        $user = Auth::user();
        return response()->json([
          'token' => $token,
          'user' => $user,
        ], Response::HTTP_OK);
    }

    public function reset(ResetPasswordRequest $request)
    {
      $data = $request->all();
      $user = User::where('id', $data['user_id'])->firstOrFail();
      if (!Hash::check($data['current_password'], $user->password)){
          return response()->json([
            'err' => "Mật khẩu cũ không chính xác",
            'code' => 422
          ], Response::HTTP_OK);
      } else {
          $updatePasswordUser = $user->update(['password' => bcrypt($data['new_password'])]);
          return response()->json([
              'success' => $updatePasswordUser,
              'code' => 200,
          ], Response::HTTP_OK);
      }
    }
}