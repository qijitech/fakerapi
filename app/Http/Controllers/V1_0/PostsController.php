<?php namespace App\Http\Controllers\V1_0;

use App\Entity\Post;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\PostsInterface;
use App\Transformers\MyPostsTransformer;
use App\Transformers\PostsTransformer;

/**
 * 帖子Controller
 * Class PostsController
 * @property PostsInterface postInterface
 * @package App\Http\Controllers\V1_0
 */
class PostsController extends Controller
{

  /**
   * PostsController constructor.
   * @param PostsInterface $postsInterface
   */
  public function __construct(PostsInterface $postsInterface)
  {
    $this->postInterface = $postsInterface;
  }

  /**
   * GET /posts
   * @param PostsTransformer $postsTransformer
   * @return mixed
   */
  public function index(PostsTransformer $postsTransformer)
  {
    validate([
      'lng' => 'numeric',
      'lat' => 'numeric',
    ]);

    $data = $this->postInterface->getPosts(
      sinceId(),
      maxId(),
      pageSize(),
      inputGet('lng', 0),
      inputGet('lat', 0)
    );
    return respondWithCollection($data, $postsTransformer);
  }

  /**
   * GET /posts/page
   * @param PostsTransformer $postsTransformer
   * @return mixed
   */
  public function indexPage(PostsTransformer $postsTransformer)
  {
    validate([
      'lng' => 'numeric',
      'lat' => 'numeric',
    ]);

    $data = $this->postInterface->getPostsWithPage(
      currentPage(),
      pageSize(),
      inputGet('lng', 0),
      inputGet('lat', 0)
    );
    return respondWithCollection($data, $postsTransformer);
  }

  /**
   * 发布帖子
   * POST /posts
   * @param CategoryInterface $categoryInterface
   * @param PostsTransformer $postsTransformer
   * @return mixed
   */
  public function store(CategoryInterface $categoryInterface, PostsTransformer $postsTransformer)
  {

    // validate params
    validate([
      'post_category_id' => 'required|integer',
      'content'          => 'string|max:400',
      'lng'              => 'required|numeric',
      'lat'              => 'required|numeric',
    ]);

    // validate content and images
    $content = inputGet('content');
    $images = inputGet('images');

    if (!$content && (!count($images) || !$images)) {
      respondUnprocessable('动态内容或图片不能都为空');
    }

    if ($images && !is_array($images)) {
      respondUnprocessable('图片参数格式不正确');
    }

    if ($images && count($images) > 9) {
      respondUnprocessable('图片不能超过9张');
    }

    $category = $categoryInterface->findOrFail(inputGet('post_category_id'));

    // 获取登录用户
    $user = $this->auth()->user();

    $post = $this->postInterface->createPost(
      $user->userInfo,
      $category,
      $content,
      $images,
      inputGet('lat', 0),
      inputGet('lng', 0)
    );

    return respondWithItem($post, $postsTransformer);
  }

  /**
   * 帖子详情
   * GET /posts/{post_id}
   * @param PostsTransformer $postsTransformer
   * @param $postId
   * @return mixed
   */
  public function show(PostsTransformer $postsTransformer, $postId)
  {
    $data = $this->postInterface->getPost($postId);
    return respondWithItem($data, $postsTransformer);
  }

  /**
   * 删除帖子
   * POST /posts/{post_id}/destroy
   */
  public function destroy($postId)
  {
    $records = $this->postInterface->delete($postId);
    if ($records) {
      return respondSuccess('删除帖子成功');
    }
    respondUnprocessable('删除失败');
  }

  /**
   * 用户动态
   * GET /posts/user_timeline
   * @param PostsInterface $postInterface
   * @return mixed
   */
  public function getUserTimeline(PostsInterface $postInterface)
  {
    $maxId = maxId();
    $sinceId = sinceId();
    $pageSize = pageSize();

    $userId = inputGet('user_id'); // if null

    if ($userId) {
      $data = $postInterface->getUserPosts($userId, $sinceId, $maxId, $pageSize);
      return respondWithCollection($data, new PostsTransformer);
    }

    $user = user();
    if (is_null($user)) {
      errorUnauthorized();
    }

    $data = $postInterface->getMyPosts($user->id, $sinceId, $maxId, $pageSize);
    return respondWithCollection($data, new MyPostsTransformer);
  }

  /**
   * @return mixed
   */
  public function getPosts()
  {
    $builder = Post::with('userInfo', 'category', 'images')
      ->whereDeleted(false);
    return respondWithPagination(morphPage($builder));
  }

}