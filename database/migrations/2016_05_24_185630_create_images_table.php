<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * 图片
 * Class CreatePostImagesTable
 */
class CreateImagesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('images', function (Blueprint $table) {
      $table->increments('id')->comment('主键');

      $table->unsignedInteger('user_id')->nullable()->comment('用户id');

      $table->string('url', 255)->comment('图片路径');

      // morph
//      $table->morphs('imageable');
      $table->unsignedInteger("imageable_id");
      $table->string("imageable_type", 20);
      $table->index(["imageable_id", "imageable_type"]);

      // timestamp fields
      $table->timestamps();

      // foreign key
      $table->foreign('user_id')->references('id')->on('users');
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
    Schema::dropIfExists('images');
    //
  }
}
