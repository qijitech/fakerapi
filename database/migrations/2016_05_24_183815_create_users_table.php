<?php

use App\Enum\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * 用户
 * Class CreateUsersTable
 */
class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->increments('id')->comment('用户ID');

      $table->string('mobile', 20)->index('mobile')->nullable()->comment('手机号');
      $table->string('email', 100)->index('email')->nullable()->comment('邮箱');
      $table->string('password', 64)->nullable()->comment('密码');

      $table->enum('status', Status::getValues())->default(Status::ENABLE)->comment('状态');

      // timestamp fields
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('users');
    //
  }
}
