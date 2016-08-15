<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Marks11 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('marks_1_1', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('sid')->unique()->references('id')->on('students')->comment('refers to the student uinque id in student table');
          $table->string('usn',10)->unique()->references('usn')->on('users')->comment('refers the usn of the student');
          $table->integer('14mat11');
          $table->integer('14phy12');
          $table->integer('14civ13');
          $table->integer('14eme14');
          $table->integer('14ele15');
          $table->integer('14wsl16');
          $table->integer('14phyl17');
          $table->integer('14cip18');
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
      Schema::drop('marks_1_1');
    }
}
