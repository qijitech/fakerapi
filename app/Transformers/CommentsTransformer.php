<?php namespace App\Transformers;

use App\Entity\Comment;
use League\Fractal\TransformerAbstract;

class CommentsTransformer extends TransformerAbstract
{

  public function transform(Comment $comment)
  {
    $data = $this->transformComment($comment);
    $parent = $comment->parent;
    if ($parent) {
      $data['parent'] = $this->transformComment($parent);
    } else {
      $data['parent'] = null;
    }
    return $data;
  }

  private function transformComment(Comment $comment)
  {
    $userInfo = $comment->userInfo;
    return [
      'id'         => $comment->id,
      'content'    => $comment->content,
      'created_at' => $comment->created_at,
      'userInfo'   => [
        'user_id'  => $userInfo->user_id,
        'nickname' => $userInfo->nickname,
        'avatar'   => $userInfo->avatar,
        'gender'   => $userInfo->gender,
      ],
    ];
  }

}