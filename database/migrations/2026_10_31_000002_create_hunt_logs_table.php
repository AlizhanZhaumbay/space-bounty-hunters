<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hunt_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criminal_id')->constrained('wanted_criminals')->cascadeOnDelete();
            $table->boolean('success');
            $table->text('notes');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hunt_logs');
    }
};
