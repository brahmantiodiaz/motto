<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMBatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_batch', function (Blueprint $table) {
            $table->id();
            $table->string('batch_no', 50);
            $table->unsignedBigInteger('technology_id');
            $table->foreign('technology_id')
                ->references('id')
                ->on('m_technology')
                ->onDelete('cascade');
            $table->unsignedBigInteger('trainer_id');
            $table->foreign('trainer_id')
                ->references('id')
                ->on('m_trainer')
                ->onDelete('cascade');
            $table->enum('status',['O','D']);
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
        Schema::dropIfExists('m_batch');
    }
}
