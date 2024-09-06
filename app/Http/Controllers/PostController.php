<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Method untuk menampilkan halaman utama
     */
    public function index()
    {
        return view('posts');
    }

    /**
     * Method untuk menampilkan form create post
     */
    public function create()
    {
        //
    }

    /**
     * Method untuk melakukan insert data ke dalam database
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Method untuk menampilkan detail post
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Method untuk menampilkan halaman edit post
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Method untuk melakukan update data ke dalam database
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Method untuk menghapus data dari database
     */
    public function destroy(string $id)
    {
        //
    }
}