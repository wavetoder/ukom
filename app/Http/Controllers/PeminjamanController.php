<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('user', 'buku')->get();
        return view('peminjaman.peminjaman', compact('peminjaman'));
    }

    public function tambahPeminjaman(){
        $users = user::all();
        $buku = buku::all();
        
        return view('peminjaman.create_peminjaman', compact('users', 'buku'));
    }
    public function storePeminjaman(Request $request){
        $request->validate([
            'user_id'=> 'required|exists:users,id',
            'buku_id'=> 'required|exists:buku,id',
            'tanggal_peminjaman'=> 'required|date',
            'tanggal_pengembalian' => 'required|date',

        ]);
        Peminjaman::create([
            'user_id'=>$request->user_id,
            'buku_id'=>$request->buku_id,
            'tanggal_peminjaman'=>$request->tanggal_peminjaman,
            'tanggal_pengembalian'=>$request->tanggal_pengembalian,
            'status' => 'Dipinjam'
        ]);
        return redirect ('/peminjaman');
    }
    public function kembalikanBuku($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->tanggal_pengembalian = now();
        $peminjaman->status = 'Dikembalikan';
        $peminjaman->save();

        return redirect()->route('peminjaman.index')->with('success', 'Buku berhasil dikembalikan');
    }
    public function print(){
        $user = User::all();
        $buku = Buku::all();
        $peminjaman = Peminjaman::all();
        $data = [
            'user' => $user,
            'buku' => $buku,
            'peminjaman' => $peminjaman,
        ];
        $pdf = PDF::loadView('peminjaman.format', $data)
        ->setPaper('a4');
        return $pdf->download('laporan.pdf');
    }

}