<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdImageSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_image_sizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type'); // original/thumbnail or any other image size
            $table->string('name');
            $table->unsignedBigInteger('ad_image_id')->nullable();
            $table->foreign('ad_image_id')->references('id')->on('ad_images')->onDelete('cascade');
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
        Schema::dropIfExists('ad_image_sizes');
    }
}
