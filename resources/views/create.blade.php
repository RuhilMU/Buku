@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @if (count($errors) > 0)
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <h4>Tambah Buku</h4>
        <form method="post" action="{{ route('store') }}">
            @csrf
            <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul">
            </div>
            <div class="form-group">
                <label for="penulis">Penulis</label>
                <input type="text" class="form-control" id="penulis" name="penulis">
            </div>
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga">
            </div>
            <div class="form-group">
                <label for="tgl_terbit">Tanggal Terbit</label>
                <input type="date" class="form-control" id="tgl_terbit" name="tgl_terbit">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ url('/buku') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
