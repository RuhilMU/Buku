@extends('layouts.app')

@section('content')
<div class="container mt-5">
        @if(Session::has('pesandelete'))
            <div class="alert alert-success">
                {{ Session::get('pesandelete') }}
            </div>
        @endif
        @if(Session::has('pesanupdate'))
            <div class="alert alert-success">
                {{ Session::get('pesanupdate') }}
            </div>
        @endif
        @if(Session::has('pesangallerydelete'))
            <div class="alert alert-success">
                {{ Session::get('pesangallerydelete') }}
            </div>
        @endif
        @if (Session::has('pesansuccess'))
            <div class="alert alert-success">
                {{ session::get('pesansuccess') }}
            </div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <h1>Daftar Buku</h1>
            @if (Auth::User()->level == 'admin')
            <a href="{{ route('create')}}" class="btn btn-primary float-end" style=" display:inline; margin-top: 10px; margin-bottom:10px ; float: right;margin-right:10px;">Tambah Buku</a>
            @endif
        </div>

    <form action="{{ route('search') }}" method="GET">@csrf
        <input type="text" name="kata" class="form-control" placeholder="Search..." style="width: 30%; display: inline;
        margin-top: 10px; margin-bottom: 10px; float: right;">
    </form>
    <table class="table table-stripped">
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
                    <td>{{ "Rp. ".number_format($buku->harga, 0, ',','.') }}</td>
                    @if (Auth::User()->level == 'admin')
                    <td>
                        <a href="{{ route('detail', $buku->id) }}" class="btn btn-primary">Detail</a>
                        <form method="get" action="{{ route('edit', $buku->id) }}" style="display:inline;">
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
        <tr>
            <td colspan="6">
                <b>Total Harga:</b>
            </td>
            <td colspan="4">
                Rp. {{ number_format($total_harga, 2, ',', '.') }}
            </td>
        </tr>
    </table>
    <div>{{ $data_buku->links('pagination::bootstrap-5') }}</div>
    <div><strong>Jumlah Buku: {{ $jumlah_buku }}</strong></div>
    @endsection