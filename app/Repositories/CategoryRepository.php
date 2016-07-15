<?php namespace App\Repositories;


use App\Entity\PostCategory;
use App\Repositories\Interfaces\CategoryInterface;

class CategoryRepository implements CategoryInterface
{

  public function findOrFail($categoryId)
  {
    return PostCategory::findOrFail($categoryId);
  }

}