<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create()
    {
        $books = Buku::all();
        return view('review.create', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:books,id',
            'review_text' => 'required|string',
            'tags' => 'required|string',
        ]);

        $tagsArray = array_map('trim', explode(',', $request->tags));

        Review::create([
            'buku_id' => $request->buku_id,
            'user_id' => auth()->id(),
            'review_text' => $request->review_text,
            'tags' => $tagsArray,
        ]);
    
        return redirect()->route('home.buku');
    }

    public function byReviewer($reviewer)
    {
        $reviewer = User::where('name', $reviewer)
                        ->where('level', 'internal_reviewer')
                        ->firstOrFail();
    
        $reviews = Review::with('buku')
                         ->where('user_id', $reviewer->id)
                         ->get();
    
        return view('review.review', compact('reviewer', 'reviews'));
    }
    

    public function byTag($tag)
    {
        $reviews = Review::with('buku', 'reviewer')
                         ->whereJsonContains('tags', $tag)
                         ->get();
    
        return view('review.tag', compact('tag', 'reviews'));
    }
    


}
