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

        <div class="d-flex justify-content-between mb-2">
            <h1>Daftar Buku</h1>
        </div>
        <form action="{{ route('search') }}" method="GET" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="text" name="kata" class="form-control" placeholder="Search..." style="width: 30%;">
            </div>
        </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Gambar</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Tgl Terbit</th>
                <th>Harga</th>
                @if (Auth::User()->level == 'admin')
                <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($data_buku as $index => $buku)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $buku->id }}</td>
                    <td>
                        <img src="{{ asset('storage/img/'.$buku->image) }}" class="rounded" style="width: 150px">
                    </td>
                    <td>{{ $buku->judul }}</td>
                    <td>{{ $buku->penulis }}</td>
                    <td>{{ $buku->tgl_terbit->format('Y-m-d') }}</td>
                    @if($buku->discount)
                        <td>
                            <span style="color: red; text-decoration: line-through;">
                                Rp. {{ number_format($buku->harga, 0, ',', '.') }}
                            </span> |
                            <span class="badge bg-success pt-2 pb-2" >{{ $buku->discount_percentage }}% off</span> |
                            <strong style="color: green">Rp. {{ number_format($buku->discounted_price, 0, ',', '.') }}</strong>
                        </td>
                        @else
                            <td>{{ "Rp. ".number_format($buku->harga, 0, ',','.') }}</td>
                        @endif
                    @if (Auth::User()->level == 'admin')
                    <td>
                        <a href="{{ route('detail', $buku->id) }}" class="btn btn-primary">Detail</a>
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

                    @else
                        <td><a href="{{ route('detail', $buku->id) }}" class="btn btn-primary">Detail</a></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
        </table>
        <div><strong>Jumlah Buku: {{ count($data_buku) }} </strong></div>
    </div>
</body>
</html>