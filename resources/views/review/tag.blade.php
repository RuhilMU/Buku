@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Buku dengan tag "{{ ucfirst($tag) }}"</h4>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Buku</th>
                <th>Tag</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviews as $no => $review)
            <tr>
                <td>{{ $no + 1 }}</td>
                <td>{{ $review->buku->judul }}</td>
                <td>{{ implode(', ', $review->tags) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
