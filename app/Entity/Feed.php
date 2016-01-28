<?php
/**
 * Created by PhpStorm.
 * User: YuGang Yang
 * Date: 1/11/16
 * Time: 12:14 AM
 */

namespace App\Entity;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Feed extends BaseEntity
{

    /**
     * The class name to be used in polymorphic relations.
     *
     * @var string
     */
//    protected $morphClass = 'Feed';

    protected $hidden = ['updated_at', 'user_id'];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select(['id', 'nickname', 'avatar']);
    }

    /**
     * @return MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->select(
            ['id', 'imageable_id', 'width', 'height', 'imageable_type', 'url']
        );
    }

}