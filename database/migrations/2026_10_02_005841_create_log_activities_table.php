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
        Schema::create('log_activities', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->enum('action', ['created', 'updated', 'login', 'logout', 'printed']);
            $table->string('event_type');
            $table->string('module');
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->longText('subject_label')->nullable();
            $table->string('field_name')->nullable();
            $table->mediumText('old_value')->nullable();
            $table->mediumText('new_value')->nullable();
            $table->longText('create_value')->nullable();
            $table->timestamps();

            $table->index(['module', 'event_type']);
            $table->index(['subject_type', 'subject_id']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_activities');
    }
};
