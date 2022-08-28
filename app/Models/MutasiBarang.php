<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetailMutasiBarang;
use App\Traits\Uuids;

class MutasiBarang extends Model
{
    use Uuids;
    use HasFactory;

    protected $table = 'mutasi_barang';
    protected $fillable = ['noBukti', 'tanggal','isMasuk'];
    const STATUSBARANG = [ ""=>"Status Barang" ,1 => "Masuk", 0 => "Keluar" ];

    public function DetailMutasiBarang()
    {
        return $this->hasMany(DetailMutasiBarang::class,'idBukti','id');
    }

    
}
