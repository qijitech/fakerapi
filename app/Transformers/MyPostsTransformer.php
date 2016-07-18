<?php namespace App\Transformers;

use App\Entity\Post;
use League\Fractal\TransformerAbstract;

class MyPostsTransformer extends TransformerAbstract
{

  public function transform(Post $post)
  {
    $userInfo = $post->userInfo;
    $category = $post->category;
    return [
      'id'           => $post->id,
      'content'      => $post->content,
      'created_at'   => $post->created_at,
      'count_images' => $post->count_images,
      'lng'          => $post->lng,
      'lat'          => $post->lat,
      'deleted'      => $post->deleted,
      'images'       => $post->images,
      'userInfo'     => [
        'user_id'  => $userInfo->user_id,
        'nickname' => $userInfo->nickname,
        'avatar'   => $userInfo->avatar,
        'gender'   => $userInfo->gender,
      ],
      'category'     => [
        'id'   => $category->id,
        'name' => $category->name,
      ],
    ];
  }
}