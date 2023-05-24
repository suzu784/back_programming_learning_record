<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('goal')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('title');
            $table->text('body');
            $table->boolean('is_draft')->default(false);
            $table->date('learning_date');
            $table->unsignedBigInteger('duration');
            $table->timestamps();
        });

        Schema::create('chat_g_p_t_s', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('record_id')->unsigned();
            $table->foreign('record_id')->references('id')->on('records')->cascadeOnDelete();
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('record_id')->unsigned();
            $table->foreign('record_id')->references('id')->on('records')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('record_id')->unsigned();
            $table->foreign('record_id')->references('id')->on('records')->cascadeOnDelete();
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('tag_records', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('record_id')->unsigned();
            $table->foreign('record_id')->references('id')->on('records')->cascadeOnDelete();
            $table->bigInteger('tag_id')->unsigned();
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->timestamps();
        });

        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name');
            $table->text('content');
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
        Schema::dropIfExists('chat_g_p_t_s');
        Schema::dropIfExists('likes');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('tag_records');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('records');
        Schema::dropIfExists('templates');
        Schema::dropIfExists('users');
    }
};
