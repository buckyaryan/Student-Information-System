<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('students', function (Blueprint $table) {
        $table->increments('id');
        $table->string('usn',10)->unique();
        $table->string('name',50);
        $table->string('email',50)->unique();
        $table->string('password');
        $table->integer('semester');
        $table->integer('phone')->unique();
        $table->text('address',255);
        $table->rememberToken();
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
      Schema::drop('students');
  }
}
