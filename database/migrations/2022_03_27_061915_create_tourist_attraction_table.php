<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTouristAttractionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourist_attraction', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->integer('id_open_close')->nullable();
            $table->string('phone');
            $table->string('email_contact')->nullable();
            $table->string('website_information')->nullable();
            $table->string('ticket_price')->nullable();
            $table->integer('review_five_star')->nullable();
            $table->integer('review_four_star')->nullable();
            $table->integer('review_three_star')->nullable();
            $table->integer('review_two_star')->nullable();
            $table->integer('review_one_star')->nullable();
            $table->text('full_review')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('tourist_attraction');
    }
}
