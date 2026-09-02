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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->string('term')->nullable();
            $table->enum('type', ['A-ORD', 'ORD', 'RES']);
            $table->bigInteger('resono')->nullable();
            $table->date('session_date')->nullable();
            $table->string('title')->nullable();
            $table->string('status')->nullable();
            $table->string('authorid')->nullable();
            $table->string('authorname')->nullable();
            $table->string('authoracronym')->nullable();
            $table->string('coauthorid')->nullable();
            $table->string('coauthorname')->nullable();
            $table->string('coauthoracronym')->nullable();
            $table->string('mainclassid')->nullable();
            $table->string('mainclassname')->nullable();
            $table->string('class2id')->nullable();
            $table->string('class2name')->nullable();
            $table->integer('sectorid')->nullable();
            $table->integer('sectorname')->nullable();
            $table->text('filepath')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
