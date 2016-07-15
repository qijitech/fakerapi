<?php

use App\Enum\Platform;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * 第三方登录Token
 * Class CreateUserTokensTable
 */
class CreateUserTokensTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_tokens', function (Blueprint $table) {
      $table->unsignedInteger('user_id')->primary()->comment('用户ID');

      $table->string('open_id', 64)->comment('第三方平台ID');
      $table->enum('platform', Platform::getValues())->default(Platform::QQ)->comment('平台类型');
      $table->boolean('is_bind')->default(true)->comment('是否绑定')->default(true);

      $table->text('platform_info')->comment('平台信息');

      $table->unique(['open_id', 'platform']);

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
    Schema::dropIfExists('user_tokens');
    //
  }
}
