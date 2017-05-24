<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('context')->nullable();
            $table->string('file')->nullable();
            $table->dateTime('date')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->double('rate', 15, 2)->default('0.0');
            $table->integer('list_id')->unsigned()->index();
            $table->boolean('complete')->default(false);
            $table->timestamps();
        });
        Schema::table('todos', function($table) {
            $table->foreign('list_id')
                ->references('id')
                ->on('lists')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('todos');
    }
}
