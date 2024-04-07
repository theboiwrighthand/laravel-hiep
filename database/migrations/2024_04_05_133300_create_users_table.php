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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id', 20);
            $table->string('firtName', 50);
            $table->string('middleName', 50);
            $table->string('lastName', 50);
            $table->string('mobile', 15)->unique();
            $table->string('email', 50)->unique();
            $table->string('passwordHash', 32);
            $table->dateTime('registerAt');
            $table->dateTime('lastLogin');
            $table->text('intro');
            $table->text('profile', 32);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
