<?php namespace App\Entity;

/**
 * App\Entity\UserToken
 *
 * @property integer $user_id 用户ID
 * @property string $open_id 第三方平台ID
 * @property string $platform 平台类型
 * @property boolean $is_bind 是否绑定
 * @property string $platform_info 平台信息
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Entity\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserToken whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserToken whereOpenId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserToken wherePlatform($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserToken whereIsBind($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserToken wherePlatformInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserToken whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserToken extends BaseEntity
{

  protected $fillable = [
    'user_id',
    'open_id',
    'platform',
    'is_bind',
    'platform_info',
  ];

  protected $casts = [
    'is_bind' => 'boolean',
  ];

  protected $hidden = [
    'user_id',
    'created_at',
    'updated_at',
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

}