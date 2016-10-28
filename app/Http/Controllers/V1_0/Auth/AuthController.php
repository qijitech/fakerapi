<?php namespace App\Http\Controllers\V1_0\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AuthInterface;
use App\Transformers\AuthTransformer;

/**
 * @property AuthInterface userInterface
 */
class AuthController extends Controller
{
  /**
   * LoginController constructor.
   * @param AuthInterface $interface
   */
  public function __construct(AuthInterface $interface)
  {
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
    validate([
      'open_id'       => 'required',
      'platform'      => 'required|in:qq,weixin,weibo',
      'platform_info' => 'required',
    ]);

    $user = $this->userInterface->findOrCreateWithPlatform(
      inputGet('platform'),
      inputGet('open_id'),
      inputGet('platform_info')
    );
    return respondWithItem($user, $authTransformer);
  }
}