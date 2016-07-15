<?php namespace App\Http\Controllers\V1_0\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AuthInterface;
use App\Transformers\AuthTransformer;

class AuthController extends Controller
{
  /**
   * LoginController constructor.
   * @param AuthInterface $interface
   */
  public function __construct(AuthInterface $interface)
  {
    parent::__construct();

    $this->userInterface = $interface;
  }


  /**
   * 第三方登录
   * POST /auth/third_party
   * @param AuthTransformer $authTransformer
   * @return mixed
   */
  public function postThirdParty(AuthTransformer $authTransformer)
  {
    $this->validate($this->request, [
      'open_id'       => 'required',
      'platform'      => 'required|in:qq,weixin,weibo',
      'platform_info' => 'required',
    ]);

    $user = $this->userInterface->findOrCreateWithPlatform(
      $this->inputGet('platform'),
      $this->inputGet('open_id'),
      $this->inputGet('platform_info')
    );
    return $this->respondWithItem($user, $authTransformer);
  }
}