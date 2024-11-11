    @extends('layouts.app')

    @section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h3 class="mt-2">Detail Buku</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{ asset('storage/img/'.$buku->image) }}" class="img-fluid rounded" alt="Book Image">
                    </div>
                    <div class="col-md-8">
                        <h2 class="fs-1">{{ $buku->judul }}</h2>
                        <p class="fs-5"><strong>Penulis:</strong> {{ $buku->penulis }}</p>
                        <p class="fs-5"><strong>Harga:</strong> Rp{{ number_format($buku->harga, 2, ',', '.') }}</p>
                        <p class="fs-5"><strong>Tanggal Terbit:</strong> {{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('Y-m-d') }}</p>
                    </div>
                </div>

                <hr>

                <h5>Galeri</h5>
                <div class="row">
                    @foreach($buku->galleries as $gallery)
                    <div class="col-md-3 mb-3">
                        <img src="{{ asset('storage/galleries/'.$gallery->image) }}" class="img-fluid rounded" alt="Gallery Image">
                    </div>
                    @endforeach
                </div>

                <a href="{{ url('/buku') }}" class="btn btn-secondary">Kembali</a>

            </div>
        </div>
    </div>
    @endsection
