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
        Schema::create('gula_darahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users');
            $table->string('tanggal')->comment('dd-mm-YYYY');
            $table->string('jam');
            $table->string('kadar');
            $table->tinyInteger('type')->comment('0: Sebelum Makan, 1: Sesudah Makan, 2: Puasa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gula_darahs');
    }
};
