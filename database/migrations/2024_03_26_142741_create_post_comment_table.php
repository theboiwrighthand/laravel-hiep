<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parentId');
            $table->string('title', 100);
            $table->tinyInteger('published');
            $table->dateTime('createdAt');
            $table->dateTime('publishedAt');
            $table->text('content');

            $table->foreignId('postId')->constrained('post','id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_comments');
    }
};