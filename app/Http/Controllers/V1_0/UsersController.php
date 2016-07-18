<?php namespace App\Http\Controllers\V1_0;


use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UsersInterface;

/**
 * 用户相关
 * Class UsersController
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
    parent::__construct();
    $this->usersInterface = $usersInterface;
  }

  /**
   * 修改个人资料
   * GET /users/update
   */
  public function update()
  {
    $this->validate($this->request, [
      'avatar'         => 'max:255',
      'nickname'       => 'max:32',
      'gender'         => 'in:unknown,male,female',
      'year_of_birth'  => 'integer',
      'month_of_birth' => 'integer',
      'day_of_birth'   => 'integer',
    ]);

    $params = $this->inputAll();
    if (!$params || count($params) <= 0) {
      return $this->respondUnprocessable('没有资料更改');
    }

    $user = $this->auth()->user();
    $updated = $this->usersInterface->update($user, $params);
    if (!$updated) {
      return $this->respondUnprocessable('没有资料更改');
    }
    return $this->respondWithItem($user);
  }

}