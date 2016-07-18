<?php namespace App\Entity;

use Api\StarterKit\Entities\Entity;
use App\Enum\Status;

/**
 * App\Entity\BaseEntity
 *
 * @property-read mixed $created_at
 * @mixin \Eloquent
 */
class BaseEntity extends Entity
{

  /**
   * @return int
   */
  public function getCreatedAtAttribute()
  {
    $time = strtotime($this->attributes['created_at']);
    return $time == false ? 0 : $time;
  }

  public function scopeEnabled($query)
  {
    return $query->whereStatus(Status::ENABLE);
  }

}