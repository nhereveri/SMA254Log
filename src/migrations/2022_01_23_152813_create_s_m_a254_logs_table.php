<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMA254LogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('SMA254LOG', function (Blueprint $table) {
            $table->integer('unixtime');
            $table->integer('uf');
            $table->integer('proceso');
            $table->char('id', 36)->unique();
            $table->json('data');
            $table->primary(['unixtime', 'uf', 'proceso']);
            $table->integer('enviado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SMA254LOG');
    }
}
