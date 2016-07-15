<?php namespace App\Transformers;

use App\Entity\User;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTransformer extends TransformerAbstract
{

  public function transform(User $user)
  {
    return [
      'id'         => $user->id,
      'mobile'     => $user->mobile ? preg_replace('/(1\d{1,2})\d\d(\d{0,2})/', '\1****\3', $user->mobile) : '',
      'email'      => $user->email,
      'user_info'  => $user->userInfo,
      'user_token' => $user->userToken,
      'token'      => JWTAuth::fromUser($user),
    ];
  }

}