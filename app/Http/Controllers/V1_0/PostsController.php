<?php namespace App\Http\Controllers\V1_0;

use App\Entity\Post;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PostInterface;

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
   * @return mixed
   */
  public function index()
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
    return $this->respondWithCollection($data);
  }

  public function getPosts()
  {
    $this->validate($this->request, [
      'lng' => 'required|numeric',
      'lat' => 'required|numeric',
    ]);

    $data = Post::with('userInfo', 'category', 'images')
      ->whereDeleted(false)->paginate();

    return $this->respondWithPagination($data);
  }

}