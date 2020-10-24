<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikeCommentPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like_comment_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('commentPost_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('commentPost_id')->references('id')->on('comment_posts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('like_comment_posts');
    }
}
