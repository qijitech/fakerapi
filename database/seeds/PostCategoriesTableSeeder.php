<?php

use App\Entity\PostCategory;
use Illuminate\Database\Seeder;

class PostCategoriesTableSeeder extends Seeder
{

  protected $names = ['1' => '心情状态', '2' => '咨询求助', '3' => '吐槽爆料', '4' => '兴趣交友', '5' => '闲置交易'];

  /**
   * 运行数据库填充。
   *
   * @return void
   */
  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;'); //关闭外键检查
    DB::table('post_categories')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;'); //开启外键检查
    foreach ($this->names as $id => $name) {
      PostCategory::create([
        'id'   => $id,
        'name' => $name,
      ]);
    }
  }
}