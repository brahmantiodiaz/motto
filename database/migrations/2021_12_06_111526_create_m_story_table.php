<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMStoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_story', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->addColumn('integer', 'score', ['length' => 2]);
            $table->enum('type', ['M','T','R']);
            $table->addColumn('integer','priority',['length' => 3,])->nullable();
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
        Schema::dropIfExists('m_story');
    }
}
