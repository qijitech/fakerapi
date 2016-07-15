<?php namespace App\Repositories\Interfaces;


interface AuthInterface
{

  /**
   *
   * 根据第三方平台获取User
   * @param $platform
   * @param $openId
   * @param $platformInfo
   * @return mixed
   */
  public function findOrCreateWithPlatform($platform, $openId, $platformInfo);

}