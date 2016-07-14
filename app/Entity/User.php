<?php namespace App\Entity;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

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
class User extends Model implements
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
  ];

  public function userInfo()
  {
    return $this->hasOne(UserInfo::class)->select([
      'nickname',
      'avatar',
      'gender',
      'year_of_birth',
      'month_of_birth',
      'day_of_birth',
      'count_report',
      'count_read',
      'count_posts',
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

}
