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
            // placement id
            $table->id();

            // program id
            $table->foreignId('program_id')
                ->constrained('programs')
                ->onDelete('cascade');

            // department id
            $table->foreignId('department_id')
                ->constrained('departments')
                ->onDelete('cascade');

            // company id
            $table->foreignId('company_id')
                ->constrained('companies')
                ->onDelete('cascade');

            // student id
            $table->foreignId('student_id')
                ->constrained('students')
                ->onDelete('cascade');

            // teacher id
            $table->foreignId('teacher_id')
                ->nullable()
                ->constrained('teachers')
                ->onDelete('cascade');

            // supervisor id
            $table->foreignId('supervisor_id')
                ->nullable()
                ->constrained('supervisors')
                ->onDelete('cascade');

            // placement dates
            $table->date('start_date');
            $table->date('end_date');

            // additional fields
            $table->text('notes')->nullable();
            $table->timestamps();

            // indexes
            $table->index(['student_id', 'program_id', 'department_id', 'company_id', 'supervisor_id', 'teacher_id'], 'placements_index');
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
