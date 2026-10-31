<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wanted_criminals', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('nickname');
            $table->unsignedBigInteger('reward');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('location_note')->nullable();
            $table->unsignedTinyInteger('difficulty');
            $table->boolean('armed')->default(false);
            $table->boolean('has_crew')->default(false);
            $table->boolean('escape_master')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wanted_criminals');
    }
};
