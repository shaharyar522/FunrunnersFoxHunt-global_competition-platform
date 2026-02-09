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
        Schema::create('contestants', function (Blueprint $table) {


            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('image')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('contact')->nullable(); // Contact number
            $table->string('email')->unique();
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('set null');
            $table->text('bio')->nullable();
            $table->tinyInteger('payment_status')->default(0); // 0=not paid, 1=paid
            $table->tinyInteger('profile_status')->default(0); // 0=incomplete, 1=complete
            $table->tinyInteger('status')->default(1); // 0=inactive/blocked, 1=active
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contestants');
    }
};
