<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\kategoribukurelasi;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        $kategori = kategoribukurelasi::all();
        return view('buku.buku', compact('buku', 'kategori'));
    }

    public function create()
    {
        $kategori = kategori::distinct()->get();
        return view('buku.buku_create', compact('kategori'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'kategori_id' => 'required',
        ]);

        $kategori = Kategori::find($request->kategori_id);

        $buku = Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
        ]);

        $buku->kategori()->attach($kategori);

        return redirect('/buku')->with('success', 'Buku berhasil ditambahkan!');
    }
}
