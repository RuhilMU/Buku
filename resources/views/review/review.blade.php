@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Review oleh {{ $reviewer->name }}</h2>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Buku</th>
                <th>Review</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reviews as $no => $review)
            <tr>
                <td>{{ $no + 1 }}</td>
                <td>{{ $review->buku->judul }}</td>
                <td>{{ $review->review_text }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3">{{ $reviewer->name }} belum melakukan review buku apapun</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
