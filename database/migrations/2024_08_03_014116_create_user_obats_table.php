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
        Schema::create('user_obats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users');
            $table->string('nama');
            $table->integer('dosis');
            $table->integer('type');
            $table->string('tanggal')->comment('dd-mm-YYYY');
            $table->tinyInteger('status')->comment('0: Terlewat, 1: Sudah Diminum')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_obats');
    }
};
