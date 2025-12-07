<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('rent_price', 10, 2);
            $table->string('address');
            $table->boolean('availability')->default(true);
            $table->string('owner_info');
            $table->timestamps();  // correct spelling
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};