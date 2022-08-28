<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Form Tambah Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>Tambah Barang</h2>
                </div>
                <div class="pull-right mt-5 mb-4">
                    <a class="" href="{{ route('barang.index') }}">< Kembali</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label class="col-form-label">Kode Barang:</label>
                        <input type="text" name="kodeBarang" class="form-control" placeholder="Kode Barang" value="{{ old('kodeBarang') }}">
                        @error('kodeBarang')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label class="col-form-label">Nama Barang:</label>
                        <input type="text" name="namaBarang" class="form-control" placeholder="Nama Barang"  value="{{ old('namaBarang') }}">
                        @error('namaBarang')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ml-3">Tambahkan Barang</button>
            </div>
        </form>
    </div>
</body>

</html>