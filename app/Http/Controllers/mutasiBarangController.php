<?php

namespace App\Http\Controllers;
use App\Models\MutasiBarang;
use App\Models\DetailMutasiBarang;
use App\Models\LaporanMutasiBarang;
use Illuminate\Http\Request;

class mutasiBarangController extends Controller
{
    /**
    * halaman index mutasi barang
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $mutasiBarang = MutasiBarang::orderBy('id','desc')->paginate(5);
        return view('mutasibarang.index', compact('mutasiBarang'));
    }

    /**
    * menampilkan view laporan mutasi
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function laporan(Request $request)
    {
        
        $tanggalMulai = $request->post('tanggalMulai') ? $request->post('tanggalMulai') : now()->format('Y-m-d');
        $tanggalAkhir = $request->post('tanggalAkhir') ? $request->post('tanggalAkhir') : now()->format('Y-m-d');
        

        if( $request->post('tanggalMulai') && $request->post('tanggalAkhir') ){
            $mutasiBarang = LaporanMutasiBarang::select("*")
            ->WhereBetween("tanggal",[$request->post('tanggalMulai'),$request->post('tanggalAkhir')])
            ->Where("idBarang",$request->post('idBarang'))
            ->orderBy("tanggal","ASC")
            ->get();
        }else{
            $mutasiBarang = LaporanMutasiBarang::select("*")->orderBy("tanggal","ASC")->get();
        }

        return view('mutasibarang.laporan', compact('mutasiBarang','tanggalAkhir','tanggalMulai'));
    }

    /**
    * menampilkan form mutasi barang
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $currentDate = now()->format('Y-m-d');
        $statusBarang = MutasiBarang::STATUSBARANG;
        return view('mutasibarang.create', compact("statusBarang","currentDate"));
    }

    /**
    * simpan mutasi barang.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        
            $validateMessages = [
                'unique' => ':attribute sudah ada di database.',
                'required' => 'harus diisi.'
            ];

            $request->validate([
                'noBukti' => 'required|unique:mutasi_barang',
                'tanggal' => 'required',
                'isMasuk' => 'required|boolean',
            ], $validateMessages);
         
            $insertedData = MutasiBarang::create($request->post());
            
            if($request->post('idBarang')){
                foreach ($request->post('idBarang') as $key => $idBarang) {
                    $detailMutasiBarang = new DetailMutasiBarang();
                    $detailMutasiBarang->idBukti = $insertedData->id;
                    $detailMutasiBarang->idBarang = $idBarang;
                    $detailMutasiBarang->isMasuk = $request->post('isMasuk');
                    $detailMutasiBarang->quantity = $request->post('quantity')[$key];
                    $detailMutasiBarang->save();
                }
            }

        return redirect()->route('mutasibarang.index')->with('success','Barang baru telah berhasil ditambahkan.');
    }

    /**
    * tampilkan form edit mutasi
    *
    * @param  \App\Barang  $barang
    * @return \Illuminate\Http\Response
    */
    public function edit(MutasiBarang $mutasibarang)
    {
        $detailMutasi = DetailMutasiBarang::with("barang")->Where("idBukti",$mutasibarang->id)->get();
        
        $statusBarang = MutasiBarang::STATUSBARANG;
        return view('mutasibarang.edit',compact('mutasibarang','statusBarang','detailMutasi'));
    }

    /**
    * tampilkan detail mutasi barang
    *
    * @param  \App\MutasiBarang  $mutasibarang
    * @return \Illuminate\Http\Response
    */
    public function show(MutasiBarang $mutasibarang)
    {
        return view('mutasibarang.show',compact('mutasibarang'));
    }

    /**
    * Update mutasi barang.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\MutasiBarang  $mutasibarang
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, MutasiBarang $mutasibarang)
    {
        
        $validateMessages = [
            'unique' => 'kolom :attribute sudah ada di database.',
            'required' => 'kolom :attribute harus diisi.'
        ];

        $request->validate([
            'noBukti' => 'required',
            'tanggal' => 'required',
            'isMasuk' => 'required|boolean',
        ], $validateMessages);
        
        
        $mutasibarang->fill($request->post())->save();

        DetailMutasiBarang::where("idBukti",$mutasibarang->id)->delete();
        if($request->post('idBarang')){
            foreach ($request->post('idBarang') as $key => $idBarang) {
                $detailMutasiBarang = new DetailMutasiBarang();
                $detailMutasiBarang->idBukti = $mutasibarang->id;
                $detailMutasiBarang->idBarang = $idBarang;
                $detailMutasiBarang->isMasuk = $request->post('isMasuk');
                $detailMutasiBarang->quantity = $request->post('quantity')[$key];
                $detailMutasiBarang->save();
            }
        }
        


        return redirect()->route('mutasibarang.index')->with('success','Informasi mutasi barang telah berhasil diupdate');
    }

    /**
    * delete mutasi barang
    *
    * @param  \App\MutasiBarang  $mutasibarang
    * @return \Illuminate\Http\Response
    */
    public function destroy(MutasiBarang $mutasibarang)
    {
        $mutasibarang->delete();
        return redirect()->route('mutasibarang.index')->with('success','Mutasi telah berhasil dihapus dari database');
    }
}
