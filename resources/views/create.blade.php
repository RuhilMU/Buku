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

        <h2>Tambah Buku</h2>
        <form method="post" action="{{ route('store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul">
            </div>

            <div class="mb-3">
                <label for="penulis">Penulis</label>
                <input type="text" class="form-control" id="penulis" name="penulis">
            </div>

            <div class="mb-3">
                <label for="harga">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga">
            </div>

            <div class="mb-3">
                <label for="tgl_terbit">Tanggal Terbit</label>
                <input type="date" class="form-control" id="tgl_terbit" name="tgl_terbit">
            </div>
            <!---->
            <div class="mb-3">
            <label for="image" class="form-label">Thumbnail</label>
            <input type="file" name="image" id="image" class="form-control">
            </div>

            <div id="gallery-images" class="form-group">
                <label for="gallery_images">Tambah Gambar Galeri:</label>
                <input type="file" name="gallery_images[]" class="form-control mb-2">
            </div>

            <button type="button" id="add-gallery" class="btn btn-secondary">Tambah Gambar Galeri</button>
            
            <div class="mt-2 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url('/buku') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const addGalleryButton = document.getElementById('add-gallery');
                const galleryImagesDiv = document.getElementById('gallery-images');

                addGalleryButton?.addEventListener('click', function() {
                    const newInput = document.createElement('input');
                    newInput.type = 'file';
                    newInput.name = 'gallery_images[]';
                    newInput.classList.add('form-control', 'mb-2');
                    galleryImagesDiv.appendChild(newInput);
                });
            });
        </script>

@endsection
