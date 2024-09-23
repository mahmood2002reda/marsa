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
    {Schema::table('users', function (Blueprint $table) {
        $table->after('remember_token', function (Blueprint $table) {
            $table->string('verification_token')->nullable();
            $table->timestamp('verification_token_till')->nullable();
        });
    });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
