<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 视频和图片
 * Class CreateImagesTable
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

            $table->unsignedInteger('user_id')->nullable();
            $table->string('url');
            $table->smallInteger('width');
            $table->smallInteger('height');

            // morph
            $table->morphs('imageable');

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
        Schema::drop('images');
    }
}
