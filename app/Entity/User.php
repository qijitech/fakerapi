<?php namespace App\Entity;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Entity\User
 *
 * @property integer $id 用户ID
 * @property string $mobile 手机号
 * @property string $email 邮箱
 * @property string $password 密码
 * @property string $status 状态
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Entity\UserInfo $userInfo
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\UserToken[] $userToken
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Model implements JWTSubject,
  AuthenticatableContract,
  AuthorizableContract
{
  use Authenticatable, Authorizable;

  protected $fillable = [
    'mobile',
    'email',
    'password',
  ];

  protected $hidden = [
    'password',
    'created_at',
    'updated_at',
  ];

  /**
   * Get the identifier that will be stored in the subject claim of the JWT.
   *
   * @return mixed
   */
  public function getJWTIdentifier()
  {
    return $this->id;
  }

  /**
   * Return a key value array, containing any custom claims to be added to the JWT.
   *
   * @return array
   */
  public function getJWTCustomClaims()
  {
    return [];
  }

  public function userInfo()
  {
    return $this->hasOne(UserInfo::class)->select([
      'user_id',
      'nickname',
      'avatar',
      'gender',
      'year_of_birth',
      'month_of_birth',
      'day_of_birth',
      'count_report',
      'count_read',
      'count_post',
    ]);
  }

  public function userToken()
  {
    return $this->hasMany(UserToken::class)->select([
      'user_id',
      'open_id',
      'platform',
      'is_bind',
    ]);
  }

  /**
   * @param $platform
   * @param $openId
   * @param $platformInfo
   */
  public static function createWithPlatform($platform, $openId, $platformInfo)
  {
    \DB::transaction(function () use ($platform, $openId, $platformInfo) {
      // create user
      $user = self::create();

      // create user info
      $userInfo = new UserInfo;
      $userInfo->nickname = 'MM' . substr($openId, 0, 6);
      $userInfo->user()->associate($user);
      $userInfo->save();

      // create user token
      $userToken = new UserToken;
      $userToken->platform = $platform;
      $userToken->open_id = $openId;
      $userToken->platform_info = $platformInfo;
      $userToken->user()->associate($user);
      $userToken->save();
    });
  }

}
