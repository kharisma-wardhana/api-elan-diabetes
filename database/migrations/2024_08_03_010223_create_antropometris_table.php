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
        Schema::create('antropometris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users');
            $table->double('tinggi');
            $table->double('berat');
            $table->double('lingkar_perut');
            $table->double('lingkar_lengan');
            $table->double('hasil');
            $table->tinyInteger('status')->comment('0: Kurus, 1: Normal, 2: Obesitas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antropometris');
    }
};
