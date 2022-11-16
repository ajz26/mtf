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
        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('private')->default(false);
            $table->integer('max_users')->nullable();
            $table->integer('max_attempts')->default(25);
            $table->string('category')->nullable();
            $table->string('state')->nullable();
            $table->integer('hot_level')->default(0);
            $table->datetime('last_activity_at')->nullable();
            $table->uuid('last_activity_by')->nullable();
            $table->datetime('started_at')->nullable();
            $table->datetime('finished_at')->nullable();
            $table->string('invitation_code');
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
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
        Schema::dropIfExists('rooms');
    }
};
