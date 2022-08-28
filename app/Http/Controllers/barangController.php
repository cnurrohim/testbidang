<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use Illuminate\Http\Request;

class barangController extends Controller
{
    /**
    * tampilan index.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $barang = Barang::orderBy('id','desc')->paginate(5);
        return view('barang.index', compact('barang'));
    }

    /**
    * tampilkan form barang baru.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('barang.create');
    }

    /**
    * Simpan barang ke dalam database.
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
            'kodeBarang' => 'required|unique:barang',
            'namaBarang' => 'required',
        ], $validateMessages);

         
        Barang::create($request->post());

        return redirect()->route('barang.index')->with('success','Barang baru telah berhasil ditambahkan.');
    }

    /**
    * menampilkan detail barang.
    *
    * @param  \App\Barang  $barang
    * @return \Illuminate\Http\Response
    */
    public function show(Barang $barang)
    {
        return view('barang.show',compact('barang'));
    }

    /**
    * menampilkan form edit.
    *
    * @param  \App\Barang  $barang
    * @return \Illuminate\Http\Response
    */
    public function edit(Barang $barang)
    {
        return view('barang.edit',compact('barang'));
    }

    /**
    * Update informasi barang.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Barang  $barang
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'namaBarang' => 'required',
        ]);
        
        $barang->fill($request->post())->save();

        return redirect()->route('barang.index')->with('success','Informasi barang telah berhasil diupdate');
    }

    /**
    * hapus barang.
    *
    * @param  \App\Barang  $barang
    * @return \Illuminate\Http\Response
    */
    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')->with('success','Barang telah berhasil dihapus dari database');
    }

    /**
     * Tampilkan suggestion barang untuk input.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function searchQuery(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $data = Barang::searchBarang($request);
        }
        return response()->json($data);
    }
}
