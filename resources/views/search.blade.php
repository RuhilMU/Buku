<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        @if (Session::has('pesan'))
            <div class="alert alert-success">
                {{ session::get('pesan') }}
            </div>
        @endif


        @if (count($data_buku))
            <div class="alert alert-success">Ditemukan <strong>{{ count($data_buku) }}</strong> data dengan
                kata: <h4>{{ $cari }}</h4>
                <a href="/buku" class="btn btn-warning">Kembali</a>
            </div>
        @else
            <div class="alert alert-warning">
                <h4>Data {{ $cari }} tidak ditemukan</h4>
                <a href="/buku" class="btn btn-warning">Kembali</a>
            </div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <h1>Daftar Buku</h1>
            <a href="{{ route('create')}}" class="btn btn-primary float-end" style=" display:inline; margin-top: 10px; margin-bottom:10px ; float: right;margin-right:10px;">Tambah Buku</a>
        </div>    
    <form action="{{ route('search') }}" method="GET">@csrf
        <input type="text" name="kata" class="form-control" placeholder="Search..." style="width: 30%; display: inline;
        margin-top: 10px; margin-bottom: 10px; float: right;">
    </form>
    <table class="table table-stripped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Tgl Terbit</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
                @foreach($data_buku as $index => $buku)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $buku->judul }}</td>
                    <td>{{ $buku->penulis }}</td>
                    <td>{{ $buku->tgl_terbit->format('Y-m-d') }}</td>
                    <td>{{ "Rp. ".number_format($buku->harga, 0, ',','.') }}</td>
                    <td>
                        <form method="post" action="{{ route('edit', $buku->id) }}" style="display:inline;">
                            @csrf
                            <button onclick="return confirm('Edit nih?')" type="submit" class="btn btn-warning">Update</button>
                        </form>

                        <form action="{{ route('destroy', $buku->id) }}" method="post" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin di Hapus boi?')" type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div><strong>Jumlah Buku: {{ count($data_buku) }} </strong></div>
    </div>
</body>
</html>