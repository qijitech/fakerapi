<?php namespace App\Repositories;


use Api\StarterKit\Exception\ResourceDisabledException;
use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use App\Enum\Status;
use App\Repositories\Interfaces\CommentsInterface;
use DB;

class CommentsRepository implements CommentsInterface
{

  public function createComment(User $user, Post $post, $content, Comment $parent = null)
  {
    return DB::transaction(function () use ($user, $post, $content, $parent) {
      $comment = new Comment;
      $comment->content = $content;
      $comment->post()->associate($post);
      $comment->userInfo()->associate($user->userInfo);
      if ($parent) {
        $comment->parent()->associate($parent);
      }
      $comment->save();
      $post->increment('count_comments');
      return $comment;
    });
  }

  public function findCommentWithException($commentId)
  {
    $comment = $this->findComment($commentId);
    if ($comment->status == Status::DISABLED) {
      throw new ResourceDisabledException();
    }
    return $comment;
  }

  public function findComment($commentId)
  {
    return Comment::with('userInfo')->findOrFail($commentId);
  }

  public function getComments($postId, $sinceId, $maxId, $pageSize = 20)
  {
    $query = Comment::enabled()
      ->with('userInfo', 'parent', 'parent.userInfo')
      ->wherePostId($postId);

    if ($maxId) {
      $query->where('id', '<', $maxId);
    } else if ($sinceId) {
      $query->where('id', '>', $sinceId);
    }

    return $query->orderBy('id', 'desc')
      ->take($pageSize)
      ->get();
  }

}