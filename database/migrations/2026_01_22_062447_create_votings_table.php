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
        Schema::create('votings', function (Blueprint $table) {

            $table->id('voting_id');
            $table->string('title');
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('set null');
            $table->date('creationdate');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votings');
    }
    
};
