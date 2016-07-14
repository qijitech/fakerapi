<?php namespace App\Entity;

/**
 * App\Entity\Image
 *
 * @property integer $id 主键
 * @property integer $user_id 用户id
 * @property string $url 图片路径
 * @property integer $imageable_id
 * @property string $imageable_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $imageable
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Image whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Image whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Image whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Image whereImageableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Image whereImageableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Image whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Image extends BaseEntity
{

  protected $fillable = [
    'url',
    'user_id',
    'imageable_id',
    'imageable_type',
  ];

  protected $hidden = [
    'user_id',
    'imageable_id',
    'imageable_type',
    'created_at',
    'updated_at',
  ];

  /**
   * @return MorphTo
   */
  public function imageable()
  {
    return $this->morphTo();
  }

}