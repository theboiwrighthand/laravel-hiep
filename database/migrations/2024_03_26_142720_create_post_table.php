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
        Schema::create('post', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parentId');
            $table->string('title', 75);
            $table->string('metaTitle', 100);
            $table->string('slug', 100);
            $table->text('summary');
            $table->dateTime('published');
            $table->dateTime('createdAt');
            $table->dateTime('updatedAt');
            $table->dateTime('publishedAt');
            $table->text('content');
            
            $table->foreignId('authorId')->constrained('user', 'id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post');
    }
};