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
        Schema::create('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary()->unique();
            $table->unsignedBigInteger('authorId');
            $table->unsignedBigInteger('parentId');
            $table->string('title', 75);
            $table->string('metaTitle', 100);
            $table->string('slug', 100);
            $table->tinyText('sumary');
            $table->tinyInteger('published')->default(0);
            $table->dateTime('createdAt');
            $table->dateTime('updatedAt');
            $table->dateTime('publishedAt');
            $table->text('content');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('authorId')->references('id')->on('users');
            $table->foreign('parentId')->references('id')->on('posts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};