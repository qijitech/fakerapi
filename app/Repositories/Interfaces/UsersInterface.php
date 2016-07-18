<?php namespace App\Repositories\Interfaces;


use App\Entity\User;

interface UsersInterface
{

  /**
   * 更新资料
   * @param $user
   * @param $params
   * @return mixed
   */
  public function update(User $user, $params);

}