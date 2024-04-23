@extends('layouts.template')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 d-flex justify-content-between">
                        <a href="{{ route('peminjaman.tambah') }}" class="bg-blue-500 hover:bg-blue-700 text-white border font-bold py-2 px-4 rounded btn btn-primary  ">
                            + Tambah Data Peminjaman 
                        </a>
                            <a href="{{ route('print') }}" class="btn btn-primary">
                                <i class="fa fa-download">Ekspor PDF
                                </i>
                            </a>
                    </div>
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Nama Peminjam</th>
                                <th class="px-4 py-2">Buku yang Dipinjam</th>
                                <th class="px-4 py-2">Tanggal Peminjaman</th>
                                <th class="px-4 py-2">Tanggal Seharusnya Kembali</th>
                                <th class="px-4 py-2">Tanggal Pengembalian</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjaman as $p)
                                <tr>
                                    <td class="px-4 py-2">{{ $p->user->name }}</td>
                                    <td class="px-4 py-2">{{ $p->buku->judul }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($p->tanggal_peminjaman)->format('d-M-Y') }}</td>
                                    <td class="px-4 py-2">{{ $p->tanggal_pengembalian ? \Carbon\Carbon::parse($p->tanggal_pengembalian)->format('d-M-Y') : 'Belum Dikembalikan' }}</td>
                                    <td class="px-4 py-2">{{ $p->sekarang ? \Carbon\Carbon::parse($p->sekarang)->format('d-M-Y') : '' }}</td>

                                    
                                    <td class="px-4 py-2">
                                        @if($p->status === 'Dipinjam')
                                            <span class="badge bg-warning">{{ $p->status }}</span>
                                        @elseif($p->status === 'Dikembalikan')
                                            <span class="badge bg-primary">{{ $p->status }}</span>
                                        @elseif($p->status === 'Denda')
                                            <span class="badge bg-danger">Terlambat</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if($p->status === 'Dipinjam')
                                            <form id="form_{{ $p->id }}" action="{{ route('peminjaman.kembalikan', $p->id) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">
                                                    Kembalikan
                                                </button>
                                        @elseif ($p->status === 'Denda')
                                            <a href="{{route('peminjaman.denda', $p->id)}}" class="btn btn-danger">
                                                Bayar Denda
                                            </a>
                                        @else ($p->status === 'Dikembalikan')
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-2 text-center">Tidak ada data buku.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection