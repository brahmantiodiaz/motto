<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTProjectBoardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_project_board', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('batch_id');
            $table->foreign('batch_id')
                ->references('id')
                ->on('m_batch')
                ->onDelete('cascade');
            $table->unsignedBigInteger('story_id');
            $table->foreign('story_id')
                ->references('id')
                ->on('m_story')
                ->onDelete('cascade');
            $table->enum('status', ['O','D'])->nullable();
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
        Schema::dropIfExists('t_project_board');
    }
}
