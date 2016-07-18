<?php namespace App\Http\Controllers\V1_0;


use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CommentsInterface;
use App\Repositories\Interfaces\PostsInterface;
use App\Transformers\CommentsTransformer;

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
   * @param PostsInterface $postsInterface
   * @param CommentsTransformer $commentsTransformer
   * @return mixed
   */
  public function store(PostsInterface $postsInterface, CommentsTransformer $commentsTransformer)
  {
    $this->validate($this->request, [
      'post_id' => 'required|integer',
      'content' => 'required',
    ]);

    $user = $this->auth()->user();

    $post = $postsInterface->findPostWithException($this->inputGet('post_id'));

    $parentId = $this->inputGet('parent_id');
    if ($parentId) {
      $parent = $this->commentsInterface->findCommentWithException($parentId);
    } else {
      $parent = null;
    }

    $comment = $this->commentsInterface->createComment($user, $post,
      $this->inputGet('content'), $parent
    );
    return $this->respondWithItem($comment, $commentsTransformer);
  }

  /**
   * /GET /comments/{post_id}
   * @param CommentsTransformer $commentsTransformer
   * @param $postId
   * @return mixed
   */
  public function index(CommentsTransformer $commentsTransformer, $postId)
  {
    $data = $this->commentsInterface->getComments($postId,
      $this->getSinceId(),
      $this->getMaxId(),
      $this->getPageSize()
    );
    return $this->respondWithCollection($data, $commentsTransformer);
  }

}