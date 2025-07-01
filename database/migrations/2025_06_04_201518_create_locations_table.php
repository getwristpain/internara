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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('locations')->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['province', 'regency', 'district', 'village']);
            $table->string('postal_code')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['parent_id', 'type', 'name'], 'unique_parent_type_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
