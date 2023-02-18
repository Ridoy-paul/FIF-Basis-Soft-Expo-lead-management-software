<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_infos', function (Blueprint $table) {
            $table->id();
            $table->mediumText('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->mediumText('address')->nullable();
            $table->mediumText('fathers_name')->nullable();
            $table->mediumText('mothers_name')->nullable();
            $table->integer('subject_id')->nullable();
            $table->integer('institute_id')->nullable();
            $table->mediumText('class_or_semester')->nullable();
            $table->mediumText('interested_course')->nullable();
            $table->integer('added_by')->nullable();
            $table->string('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_infos');
    }
}
