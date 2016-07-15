<?php namespace App\Repositories;


use App\Entity\User;
use App\Entity\UserToken;
use App\Repositories\Interfaces\AuthInterface;

class AuthRepository implements AuthInterface
{

  public function findOrCreateWithPlatform($platform, $openId, $platformInfo)
  {

    $count = UserToken::wherePlatform($platform)->whereOpenId($openId)->count('user_id');

    if (!$count) {
      User::createWithPlatform($platform, $openId, $platformInfo);
    }

    return User::with('userInfo', 'userToken')->join('user_tokens', function ($join) use ($platform, $openId) {
      $join->on('users.id', '=', 'user_tokens.user_id')
        ->where('user_tokens.platform', '=', $platform)
        ->where('user_tokens.open_id', '=', $openId)
        ->whereNotNull('users.id')
        ->whereNotNull('user_tokens.user_id');
    })->first(['users.*']);
  }

}