<?php

use App\Enum\Status;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 帖子
 * Class CreatePostsTable
 */
class CreatePostsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('posts', function (Blueprint $table) {
      $table->increments('id')->comment('帖子id');

      $table->unsignedSmallInteger('post_category_id')->index('post_category_id')->comment('分类ID');
      $table->unsignedInteger('user_id')->comment('信息发布者用户 ID');

      $table->text('content')->nullable()->comment('信息内容');

      $table->unsignedInteger('count_images')->default(0)->comment('包含图片数量');
      $table->unsignedInteger('count_views')->default(0)->comment('阅读次数');
      $table->unsignedInteger('count_comments')->default(0)->comment('评论次数');

      // 小数点后6位 精确到4米
      $table->decimal('lng', 20, 6)->default(0.000000)->index('lng')->comment('经度');
      $table->decimal('lat', 20, 6)->default(0.000000)->index('lat')->comment('维度');

      $table->enum('status', Status::getValues())->default(Status::ENABLE)->comment('状态');

      $table->boolean('deleted')->default(false)->comment('删除状态');

      // timestamp fields
      $table->timestamps();

      // foreign key
      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('post_category_id')->references('id')->on('post_categories');
    });
    //
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('posts');
    //
  }
}
