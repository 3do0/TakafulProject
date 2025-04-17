<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->bigIncrements('id')->startingValue(2025001)->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('avatar')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('gender' , ['male' , 'female']);
            $table->string('country');
            $table->boolean('is_online')->default(false);
            $table->string('otp')->nullable(); 
            $table->boolean('is_verified')->default(false);
            $table->timestamp('otp_expires_at')->nullable(); 
            $table->rememberToken();
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};
