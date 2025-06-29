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
            $table->string('key')->unique();
            $table->string('type');
            $table->string('label');
            $table->string('description')->nullable();
            $table->integer('priority')->default(0);
            $table->boolean('flag')->default(false);
            $table->boolean('is_default')->default(false);
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();

            // unique constraint for type and key
            $table->unique(['type', 'key'], 'unique_type_key');

            // index for faster lookups
            $table->index(['type', 'flag'], 'index_type_flag');
            $table->index(['type', 'is_default'], 'index_type_is_default');
            $table->index(['type', 'priority'], 'index_type_priority');
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
        Schema::dropIfExists('statusables');
        Schema::dropIfExists('statuses');
    }
};
