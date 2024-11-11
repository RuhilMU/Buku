@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <h2>Edit Buku</h2>
    <form method="post" action="{{ route('update', $buku->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="judul">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $buku->judul) }}">
        </div>

        <div class="mb-3">
            <label for="penulis">Penulis</label>
            <input type="text" class="form-control" id="penulis" name="penulis" value="{{ old('penulis', $buku->penulis) }}">
        </div>

        <div class="mb-3">
            <label for="harga">Harga</label>
            <input type="text" class="form-control" id="harga" name="harga" value="{{ old('harga', $buku->harga) }}">
        </div>

        <div class="mb-3">
            <label for="tgl_terbit">Tanggal Terbit</label>
            <input type="date" class="form-control" id="tgl_terbit" name="tgl_terbit" value="{{ old('tgl_terbit', $buku->tgl_terbit) }}">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Ubah Thumbnail</label>
            <input type="file" name="image" id="image" class="form-control">
            @if ($buku->image)
                <h4 class="mt-3">Thumbnail saat ini:</h4> 
                    <img src="{{ asset('storage/img/' . $buku->image) }}" class="img-thumbnail w-25 mt-2" alt="Current Book Image">
            @endif
        </div>

        <h4>Galeri:</h4>
        <div class="gallery mb-3">
            @foreach($buku->galleries as $gallery)
                <div>
                    <img src="{{ asset('storage/galleries/' . $gallery->image) }}" class="w-25" alt="Gallery Image">
                    <form action="{{ route('destroyGallery', [$buku->id, $gallery->id]) }}" method="POST" class="delete-gallery-form d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" >&times;</button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <label for="gallery_images">Tambah Gambar Galeri:</label>
            <input type="file" name="gallery_images[]" class="form-control mb-2" multiple>
        </div>

        <div class="mt-3 d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Update Buku</button>
            <a href="{{ url('/buku') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
