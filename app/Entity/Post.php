<?php namespace App\Entity;

use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Entity\Post
 *
 * @property integer $id 帖子id
 * @property integer $post_category_id 分类ID
 * @property integer $user_id 信息发布者用户 ID
 * @property string $content 信息内容
 * @property integer $count_images 包含图片数量
 * @property integer $count_views 阅读次数
 * @property integer $count_comments 评论次数
 * @property float $lng 经度
 * @property float $lat 维度
 * @property string $status 状态
 * @property boolean $deleted 删除状态
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Entity\UserInfo $userInfo
 * @property-read \App\Entity\PostCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Image[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Comment[] $comments
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Post whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Post wherePostCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Post whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Post whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Post whereCountImages($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Post whereCountViews($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Post whereCountComments($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Post whereLng($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Post whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Post whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Post whereDeleted($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Post whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Post extends BaseEntity
{

  protected $hidden = [
    'updated_at',
    'user_id',
    'post_category_id',
  ];

  protected $fillable = [
    'post_category_id',
    'user_id',
    'content',
    'count_images',
    'count_views',
    'count_comments',
    'lng',
    'lat',
  ];

  protected $casts = [
    'lat'     => 'double',
    'lng'     => 'double',
    'deleted' => 'boolean',
  ];

  public function userInfo()
  {
    return $this->belongsTo(UserInfo::class, 'user_id', 'user_id')->select([
      'user_id',
      'nickname',
      'gender',
      'avatar',
    ]);
  }

  public function category()
  {
    return $this->belongsTo(PostCategory::class, 'post_category_id', 'id')
      ->select(['id', 'name',]);
  }

  /**
   * @return MorphMany
   */
  public function images()
  {
    return $this->morphMany(Image::class, 'imageable')->select([
      'id',
      'imageable_id',
      'imageable_type',
      'url',
    ]);
  }

  public function comments()
  {
    return $this->hasMany(Comment::class, 'post_id', 'id');
  }

}