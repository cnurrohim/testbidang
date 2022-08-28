<?php

namespace App\Http\Controllers;
use App\Models\DetailMutasiBarang;
use App\Models\MutasiBarang;
use Illuminate\Http\Request;

class detailMutasiBarangController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $detailMutasiBarang = DetailMutasiBarang::orderBy('id','desc')->paginate(5);
        return view('detailmutasibarang.index', compact('detailMutasiBarang'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {   
        $currentDate = now()->format('Y-m-d');
        $statusBarang = [""=>"Status Barang" ,1 => "Masuk", 0 => "Keluar"];
        return view('detailmutasibarang.create', compact("statusBarang","currentDate"));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $validateMessages = [
            'unique' => 'kolom :attribute sudah ada di database.',
            'required' => 'kolom :attribute harus diisi.'
        ];

        $request->validate([
            'noBukti' => 'required|unique:mutasi_barang',
            'tanggal' => 'required',
            'isMasuk' => 'required|boolean',
        ], $validateMessages);
         
        $insertedData = MutasiBarang::create($request->post());

        foreach ($request->post('idBarang') as $key => $value) {
            $detailMutasiBarang = new DetailMutasiBarang();
            $detailMutasiBarang->idBukti = $insertedData->id;
            $detailMutasiBarang->idBarang = $request->post('idBarang')[$key];
            $detailMutasiBarang->isMasuk = $request->post('isMasuk');
            $detailMutasiBarang->quantity = $request->post('quantity')[$key];
            $detailMutasiBarang->save();
        }


        return redirect()->route('mutasiBarang.index')->with('success','Barang baru telah berhasil ditambahkan.');
    }
}
