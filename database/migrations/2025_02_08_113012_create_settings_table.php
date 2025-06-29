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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // e.g., boolean, integer
            $table->string('label')->nullable();
            $table->string('category')->nullable(); // e.g., general, security
            $table->text('description')->nullable(); // e.g., description of the setting
            $table->timestamps();

            // unique constraint for key and category
            $table->unique(['key', 'category'], 'settings_key_category_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
