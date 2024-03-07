@extends('layouts.template')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="h3 text-2xl font-semibold mb-4">Formulir Edit Buku</h1>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <p class="text-success">{{ session('success') }}</p>
                        @endif

                        <form action="{{ route('buku.update', $buku->id) }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('patch')
                                            <div class="mb-4">
                                                <label for="judul"
                                                    class="block text-sm font-semibold mb-2">Judul:</label>
                                                <input type="text" name="judul" value="{{$buku->judul}}" class="w-full border p-2" required>
                                            </div>

                                            <div class="mb-4">
                                                <label for="penulis"
                                                    class="block text-sm font-semibold mb-2">Penulis:</label>
                                                <input type="text" name="penulis" value="{{$buku->penulis}}"class="w-full border p-2" required>
                                            </div>

                                            <div class="mb-4">
                                                <label for="penerbit"
                                                    class="block text-sm font-semibold mb-2">Penerbit:</label>
                                                <input type="text" name="penerbit" value="{{$buku->penerbit}}" class="w-full border p-2" required>
                                            </div>

                                            <div class="mb-4">
                                                <label for="tahun_terbit" class="block text-sm font-semibold mb-2">Tahun
                                                    Terbit:</label>
                                                <input type="number" name="tahun_terbit" value="{{$buku->tahun_terbit}}"class="w-full border p-2"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="foto" class="form-label">Foto Buku:</label>
                                                <input type="file" name="foto" accept="image/*" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection