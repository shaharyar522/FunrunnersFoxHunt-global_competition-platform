<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // user. lgoin .
    // super admin .  user crud. () emil , usernme. pwr
    // task . ek user tble ek task (id, title, name, description ,)
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('voting_contestants', function (Blueprint $table) {

            $table->id();
            $table->foreignId('voting_id')->nullable()->constrained('votings', 'voting_id')->onDelete('cascade');
            $table->foreignId('contestant_id')->constrained('contestants')->onDelete('cascade');
            $table->decimal('payments', 10, 2)->default(0); // payment amount
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voting_contestants');
    }
};
