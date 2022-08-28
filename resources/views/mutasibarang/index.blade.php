<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Management Mutasi Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
</head>
<body>
    <div class="container mt-2">
        <div class="row">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="{{$mutasiBarang->links()}}">Management Mutasi Barang</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('barang.index') }}">Barang <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mutasibarang.laporan') }}">Laporan</a>
                </li>
                </ul>
            </div>
        </nav>

        
            <div class="col-lg-12 margin-tb">
                <div class="pull-right mb-4 mt-5">
                    <a class="btn btn-success" href="{{ route('mutasibarang.create') }}"> Tambah Mutasi Barang Baru</a>
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
                    <th>No Bukti</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($mutasiBarang) == 0 )
                    <tr>
                        <td class="text-center" colspan="4">Belum ada mutasi barang</td>
                    </tr>
                @endif
                @foreach ($mutasiBarang as $mutasi)
                    <tr>
                        <td>{{ $mutasi->noBukti }}</td>
                        <td>{{ $mutasi->tanggal }}</td>
                        @if ($mutasi->isMasuk == 1)
                            <td>Masuk</td>
                        @else
                            <td>Keluar</td>
                        @endif
                        <td>
                            <form action="{{ route('mutasibarang.destroy',$mutasi->id) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('mutasibarang.edit',$mutasi->id) }}">Ubah</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus Mutasi</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        {!! $mutasiBarang->links() !!}
    </div>
</body>
</html>