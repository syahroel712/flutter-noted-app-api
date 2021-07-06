<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoteModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_note', function (Blueprint $table) {
            $table->bigIncrements('note_id');
            $table->integer('user_id')->nullable();
            $table->integer('folder_id')->nullable();
            $table->string('note_title')->nullable();
            $table->text('note_desc')->nullable();
            $table->enum('note_status', ['Active', 'Done'])->nullable();
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
        Schema::dropIfExists('tb_note');
    }
}
