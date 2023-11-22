<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('servidor_id');
            $table->unsignedBigInteger('vm_id');
            $table->string('hash_server');
            $table->string('ip_server');
            $table->string('hash_vm');
            $table->enum('acao', ['1', '2', '3', '4', '5', '6']);
            $table->longText('resultado')->nullable();
            $table->enum('status', ['0', '1'])->default('0');
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
        Schema::dropIfExists('acoes');
    }
}
