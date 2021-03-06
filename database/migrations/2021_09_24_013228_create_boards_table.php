<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('title');
            $table->text('content');
            $table->text('file_name')->nullable();
            $table->text('file_path')->nullable();
            $table->timestamps();

            // $table->foreign('name')->references('name')->on('users');
            // $table->foreign('email')->references('email')->on('users');
            $table->foreign(["name", "email"])->references(["name", "email"])->on('users')
                ->onDelete('NO ACTION')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
}
