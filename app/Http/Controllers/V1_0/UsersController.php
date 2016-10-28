<?php namespace App\Http\Controllers\V1_0;


use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UsersInterface;

/**
 * 用户相关
 * Class UsersController
 * @property UsersInterface usersInterface
 * @package App\Http\Controllers\V1_0
 */
class UsersController extends Controller
{

  /**
   * UsersController constructor.
   * @param UsersInterface $usersInterface
   */
  public function __construct(UsersInterface $usersInterface)
  {
    $this->usersInterface = $usersInterface;
  }

  /**
   * 修改个人资料
   * GET /users/update
   */
  public function update()
  {
    validate([
      'avatar'         => 'max:255',
      'nickname'       => 'max:32',
      'gender'         => 'in:unknown,male,female',
      'year_of_birth'  => 'integer',
      'month_of_birth' => 'integer',
      'day_of_birth'   => 'integer',
    ]);

    $params = inputAll();
    if (!$params || count($params) <= 0) {
      respondUnprocessable('没有资料更改');
    }

    $user = user();
    $updated = $this->usersInterface->update($user, $params);
    if (!$updated) {
      respondUnprocessable('没有资料更改');
    }

    return respondWithItem($user);
  }

}