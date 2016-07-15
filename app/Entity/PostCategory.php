<?php namespace App\Entity;

/**
 * App\Entity\PostCategory
 *
 * @property integer $id 类别ID
 * @property string $name 名称
 * @property integer $parent_id 父类ID
 * @property integer $count_sub_categories 子类个数
 * @property string $status 状态
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\PostCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\PostCategory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\PostCategory whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\PostCategory whereCountSubCategories($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\PostCategory whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\PostCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\PostCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PostCategory extends BaseEntity
{

}