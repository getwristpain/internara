<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('general');
            $table->string('label');
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['type', 'name']);
        });

        Schema::create('statusables', function (Blueprint $table) {
            $table->foreignId('status_id')->constrained('statuses')->cascadeOnDelete();
            $table->string('statusable_id');
            $table->string('statusable_type');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index(['statusable_type', 'statusable_id',]);
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
