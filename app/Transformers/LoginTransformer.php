<?php namespace App\Transformers;

use App\Entity\User;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginTransformer extends TransformerAbstract
{

  public function transform(User $user)
  {
    return [
      'id'         => $user->id,
      'mobile'     => $user->mobile,
      'email'      => $user->email,
      'user_info'  => $user->user_info,
      'user_token' => $user->user_token,
      'token'      => JWTAuth::fromUser($user),
    ];
  }

}