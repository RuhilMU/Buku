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
                        <p class="fs-5"><strong>Harga:</strong> 
                        @if($buku->discount)
                        <p class="fs-5">
                            <span style="color: red; text-decoration: line-through;">
                                Rp. {{ number_format($buku->harga, 0, ',', '.') }}
                            </span> |
                            <span class="badge bg-success pt-2 pb-2" >{{ $buku->discount_percentage }}% off</span><br>
                            <span style="color: green">Rp. {{ number_format($buku->discounted_price, 0, ',', '.') }}</span>
                        </p>
                        @else
                            <p class="fs-5">{{ "Rp. ".number_format($buku->harga, 0, ',','.') }}</p>
                        @endif
                        <p class="fs-5"><strong>Tanggal Terbit:</strong> {{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('d-m-Y') }}</p>
                    </div>
                </div>

                <hr>

                <h5>Galeri</h5>
                <div class="row">
                    @foreach($buku->galleries as $gallery)
                    <div class="col-md-3 mb-3">
                        <img src="{{ asset('storage/galleries/'.$gallery->image) }}" class="img-fluid rounded" alt="Gallery Image">
                        <p> {{ $gallery->keterangan }}</p>
                    </div>
                    @endforeach
                </div>

                <a href="{{ url('/buku') }}" class="btn btn-secondary">Kembali</a>

            </div>
        </div>
    </div>
    @endsection
