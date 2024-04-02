@extends('layouts.template')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Daftar User</div>

                    <div class="card-body">
                        <div class="mb-4">
                            <a href="{{ Route('users.create') }}" class="btn btn-primary">
                                + Tambah Data Pengguna
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="bg-light text-white">
                                    <tr>

                                        <th scope="col">Id</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>                        
                            <tbody>
                                @forelse ($users as $u)
                                    <tr>
                                        <td>{{ $u->id }}</td>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>
                                            @foreach ($u ->roles as $role )
                                                {{ $role->name }}
                                            @endforeach
                                        </td>
                                        <td>
                                            <form action="{{ route('users.hapus', $u->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus<i class="fa-solid fa-trash"></i>                                              
                                                </button>

                                                <a class="btn btn-primary" href="{{ route('users.edit', $u->id) }}">Edit
                                                    <i class="fa fa-file-pen"></i></a>
                                                </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data user.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection