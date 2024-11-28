@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Buat Review Buku</h1>
        @if (count($errors) > 0)
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    <form action="{{ route('review.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="buku_id" class="form-label">Judul Buku</label>
            <select name="buku_id" id="buku_id" class="form-control">
                <option value="" disabled selected>Pilih Buku...</option>
                @foreach ($books as $book)
                    <option value="{{ $book->id }}">{{ $book->judul }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="review_text" class="form-label">Review</label>
            <textarea name="review_text" id="review_text" rows="5" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="tags" class="form-label">Tags</label>
            <input type="text" name="tags" id="tags" class="form-control" placeholder="Tag1, Tag2, ...">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Review</button>
    </form>
</div>
@endsection
