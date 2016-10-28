<?php namespace App\Http\Controllers\V1_0;


use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CommentsInterface;
use App\Repositories\Interfaces\PostsInterface;
use App\Transformers\CommentsTransformer;

/**
 * 评论Controller
 * Class CommentsController
 * @property CommentsInterface commentsInterface
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
    validate([
      'post_id' => 'required|integer',
      'content' => 'required',
    ]);

    $user = user();

    $post = $postsInterface->findPostWithException(inputGet('post_id'));

    $parentId = inputGet('parent_id');
    if ($parentId) {
      $parent = $this->commentsInterface->findCommentWithException($parentId);
    } else {
      $parent = null;
    }

    $comment = $this->commentsInterface->createComment($user, $post,
      inputGet('content'), $parent
    );
    return respondWithItem($comment, $commentsTransformer);
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
      sinceId(),
      maxId(),
      pageSize()
    );
    return respondWithCollection($data, $commentsTransformer);
  }

}