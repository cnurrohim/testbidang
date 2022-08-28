<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_mutasi_barang', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid("idBarang");
            $table->uuid("idBukti");
            $table->boolean("isMasuk",1);
            $table->double("quantity");
            $table->timestamps();
            $table->foreign('idBarang')->references('id')->on('barang')->onDelete('cascade') ;
            $table->foreign('idBukti')->references('id')->on('mutasi_barang')->onDelete('cascade') ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_mutasi_barang');
    }
};
