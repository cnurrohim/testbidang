<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Http\Request;

class Barang extends Model
{
    use Uuids;
    use HasFactory;
    protected $table = 'barang';

    protected $fillable = ['kodeBarang', 'namaBarang'];
    
    public static function searchBarang(Request $request){
        $search = $request->q;
        $data = Barang::select("id","kodeBarang","namaBarang")
                            ->where("namaBarang","LIKE","%$search%")
                            ->orWhere("kodeBarang","LIKE","%$search%")
                            ->get();
        
        return $data;
    }
}
