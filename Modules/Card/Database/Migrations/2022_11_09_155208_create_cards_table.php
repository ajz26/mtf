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
        Schema::create('cards', function (Blueprint $table) {
            
            $table->uuid('id')->primary();
            $table->string('title')->nullable();
            $table->longText('content');
            $table->string('category')->nullable();
            
            $table->enum('response_type',[
               'IMAGE',
               'VIDEO',
               'MESSAGE'
            ])->default('MESSAGE');

            $table->enum('card_type',[
                'QUESTION',
                'TRICK',
            ])->default('QUESTION');


            $table->integer('hot_level')->default(0);

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
};
