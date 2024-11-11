<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Gallery;
use Intervention\Image\Facades\Image;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

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
        $data_buku = Buku::paginate($batas);
        $no = $batas * ($data_buku->currentPage()-1);
        $total_harga = Buku::sum('harga');

        return view('index', compact('data_buku','total_harga', 'no','jumlah_buku'));
    }
    
    public function create()
    {
        return view('create');
    }
    
    public function show($id)
    {
        // Ambil buku berdasarkan id
        $buku = Buku::with('galleries')->findOrFail($id);
    
        return view('detail', compact('buku'));
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
                'tgl_terbit' => 'required|date',
                'image' => 'required|file|mimes:jpeg,jpg,png,gif',
                'gallery_images.*' => 'file|mimes:jpeg,jpg,png,gif',
            ]);

            $imagePath = $request->file('image')->store('public/img');
            $imageName = basename($imagePath);
            
            $buku = new Buku();
            $buku->judul = $request->judul;
            $buku->penulis = $request->penulis;
            $buku->harga = $request->harga;
            $buku->tgl_terbit = $request->tgl_terbit;
            $buku->image = $imageName;
            $buku->save();

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $galleryPath = $image->store('public/galleries');
                    $buku->galleries()->create([
                        'image' => basename($galleryPath),
                    ]);
                }
            }
            return redirect('/buku')->with('pesansuccess', 'Data Buku Berhasil di Simpan');
        }

    public function destroy($id)
    {
        $buku = Buku::find($id);
        if (!$buku) {
            return redirect('/buku')->with('error', 'Buku tidak ditemukan');
        }
        foreach ($buku->galleries as $gallery) {
            if ($gallery->image) {
                Storage::delete('public/galleries/' . $gallery->image);
            }
            $gallery->delete();
        }
        if ($buku->image) {
            Storage::delete('public/img/' . $buku->image);
        }
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
                'image' => 'mimes:jpeg,jpg,png,gif|nullable',
                'gallery_images.*' => 'file|mimes:jpeg,jpg,png,gif|nullable',
            ]);
        
            $buku = Buku::find($id);
            $buku->judul = $request->judul;
            $buku->penulis = $request->penulis;
            $buku->harga = $request->harga;
            $buku->tgl_terbit = $request->tgl_terbit;
        
            // Handle the main image (thumbnail)
            if ($request->hasFile('image')) {
                if ($buku->image) {
                    Storage::delete('public/img/' . $buku->image);
                }
        
                $imagePath = $request->file('image')->store('public/img');
                $imageName = basename($imagePath);
                $buku->image = $imageName;
            }
        
            // Handle gallery images
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $galleryPath = $image->store('public/galleries');
                    $buku->galleries()->create([
                        'image' => basename($galleryPath),
                    ]);
                }
            }
        
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

    public function destroyGallery($bukuId, $galleryId)
    {
        $buku = Buku::findOrFail($bukuId);
        $gallery = $buku->galleries()->findOrFail($galleryId);

    
        if ($gallery->image) {
            Storage::delete('public/galleries/' . $gallery->image);
        }
    
        $gallery->delete();
        
        return redirect()->route('edit', $bukuId)->with('pesangallerydelete', 'Gambar galeri berhasil dihapus');
    }
}