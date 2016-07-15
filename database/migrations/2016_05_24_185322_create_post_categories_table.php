<?php

use App\Enum\Status;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 帖子类别
 * Class CreatePostCategoriesTable
 */
class CreatePostCategoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('post_categories', function (Blueprint $table) {
      $table->smallIncrements('id')->comment('类别ID');

      $table->string('name', 20)->comment('名称');

      $table->unsignedSmallInteger('parent_id')->nullable()->comment('父类ID');
      $table->unsignedSmallInteger('count_sub_categories')->comment('子类个数');

      $table->enum('status', Status::getValues())->default(Status::ENABLE)->comment('状态');

      // timestamp fields
      $table->timestamps();

      // foreign key
      $table->foreign('parent_id')->references('id')->on('post_categories');
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
    Schema::dropIfExists('post_categories');
    //
  }
}
