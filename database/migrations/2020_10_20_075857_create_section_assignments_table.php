<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eval_section_assignments', function (Blueprint $table) {
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('instructor_id');
            $table->integer('semester');

            $table
                ->foreign('section_id')
                ->on('eval_sections')
                ->references('id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table
                ->foreign('subject_id')
                ->on('eval_subjects')
                ->references('id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eval_section_assignments');
    }
}
