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
        \DB::statement($this->dropView());
        \DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement($this->dropView());
    }

    private function createView(){
        return <<< SQL
                CREATE VIEW laporan_mutasi_barang AS
                    SELECT
                    mb.noBukti,
                    mb.tanggal,
                    dmb.isMasuk,
                    dmb.quantity,
                    dmb.idBarang,
                    b.kodeBarang,
                    b.namaBarang,
                    SUM(IF(dmb.isMasuk = 1,
                        dmb.quantity,-dmb.quantity
                    )) over (PARTITION BY b.id ORDER BY mb.tanggal) AS saldo
                    FROM mutasi_barang mb
                    JOIN detail_mutasi_barang dmb ON dmb.idBukti = mb.id
                    JOIN barang b ON b.id = dmb.idBarang
                    ORDER BY dmb.created_at;
                SQL;
    }

    private function dropView(){
        return <<< SQL
                    DROP VIEW IF EXISTS laporan_mutasi_barang;
                SQL;
    }
};
