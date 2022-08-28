<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Management Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
</head>
<body>
    <div class="container mt-2">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="{{$barang->links()}}">Management Barang</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mutasibarang.index') }}">Mutasi Barang <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mutasibarang.laporan') }}">Laporan</a>
                </li>
                </ul>
            </div>
        </nav>

            <div class="col-lg-12 margin-tb">
                
                <div class="pull-right mb-2 mt-5">
                    <a class="btn btn-success" href="{{ route('barang.create') }}"> Tambah Barang Baru</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode barang</th>
                    <th>Nama Barang</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!$barang)
                <tr>
                    <td colspan="3" class="text-center">Tidak ada barang</td>
                </tr>
                @endif
                @foreach ($barang as $brg)
                    <tr>
                        <td>{{ $brg->kodeBarang }}</td>
                        <td>{{ $brg->namaBarang }}</td>
                        <td>
                            <form action="{{ route('barang.destroy',$brg->id) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('barang.edit',$brg->id) }}">Ubah</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        {!! $barang->links() !!}
    </div>
</body>
</html>