<?php

namespace App\Http\Controllers\Api;

use App\Models\Buku;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Validator;

class BookApiController extends Controller
{
    public function index(){
        try{
            $books = Buku::all();
            return response()->json([
                'message' => 'Success',
                'data' => $books
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function store(Request $request) {
        try {
            $validate = $request->validate([
                'judul' => 'required|string',
                'penulis' => 'required|string',
                'harga' => 'required|numeric',
                'tgl_terbit' => 'required|date',
                'image' => 'nullable|url',
            ]);
            $book = Buku::create($validate);
            return response()->json([
                'message' => 'Book created successfully',
                'data' => $book,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Server error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function update(Request $request,$id){
        try{
            $validate = $request->validate([
                'judul' => 'sometimes|required|string',
                'penulis' => 'sometimes|required|string',
                'harga' => 'sometimes|required|numeric',
                'tgl_terbit' => 'sometimes|required|date',
                'image' => 'sometimes|nullable|url',
            ]);
            $books = Buku::find($id);
            $books->update($validate);
            return response()->json([
                'message' => 'Book updated successfully', 
                'data' => $books
            ],200);
        }catch(Exception $e){
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function destroy($id){
        try{
            $Books = Buku::find($id);
            $Books->delete();
            if ($Books) {
                return response()->json([
                    'message' => 'Book deleted successfully',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Books not found'
                ], 404);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function show ($id){
        try{

            $books = Buku::find($id);
            if ($books) {
                return response()->json([
                    'message' => 'Books found',
                    'data' => $books
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Books not found'
                ], 404);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
