<?php

use App\Enum\Gender;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 用户详细信息
 * Class CreateUserInfosTable
 */
class CreateUserInfosTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_infos', function (Blueprint $table) {
      $table->unsignedInteger('user_id')->primary()->comment('用户ID');

      $table->string('nickname', 32)->comment('昵称');
      $table->string('avatar', 255)->comment('头像');
      $table->enum('gender', Gender::getValues())->default(Gender::UNKNOWN)->comment('性别');

      $table->unsignedInteger('wallet')->default(0)->comment('钱包');

      $table->unsignedSmallInteger('year_of_birth')->comment('出生年');
      $table->unsignedTinyInteger('month_of_birth')->comment('出生月');
      $table->unsignedTinyInteger('day_of_birth')->comment('出生日');

      $table->unsignedInteger('count_report')->default(0)->comment('被举报次数');
      $table->unsignedInteger('count_read')->default(0)->comment('发布信息被阅读总次数');
      $table->unsignedInteger('count_post')->default(0)->comment('发布信息次数');

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
    Schema::dropIfExists('user_infos');
    //
  }
}
