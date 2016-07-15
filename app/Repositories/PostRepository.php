<?php namespace App\Repositories;

use App\Entity\Post;
use App\Entity\PostCategory;
use App\Entity\UserInfo;
use App\Enum\Status;
use App\Repositories\Interfaces\PostInterface;
use DB;

class PostRepository implements PostInterface
{
  public function createPost(UserInfo $userInfo, PostCategory $category, $content, $images, $lat, $lng)
  {
    return DB::transaction(/**
     * @return Post
     */
      function () use ($userInfo, $category, $content, $images, $lat, $lng) {
        $post = new Post;

        // associate user info
        $post->userInfo()->associate($userInfo);
        // associate category
        $post->category()->associate($category);

        // save columns
        $post->content = $content;
        $post->lng = $lng;
        $post->lat = $lat;
        $post->count_images = count($images);

        $post->save();

        // save images
        $accountId = $userInfo->user_id;
        if ($images && count($images) > 0) {
          $imageData = [];
          $imageData = array_map(function ($image) use ($imageData, $accountId) {
            $imageData['url'] = $image;
            $imageData['user_id'] = $accountId;
            return $imageData;
          }, $images);
          $post->images()->createMany($imageData);
        }

        // increment count posts
        $userInfo->increment('count_post');

        return $post;
      });
  }

  public function getPosts($sinceId, $maxId, $pageSize = 20, $lng = 0, $lat = 0)
  {
    $query = Post::with('userInfo', 'category', 'images')
      ->whereStatus(Status::ENABLE)
      ->whereDeleted(false);
    if ($maxId) {
      $query->where('id', '<', $maxId);
    } else if ($sinceId) {
      $query->where('id', '>', $sinceId);
    }

    $direction = 'asc';
    $orderByRaw = DB::raw('ACOS(SIN((' . $lat . ' * 3.1415) / 180 ) * SIN((`lat` * 3.1415) / 180 ) + COS((' . $lat . ' * 3.1415) / 180 ) * COS((`lat` * 3.1415) / 180 ) *COS((' . $lng . ' * 3.1415) / 180 - (`lng` * 3.1415) / 180 ) ) * 6380');

    return $query->orderBy('id', 'desc')->orderBy($orderByRaw, $direction)
      ->take($pageSize)->get();
  }

  public function getPost($postId)
  {
    // TODO: Implement getPost() method.
  }

  public function getUserPosts($userId, $sinceId, $maxId, $pageSize = 20)
  {
    // TODO: Implement getUserPosts() method.
  }

  public function getMyPosts($userId, $sinceId, $maxId, $pageSize = 20)
  {
    // TODO: Implement getMyPosts() method.
  }


}