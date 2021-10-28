<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQnaboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qnaboards', function (Blueprint $table) {
            $table->id();
            $table->string('author');
            $table->string('password');
            $table->string('title');
            $table->text('content');
            $table->unsignedInteger('hits')->default(0);
            $table->tinyInteger('secret_flag')->default(0)->comment('공개글:0, 비밀글:1(checkbox checked값)');
            $table->unsignedInteger('group')->nullable()->comment('부모글 번호로 그루핑');
            $table->unsignedInteger('step')->nullable()->comment('계층 정보');
            $table->unsignedInteger('indent')->nullable();

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
        Schema::dropIfExists('qnaboards');
    }
}
