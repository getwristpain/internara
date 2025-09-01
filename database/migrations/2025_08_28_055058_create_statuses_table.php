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
            $table->string('name')->unique()->index();
            $table->string('type')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('flag')->default(false);
            $table->timestamps();
        });

        Schema::create('statusables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->constrained()->cascadeOnDelete();
            $table->morphs('statusable');
            $table->timestamps();

            $table->unique(['status_id', 'statusable_id', 'statusable_type'], 'statusables_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statusables');
        Schema::dropIfExists('statuses');
    }
};
