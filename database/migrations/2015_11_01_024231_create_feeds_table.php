<?php

use App\Enum\Status;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 动态
 * Class CreateFeedsTable
 */
class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();

            $table->enum('status', Status::getKeys())->default(Status::ENABLE)->comment('状态');
            $table->string('content')->nullable();

            $table->unsignedInteger('share_times')->default(0)->comment('分享次数');
            $table->unsignedInteger('browse_times')->default(0)->comment('浏览次数');
            $table->unsignedInteger('comment_times')->default(0)->comment('评论次数');

            // timestamp fields
            $table->timestamps();

            // foreign key
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('feeds');
    }
}
