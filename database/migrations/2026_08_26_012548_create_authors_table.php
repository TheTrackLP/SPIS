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
            $table->string('authorhead')->nullable();
            $table->string('authordesc')->nullable();
            $table->string('authoroffice')->nullable();
            $table->string('authoracronym')->nullable();
            $table->string('authorposition')->nullable();
            $table->string('authorterm')->nullable();
            $table->integer('authorstatus')->default(1);
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
