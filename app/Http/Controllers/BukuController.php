<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Pagination\Paginator;

class BukuController extends Controller
{
    // public function index()
    // {
    //     $data_buku = Buku::all();
    //     $jumlah_buku = $data_buku->count();
    //     $total_harga = $data_buku->sum('harga');
        
    //     return view('index', compact('data_buku', 'jumlah_buku', 'total_harga'));
    // }
    public function index(){
        $batas = 10;
        $jumlah_buku = Buku::count();
        $data_buku = Buku::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($data_buku->currentPage()-1);
        $total_harga = $data_buku->sum('harga');

        return view('index', compact('data_buku','total_harga', 'no','jumlah_buku'));
    }
    
    public function create()
    {
        return view('create');
    }

    // public function store(Request $request)
    // {
    //     $buku = new Buku();
    //     $buku->judul = $request->judul;
    //     $buku->penulis = $request->penulis;
    //     $buku->harga = $request->harga;
    //     $buku->tgl_terbit = $request->tgl_terbit;
    //     $buku->save();

    //     return redirect('/buku')->with('pesan', 'Data Buku Berhasil di Simpan');
    // }
        public function store(Request $request)
        {
            $this->validate($request,[
                'judul' => 'required|string',
                'penulis' => 'required|string|max:30',
                'harga' => 'required|numeric',
                'tgl_terbit' => 'required|date'
            ]);
            
            $buku = new Buku();
            $buku->judul = $request->judul;
            $buku->penulis = $request->penulis;
            $buku->harga = $request->harga;
            $buku->tgl_terbit = $request->tgl_terbit;
            $buku->save();

            return redirect('/buku')->with('pesansuccess', 'Data Buku Berhasil di Simpan');
        }

    public function destroy($id)
    {
        $buku = Buku::find($id);
        $buku->delete();

        return redirect('/buku')->with('pesandelete', 'Data Buku Berhasil di Hapus');
    }

    public function edit($id)
    {
        $buku = Buku::find($id);
        return view('update', compact('buku'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
        ]);

        $buku = Buku::find($id);
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->save();

        return redirect('/buku')->with('pesanupdate', 'Data Buku Berhasil di Update');
    }

    public function search(Request $request)
    {
        Paginator::useBootstrapFive();
        $batas = 5;
        $cari = $request->kata;
        $data_buku = Buku::where('judul', 'like', "%" . $cari . "%")->orwhere('penulis', 'like', "%" . $cari . "%")->paginate($batas);
        $jumlah_buku = Buku::count();
        $no = $batas * ($data_buku->currentPage() - 1);
        $total_harga = $data_buku->sum('harga');
        return view('search', compact('jumlah_buku', 'data_buku', 'no', 'cari', 'total_harga'));
    }
}