<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Gallery;
use App\Models\Review;
use App\Models\User;
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
        $reviewers = User::where('level', 'internal_reviewer')->get();
        $tags = Review::select('tags')->distinct()->pluck('tags')->flatten()->unique();
        $editorial_picks = Buku::where('editorial_pick',true)->limit(5)->get();
        return view('index', compact('data_buku', 'jumlah_buku', 'no', 'total_harga', 'reviewers', 'tags', 'editorial_picks'));
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
                'editorial_pick' => 'boolean',
                'discount' => 'boolean',
                'discount_percentage' => 'nullable|integer|min:0|max:100',
            ]);

            $imagePath = $request->file('image')->store('public/img');
            $imageName = basename($imagePath);
            
            $buku = new Buku();
            $buku->judul = $request->judul;
            $buku->penulis = $request->penulis;
            $buku->harga = $request->harga;
            $buku->tgl_terbit = $request->tgl_terbit;
            $buku->image = $imageName;
            $buku->editorial_pick = $request->editorial_pick;
            $buku->discount = $request->discount;
            $buku->discount_percentage = $request->discount ? $request->discount_percentage : null;
            $buku->save();

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $index => $image) {
                    $galleryPath = $image->store('public/galleries');
                    $keterangan = $request->gallery_keterangan[$index] ?? null;
            
                    $buku->galleries()->create([
                        'image' => basename($galleryPath),
                        'keterangan' => $keterangan,
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
            'gallery_keterangan_existing.*' => 'nullable|string',
            'gallery_keterangan.*' => 'nullable|string',
            'editorial_pick' => 'boolean',
            'discount' => 'boolean',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
        ]);
    
        $buku = Buku::find($id);
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
    
        if ($request->hasFile('image')) {
            if ($buku->image) {
                Storage::delete('public/img/' . $buku->image);
            }
    
            $imagePath = $request->file('image')->store('public/img');
            $imageName = basename($imagePath);
            $buku->image = $imageName;
        }
    
        if ($request->filled('gallery_keterangan_existing')) {
            foreach ($request->gallery_keterangan_existing as $galleryId => $keterangan) {
                $gallery = $buku->galleries()->find($galleryId);
                if ($gallery) {
                    $gallery->keterangan = $keterangan;
                    $gallery->save();
                }
            }
        }
    
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $image) {
                $galleryPath = $image->store('public/galleries');
                $keterangan = $request->gallery_keterangan[$index] ?? null;
    
                $buku->galleries()->create([
                    'image' => basename($galleryPath),
                    'keterangan' => $keterangan,
                ]);
            }
        }
    
        $buku->editorial_pick = $request->editorial_pick;
        $buku->discount = $request->discount;
        $buku->discount_percentage = $request->discount ? $request->discount_percentage : null;

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