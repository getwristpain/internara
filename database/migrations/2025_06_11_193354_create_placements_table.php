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
        Schema::create('placements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')
                ->constrained('programs')->cascadeOnDelete();
            $table->foreignId('company_id')
                ->constrained('companies')->cascadeOnDelete();
            $table->foreignId('student_id')
                ->constrained('students')->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()
                ->constrained('teachers')->nullOnDelete();
            $table->foreignId('supervisor_id')->nullable()
                ->constrained()->nullOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('placements');
    }
};
