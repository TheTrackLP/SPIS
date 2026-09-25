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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('authorfirstname')->nullable();
            $table->string('authormiddlename')->nullable();
            $table->string('authorlastname')->nullable();
            $table->string('authorbirtdate')->nullable();
            $table->integer('authorcurrentterm')->nullable();
            $table->integer('authorstatus')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
