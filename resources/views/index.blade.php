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

    <div class="mb-3">
        <h1>Daftar Buku</h1>
        @if (Auth::User()->level == 'admin')
            <a href="{{ route('buku.create')}}" class="btn btn-primary">Tambah Buku</a>
        @endif
    </div>

    <form action="{{ route('search') }}" method="GET" class="mb-4">
        @csrf
        <div class="input-group">
            <input type="text" name="kata" class="form-control" placeholder="Search..." style="width: 30%;">
        </div>
    </form>

    @if($editorial_picks->isNotEmpty())
        <h2>✰ Editorial Picks ✰</h2>
        <div class="row">
            @foreach($editorial_picks as $book)
                <div class="col-md-3">
                    <div class="card">
                        <img src="{{ asset('storage/img/'.$book->image) }}" class="card-img-top" alt="{{ $book->judul }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->judul }}</h5>
                            <p class="card-text">{{ $book->penulis }}</p>
                            <a href="{{ route('detail', $book->id) }}" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="table-responsive mt-4">
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
                    @else
                        <th>Info</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($data_buku as $index => $buku)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $buku->id }}</td>
                        <td>
                            <img src="{{ asset('storage/img/'.$buku->image) }}" class="rounded" style="width: 150px;">
                        </td>
                        <td>{{ $buku->judul }}</td>
                        <td>{{ $buku->penulis }}</td>
                        <td>{{ $buku->tgl_terbit->format('d F Y') }}</td>
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
                                <a href="{{ route('detail', $buku->id) }}" class="btn btn-primary btn-sm">Detail</a>
                                <form method="get" action="{{ route('edit', $buku->id) }}" style="display:inline;">
                                    @csrf
                                    <button onclick="return confirm('Edit nih?')" type="submit" class="btn btn-warning btn-sm">Update</button>
                                </form>
                                <form action="{{ route('destroy', $buku->id) }}" method="post" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin di Hapus boi?')" type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        @else
                            <td><a href="{{ route('detail', $buku->id) }}" class="btn btn-primary btn-sm">Detail</a></td>
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
    </div>

    <div>{{ $data_buku->links('pagination::bootstrap-5') }}</div>
    <div><strong>Jumlah Buku: {{ $jumlah_buku }}</strong></div>

    @if (Auth::user()->level == 'admin' || Auth::user()->level == 'internal_reviewer')
        <div class="d-flex justify-content-start mt-3">
            <a href="{{ route('review.create') }}" class="btn btn-success">Tambah Review</a>
        </div>
    @endif

    <div class="mt-3">
        <h3>Review Buku</h3>
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Reviewer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviewers as $no => $reviewer)
                    <tr>
                        <td>{{ $no+1 }}</td>
                        <td><a href="{{ route('review.byReviewer', $reviewer->name) }}">
                            {{ $reviewer->name }}
                        </a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4>Tags:</h4>
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tag</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tags as $nu => $tag)
                    <tr>
                        <td>{{ $nu+1 }}</td>
                        <td><a href="{{ route('review.byTag', $tag) }}">
                            {{ ucfirst($tag) }}
                        </a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
