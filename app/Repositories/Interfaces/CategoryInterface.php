<?php namespace App\Repositories\Interfaces;

interface CategoryInterface
{

  public function findOrFail($categoryId);

}