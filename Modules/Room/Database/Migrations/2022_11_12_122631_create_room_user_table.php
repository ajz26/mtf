<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_user', function (Blueprint $table) {
            $table->foreignUuid('room_id')->references('id')->on('rooms')->onDelete('Cascade');
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('Cascade');
            $table->integer('order')->nullable();
            $table->primary(['room_id','user_id']);
            $table->dateTime('added_at')->nullable();
            $table->dateTime('removed_at')->nullable();
            $table->uuid('removed_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_user');
    }
};
