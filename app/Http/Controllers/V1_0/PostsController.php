<?php namespace App\Http\Controllers\V1_0;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\PostInterface;
use App\Transformers\PostsTransformer;

/**
 * 帖子Controller
 * Class PostsController
 * @package App\Http\Controllers\V1_0
 */
class PostsController extends Controller
{

  /**
   * PostsController constructor.
   * @param PostInterface $postInterface
   */
  public function __construct(PostInterface $postInterface)
  {
    parent::__construct();
    $this->postInterface = $postInterface;
  }

  /**
   * GET /posts
   * @param PostsTransformer $postsTransformer
   * @return mixed
   */
  public function index(PostsTransformer $postsTransformer)
  {
    $this->validate($this->request, [
      'lng' => 'required|numeric',
      'lat' => 'required|numeric',
    ]);

    $data = $this->postInterface->getPosts(
      $this->getSinceId(),
      $this->getMaxId(),
      $this->getPageSize(),
      $this->inputGet('lng'),
      $this->inputGet('lat')
    );
    return $this->respondWithCollection($data, $postsTransformer);
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
    $this->validate($this->request, [
      'post_category_id' => 'required|integer',
      'content'          => 'string|max:400',
      'lng'              => 'required|numeric',
      'lat'              => 'required|numeric',
    ]);

    // validate content and images
    $content = $this->inputGet('content');
    $images = $this->inputGet('images');

    if (!$content && (!count($images) || !$images)) {
      return $this->respondUnprocessable('动态内容或图片不能都为空');
    }

    if ($images && !is_array($images)) {
      return $this->respondUnprocessable('图片参数格式不正确');
    }

    if ($images && count($images) > 9) {
      return $this->respondUnprocessable('图片不能超过9张');
    }

    $category = $categoryInterface->findOrFail($this->inputGet('post_category_id'));

    // 获取登录用户
    $user = $this->auth()->user();

    $post = $this->postInterface->createPost(
      $user->userInfo,
      $category,
      $content,
      $images,
      $this->inputGet('lat'),
      $this->inputGet('lng')
    );

    return $this->respondWithItem($post, $postsTransformer);
  }

  /**
   * 帖子详情
   * GET /posts/{post_id}
   */
  public function show($postId)
  {

  }

  /**
   * 删除帖子
   * POST /posts/{post_id}/destroy
   */
  public function destroy($postId)
  {

  }

}