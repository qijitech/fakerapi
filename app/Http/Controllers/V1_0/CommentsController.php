<?php namespace App\Http\Controllers\V1_0;


use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CommentsInterface;
use App\Repositories\Interfaces\PostInterface;

/**
 * 评论Controller
 * Class CommentsController
 * @package App\Http\Controllers\V1_0
 */
class CommentsController extends Controller
{

  /**
   * CommentsController constructor.
   * @param CommentsInterface $commentsInterface
   */
  public function __construct(CommentsInterface $commentsInterface)
  {
    parent::__construct();
    $this->commentsInterface = $commentsInterface;
  }

  /**
   * POST /comments
   * @param PostInterface $postInterface
   * @return mixed
   */
  public function store(PostInterface $postInterface)
  {
    $this->validate($this->request, [
      'post_id' => 'required',
      'content' => 'required',
    ]);

    $user = $this->auth()->user();

    $post = $postInterface->findPostWithException($this->inputGet('post_id'));

    $parentId = $this->inputGet('parent_id');
    if ($parentId) {
      $parent = $this->commentsInterface->findCommentWithException($parentId);
    } else {
      $parent = null;
    }

    $comment = $this->commentsInterface->createComment($user, $post,
      $this->inputGet('content'), $parent
    );
    return $this->respondWithItem($comment);
  }

}