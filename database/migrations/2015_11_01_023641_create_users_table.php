<?php

use App\Enum\Sex;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * 用户表
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
            $table->increments('id')->comment('主键id');

            $table->string('phone', 16)->unique()->comment('手机号');
            $table->string('nickname', 32)->nullable()->unique()->comment('昵称');
            $table->string('real_name', 32)->nullable()->comment('用户真实姓名');
            $table->string('email', 64)->nullable()->unique()->comment('邮箱');
            $table->string('password', 64)->comment('密码');

            $table->string('avatar', 64)->nullable()->comment('用户头像');
            $table->enum('sex', Sex::getKeys())->default(Sex::MALE)->comment('用户性别');

            $table->rememberToken();
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
        Schema::drop('users');
    }
}
