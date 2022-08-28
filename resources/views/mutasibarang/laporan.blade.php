<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Form Mutasi Barang</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <style>
        .select2-selection__rendered {
            line-height: calc(1.5em + .75rem + 2px) !important;
        }
        .select2-container .select2-selection--single {
            height: calc(1.5em + .75rem + 2px) !important;
        }
        .select2-selection__arrow {
            height: calc(1.5em + .75rem + 2px) !important;
        }
    </style>
</head>

<body>
    
    <div class="container mt-2 mb-4">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>Laporan Mutasi Barang</h2>
                </div>
                <hr/>
                <div class="pull-right">
                    <a class="" href="{{ route('mutasibarang.index') }}"> Kembali</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        
        <form action="{{ route('mutasibarang.laporan') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tanggal Mutasi</label>
                        <div class="col-sm-2">
                            <input type="date" name="tanggalMulai" class="form-control" placeholder="Tanggal Awal"  value="{{ $tanggalMulai }}">
                        </div>
                        <div class="col-sm-2">
                            <input type="date" name="tanggalAkhir" class="form-control" placeholder="Tanggal Akhir"  value="{{ $tanggalAkhir }}">
                        </div>
                        @error('tanggal')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Barang</label>
                        <div class="col-sm-4">
                            <select class="autocompletebarang form-control" style="height: 100%" name="idBarang" id="selectedKodeBarang"></select>
                        </div>
                        @error('tanggal')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>  
                <button type="submit" class="btn btn-outline-primary ml-3">Filter</button>
            
        </form>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-5">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>No. Bukti</th>
                                <th>No. Barang</th>
                                <th>IN</th>
                                <th>OUT</th>
                                <th>SALDO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($mutasiBarang) == 0)
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada barang dan mutasi</td>
                            </tr>
                            @endif
                            @foreach ($mutasiBarang as $mutasi)
                               <tr>
                                    <td>{{ $mutasi->tanggal }}</td>
                                    <td>{{ $mutasi->noBukti }}</td>
                                    <td>{{ $mutasi->kodeBarang }}-{{ $mutasi->namaBarang }}</td>
                                    <td>
                                        @if($mutasi->isMasuk)
                                            {{ $mutasi->quantity }}
                                        @endif
                                    </td>
                                    <td>@if(!$mutasi->isMasuk)
                                            {{ $mutasi->quantity }}
                                        @endif</td>
                                    <td>{{$mutasi->saldo}}</td>
                                </tr> 
                            @endforeach
                        </tbody>
                    </table>
                </div>
    </div>
</body>

<script>
    $('.autocompletebarang').select2({
        placeholder: 'Select Barang',
        ajax: {
            url: '/barang/searchQuery',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.kodeBarang+'-'+item.namaBarang,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>
</html>