<?php

namespace App\Http\Controllers\V1\Auth;

use Api\StarterKit\Controllers\ApiController;
use App\Entity\User;
use App\Transformers\AuthTransformer;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends ApiController
{
  public function postRegister(Request $request)
  {
    $this->validate($request, [
      'phone'    => 'required|phone',
      'password' => 'required',
    ]);

    $phone = $request->get('phone');
    $count = User::wherePhone($phone)->count('id');
    if ($count) {
      return $this->respondForbidden('手机号码已经被注册');
    }

    $password = $request->get('password');

    $userInfo = [
      'phone'    => $phone,
      'password' => bcrypt($password),
    ];

    $user = User::create($userInfo);
    $token = JWTAuth::fromUser($user);
    $user->token = $token;

    return $this->respondWithItem($user, new AuthTransformer);
  }

  /**
   * 登录
   * @param Request $request
   * @return mixed
   */
  public function postLogin(Request $request)
  {
    $this->validate($request, [
      'phone'    => 'required|phone',
      'password' => 'required',
    ]);

    $credentials = [
      'phone'    => $request->get('phone'),
      'password' => $request->get('password'),
    ];

    try {
      if (!$token = JWTAuth::attempt($credentials)) {
        return $this->respondForbidden('用户名或密码不正确');
      }
    } catch (JWTException $e) {
      return $this->respondInternal('could_not_create_token');
    }

    $user = JWTAuth::setToken($token)->toUser();
    $user->token = $token;

    return $this->respondWithItem($user, new AuthTransformer);
  }


  /**
   * @param Request $request
   * @return mixed
   */
  public function getProfile(Request $request)
  {
    $user = $this->auth()->user();
    return $this->respondWithItem($user);
  }


}
