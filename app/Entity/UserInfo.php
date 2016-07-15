<?php namespace App\Entity;

/**
 * App\Entity\UserInfo
 *
 * @property integer $user_id 用户ID
 * @property string $nickname 昵称
 * @property string $avatar 头像
 * @property string $gender 性别
 * @property integer $wallet 钱包
 * @property integer $year_of_birth 出生年
 * @property boolean $month_of_birth 出生月
 * @property boolean $day_of_birth 出生日
 * @property integer $count_report 被举报次数
 * @property integer $count_read 发布信息被阅读总次数
 * @property integer $count_post 发布信息次数
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Entity\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Post[] $posts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Comment[] $comments
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserInfo whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserInfo whereNickname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserInfo whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserInfo whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserInfo whereWallet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserInfo whereYearOfBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserInfo whereMonthOfBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserInfo whereDayOfBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserInfo whereCountReport($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserInfo whereCountRead($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserInfo whereCountPost($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserInfo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserInfo extends BaseEntity
{

  protected $primaryKey = 'user_id';

  protected $fillable = [
    'user_id',
  ];

  protected $casts = [
    'gender'         => 'int',
    'year_of_birth'  => 'int',
    'month_of_birth' => 'int',
    'day_of_birth'   => 'int',
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function posts()
  {
    return $this->hasMany(Post::class, 'user_id', 'user_id');
  }

  public function comments()
  {
    return $this->hasMany(Comment::class, 'user_id', 'user_id');
  }

}