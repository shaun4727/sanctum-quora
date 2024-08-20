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
        Schema::create('employment_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('position')->nullable();
            $table->string('company')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->integer('currentlyWorkHere')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employment_credentials');
    }
};
