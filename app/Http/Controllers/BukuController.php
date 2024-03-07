<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\kategoribukurelasi;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        $kategori = kategoribukurelasi::all();
        return view('buku.buku', compact('buku', 'kategori'));
    }
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.buku_edit', ['buku' => $buku]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',

        ]);
        Buku::find($id)->update([
            
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
        ]);

        $buku = Buku::findOrFail($id);

        if ($request->hasFile('foto')) {
            $request->validate([
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Hapus foto lama
            Storage::disk('public')->delete($buku->foto);

            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('buku_images', 'public');
            $buku->foto = $fotoPath;
        }

        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->penerbit = $request->penerbit;
        $buku->tahun_terbit = $request->tahun_terbit;
        $buku->save();
        
        return redirect('/buku');
    }
    public function create()
    {
        $kategori = kategori::distinct()->get();
        return view('buku.buku_create', compact('kategori'));
    }
    public function hapus($id)
    {
        Buku::find($id)->delete();
        return redirect('/buku');
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'kategori_id' => 'required',
        ]);
        $fotoPath = $request->file('foto')->store('buku_images','public');

        $kategori = Kategori::find($request->kategori_id);

        $buku = Buku::create([
            'foto' => $fotoPath,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
        ]);

        $buku->kategori()->attach($kategori);

        return redirect('/buku')->with('success', 'Buku berhasil ditambahkan!');
    }

}
