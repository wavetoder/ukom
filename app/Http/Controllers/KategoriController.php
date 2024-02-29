<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\kategoribukurelasi;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view ('buku.kategori',['kategori'=>$kategori]);
    }
    public function create(){
        return view ('buku.create_kategori');
    }

    public function edit($id){
        $kategori = Kategori::findOrFail($id);
        return view ('buku.kategori_edit', ['kategori'=>$kategori]);
    }
    public function hapus($id)
    {
        Kategori::find($id)->delete();
        return redirect('/kategori');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori'=>'required',

        ]);
        Kategori::find($id)->update([
            'nama_kategori'=>$request->nama_kategori,
            
        ]);
        return redirect('/buku');
    }

    public function store(Request $request){
        $request->validate([
            'nama_kategori'=>'required'
        ]);
        Kategori::create([
            'nama_kategori'=>$request->nama_kategori
        ]);
        return redirect ('/kategori')->with('success', 'kategori berhsil ditambahkan');
    }
}
