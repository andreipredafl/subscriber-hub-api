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
        Schema::create('field_subscriber', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscriber_id')->constrained()->cascadeOnDelete();
            $table->foreignId('field_id')->constrained()->cascadeOnDelete();
            $table->longText('value');
            $table->timestamps();

            $table->unique(['subscriber_id', 'field_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_subscriber');
    }
};
