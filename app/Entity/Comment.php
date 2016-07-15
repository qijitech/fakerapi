<?php namespace App\Entity;

/**
 * App\Entity\Comment
 *
 * @property integer $id 评论ID
 * @property integer $user_id 评论的用户ID
 * @property integer $post_id 所评论的信息ID
 * @property integer $parent_id 父评论ID
 * @property string $content 评论内容
 * @property string $status 状态
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Entity\Post $post
 * @property-read \App\Entity\UserInfo $userInfo
 * @property-read \App\Entity\Comment $parent
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment wherePostId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Comment extends BaseEntity
{

  protected $hidden = [
    'user_id',
    'updated_at',
    'post_id',
    'parent_id',
  ];

  protected $fillable = [
    'post_id',
    'user_id',
    'parent_id',
    'content',
  ];

  public function post()
  {
    return $this->belongsTo(Post::class, 'post_id', 'id');
  }

  public function userInfo()
  {
    return $this->belongsTo(UserInfo::class, 'user_id', 'user_id')->select([
      'user_id',
      'nickname',
      'avatar',
    ]);
  }

  public function parent()
  {
    return $this->belongsTo(Comment::class, 'parent_id', 'id')->select([
      'id',
      'content',
      'user_id',
      'parent_id',
      'created_at',
    ]);
  }

}