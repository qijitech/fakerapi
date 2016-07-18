<?php namespace App\Repositories;

use App\Entity\User;
use App\Repositories\Interfaces\UsersInterface;

class UsersRepository implements UsersInterface
{

  /**
   * 修改用户资料
   * @param User $user
   * @param $params
   * @return bool
   */
  public function update(User $user, $params)
  {
    $updated = false;
    $userInfo = $user->userInfo;
    if (array_key_exists('avatar', $params)) {
      $userInfo->avatar = $params['avatar'];
      $updated = true;
    }

    if (array_key_exists('nickname', $params)) {
      $userInfo->nickname = $params['nickname'];
      $updated = true;
    }

    if (array_key_exists('gender', $params)) {
      $userInfo->gender = $params['gender'];
      $updated = true;
    }

    if (array_key_exists('year_of_birth', $params)) {
      $userInfo->year_of_birth = $params['year_of_birth'];
      $updated = true;
    }

    if (array_key_exists('month_of_birth', $params)) {
      $userInfo->month_of_birth = $params['month_of_birth'];
      $updated = true;
    }

    if (array_key_exists('day_of_birth', $params)) {
      $userInfo->day_of_birth = $params['day_of_birth'];
      $updated = true;
    }

    if ($updated) {
      $userInfo->update();
    }
    return $updated;
  }

}