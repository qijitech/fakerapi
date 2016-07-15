<?php

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Post;
use App\Entity\UserInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    // 动态类别
    $this->call('PostCategoriesTableSeeder');
    factory(UserInfo::class, 5)->create();
    factory(Post::class, 50)->create();
    factory(Image::class, 200)->create();
    factory(Comment::class, 200)->create();
    Model::reguard();
  }
}
