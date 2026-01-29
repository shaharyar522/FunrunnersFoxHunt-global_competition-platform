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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Member who voted
            $table->foreignId('contestant_id')->constrained('contestants')->onDelete('cascade'); // Who they voted for
            $table->foreignId('voting_id')->constrained('votings', 'voting_id')->onDelete('cascade'); // Which round
            $table->timestamps();

            // Enforce ONE VOTE per Member per Round
            $table->unique(['user_id', 'voting_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
