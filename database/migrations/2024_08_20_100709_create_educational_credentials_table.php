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
        Schema::create('educational_credentials', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('user_id');
            $table->string('school')->nullable();
            $table->string('sscGpa')->nullable();
            $table->string('college')->nullable();
            $table->string('hscGpa')->nullable();
            $table->string('university')->nullable();
            $table->string('degree')->nullable();
            $table->string('gradYear')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_credentials');
    }
};
