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
        Schema::create('category', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary()->unique();
            $table->unsignedBigInteger('parentId');
            $table->string('title', 75);
            $table->string('metaTitle', 100);
            $table->string('slug',100);
            $table->text('content');
        });
        Schema::table('category', function (Blueprint $table) {
            $table->foreign('parentId')->references('id')->on('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category');
    }
};
