<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MutasiBarang;
use App\Traits\Uuids;

class DetailMutasiBarang extends Model
{
    use Uuids;
    use HasFactory;

    protected $table = "detail_mutasi_barang";
    protected $fillable = ['idBarang','idBukti', 'isMasuk', 'quantity'];

    public function MutasiBarang()
    {
        return $this->belongsTo(MutasiBarang::class,'idBukti','id');
    }

    public function Barang()
    {
        return $this->hasOne(Barang::class,'id','idBarang');
    }
}
