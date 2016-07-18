<?php namespace App\Repositories\Interfaces;

use App\Entity\PostCategory;
use App\Entity\UserInfo;

interface PostsInterface
{
  public function createPost(UserInfo $userInfo, PostCategory $category, $content, $images, $lat, $lng);

  public function getPosts($sinceId, $maxId, $pageSize = 20, $lng = 0, $lat = 0);

  public function findPostWithException($postId);

  public function findPost($postId);

  public function getUserPosts($userId, $sinceId, $maxId, $pageSize = 20);

  public function getMyPosts($userId, $sinceId, $maxId, $pageSize = 20);
}