<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleConfigrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_configrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('start_day')->nullable();
            $table->integer('end_day')->nullable();
            $table->enum('status', ['available', 'unavailable', 'break']);
            $table->integer('buffer_time')->comment('In Minitues');
            $table->integer('appointment_duration')->comment('In Minitues');
            $table->integer('max_user_allow')->default(1);
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
        Schema::dropIfExists('schedule_configrations');
    }
}
