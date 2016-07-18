<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 举报
 * Class CreateReportRecordsTable
 */
class CreateReportRecordsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('report_records', function (Blueprint $table) {
      $table->increments('id')->comment('举报id');

      $table->unsignedTinyInteger('type')->default(0)->comment('举报类型');

      // morph
//      $table->morphs('reportable');
      $table->unsignedInteger("reportable_id");
      $table->string("reportable_type", 20);
      $table->index(["reportable_id", "reportable_type"]);

      $table->unsignedInteger('informer_id')->nullable()->comment('举报人用户ID');

      // timestamp fields
      $table->timestamps();

      // foreign key
      $table->foreign('informer_id')->references('id')->on('users');
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
    Schema::dropIfExists('report_records');
    //
  }
}
