<?php

use App\Enum\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * 评论
 * Class CreateCommentsTable
 */
class CreateCommentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('comments', function (Blueprint $table) {
      $table->increments('id')->comment('评论ID');

      $table->unsignedInteger('user_id')->comment('评论的用户ID');
      $table->unsignedInteger('post_id')->comment('所评论的信息ID');
      $table->unsignedInteger('parent_id')->nullable()->comment('父评论ID');

      $table->text('content')->comment('评论内容');

      $table->enum('status', Status::getValues())->default(Status::ENABLE)->comment('状态');

      // timestamp fields
      $table->timestamps();

      // foreign key
      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('post_id')->references('id')->on('posts');
      $table->foreign('parent_id')->references('id')->on('comments');
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
    Schema::dropIfExists('comments');
    //
  }
}
