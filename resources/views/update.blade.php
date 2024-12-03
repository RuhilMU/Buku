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
            <label for="editorial_pick" class="form-label">Editorial Pick</label>
            <select class="form-control" id="editorial_pick" name="editorial_pick">
                <option value="" disabled selected>Pilih Status...</option>
                <option value="1" {{ old('editorial_pick', $buku->editorial_pick) == 1 ? 'selected' : '' }}>True</option>
                <option value="0" {{ old('editorial_pick', $buku->editorial_pick) == 0 ? 'selected' : '' }}>False</option>
            </select>
        </div>

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
            <label for="discount" class="form-label">Diskon</label>
            <select class="form-control" id="discount" name="discount">
                <option value="0" {{ old('discount', $buku->discount) == 0 ? 'selected' : '' }}>Tidak</option>
                <option value="1" {{ old('discount', $buku->discount) == 1 ? 'selected' : '' }}>Ya</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="discount_percentage" class="form-label">Persentase Diskon</label>
            <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" value="{{ old('discount_percentage', $buku->discount_percentage) }}">
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
                    <div class="mb-3">
                        <img src="{{ asset('storage/galleries/' . $gallery->image) }}" class="w-25" alt="Gallery Image">
                        <br>
                        <input type="text" name="gallery_keterangan_existing[{{ $gallery->id }}]" 
                            id="gallery_keterangan_{{ $gallery->id }}" 
                            class="form-control mb-2"
                            value="{{ old('gallery_keterangan_existing.' . $gallery->id, $gallery->keterangan) }}"
                            placeholder="Keterangan untuk gambar ini">
                    </div>
                @endforeach
            </div>

        <div id="gallery-wrapper" class="mb-3">
            <div class="gallery-item">
                <label for="gallery_images[]">Tambah Gambar Galeri</label>
                <input type="file" name="gallery_images[]" class="form-control mb-2">
                <label for="gallery_keterangan[]">Keterangan</label>
                <input type="text" name="gallery_keterangan[]" class="form-control mb-2">
            </div>
        </div>


        <div class="mt-3 d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Update Buku</button>
            <a href="{{ url('/buku') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
