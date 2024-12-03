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
                <label for="editorial_pick" class="form-label">Editorial Pick</label>
                <select class="form-control" id="editorial_pick" name="editorial_pick">
                    <option value="" disabled selected>Pilih Status...</option>
                    <option value="1">True</option>
                    <option value="0">False</option>
                </select>
            </div>
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
                <label for="discount" class="form-label">Diskon</label>
                <select class="form-control" id="discount" name="discount">
                    <option value="0">Tidak</option>
                    <option value="1">Ya</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="discount_percentage" class="form-label">Persentase Diskon</label>
                <input type="number" class="form-control" id="discount_percentage" name="discount_percentage">
            </div>

            <div class="mb-3">
                <label for="tgl_terbit">Tanggal Terbit</label>
                <input type="date" class="form-control" id="tgl_terbit" name="tgl_terbit">
            </div>
        
            <div class="mb-3">
            <label for="image" class="form-label">Thumbnail</label>
            <input type="file" name="image" id="image" class="form-control">
            </div>

            <div id="gallery-wrapper" class="mb-3">
                <div class="gallery-item">
                    <label for="gallery_images[]">Gambar Galeri</label>
                    <input type="file" name="gallery_images[]" class="form-control mb-2">
                    <label for="gallery_keterangan[]">Keterangan</label>
                    <input type="text" name="gallery_keterangan[]" class="form-control mb-2">
                </div>
            </div>

            <button type="button" id="add-gallery" class="btn btn-secondary">Tambah Gambar Galeri</button>

            <div class="mt-2 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url('/buku') }}" class="btn btn-secondary">Kembali</a>
            </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addGalleryButton = document.getElementById('add-gallery');
        const galleryWrapper = document.getElementById('gallery-wrapper');

        addGalleryButton.addEventListener('click', function () {
            const newGalleryItem = document.createElement('div');
            newGalleryItem.classList.add('gallery-item', 'mb-3');

            const newInputGallery = document.createElement('input');
            newInputGallery.type = 'file';
            newInputGallery.name = 'gallery_images[]';
            newInputGallery.classList.add('form-control', 'mb-2');

            const newLabelGallery = document.createElement('label');
            newLabelGallery.innerText = 'Gambar Galeri';
            newLabelGallery.setAttribute('for', 'gallery_images[]');

            const newInputKet = document.createElement('input');
            newInputKet.type = 'text';
            newInputKet.name = 'gallery_keterangan[]';
            newInputKet.classList.add('form-control', 'mb-2');

            const newLabelKet = document.createElement('label');
            newLabelKet.innerText = 'Keterangan';
            newLabelKet.setAttribute('for', 'gallery_keterangan[]');

            newGalleryItem.appendChild(newLabelGallery);
            newGalleryItem.appendChild(newInputGallery);
            newGalleryItem.appendChild(newLabelKet);
            newGalleryItem.appendChild(newInputKet);

            galleryWrapper.appendChild(newGalleryItem);
        });
    });
</script>


@endsection
