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
            $table->unsignedBigInteger('tag');
            $table->string('title', 700);
            $table->string('metaTitle', 100);
            $table->string('slug', 100);
            $table->tinyText('sumary');
            $table->tinyInteger('published')->default(0);
            $table->text('content');
            $table->timestamps();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('authorId')->references('id')->on('users') ->onDelete('cascade');
            $table->foreign('parentId')->references('id')->on('posts');
            $table->index('id');
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
