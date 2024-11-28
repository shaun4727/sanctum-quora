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
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('answer_id')->constrained()->cascadeOnDelete(); // Foreign key to answers table
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Foreign key to users table
            $table->foreignId('parent_id')->nullable()->constrained('comments')->cascadeOnDelete(); // Self-referencing for nested comments
            $table->text('content'); // Comment content
            $table->unsignedInteger('likes')->default(0); // Number of likes
            $table->unsignedInteger('dislikes')->default(0); // Number of dislikes
            $table->timestamps(); // Created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
