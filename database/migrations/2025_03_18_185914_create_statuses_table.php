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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('general');
            $table->string('label')->nullable();
            $table->string('description')->nullable();
            $table->integer('priority')->nullable();
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_default')->default(false);
            $table->unique(['name', 'type']);
            $table->timestamps();
        });

        Schema::create('statusables', function (Blueprint $table) {
            $table->foreignId('status_id')->constrained()->cascadeOnDelete();
            $table->string('statusable_id');
            $table->string('statusable_type');
            $table->timestamps();

            $table->primary(['status_id', 'statusable_id', 'statusable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
