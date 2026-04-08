@extends('layouts.admin.app')

@section('content')

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-book-open-page-variant"></i>
        </span> Data Buku
    </h3>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Daftar Buku</h4>

                    <a href="{{ route('buku.create') }}" class="btn btn-gradient-primary btn-fw">
                        <i class="mdi mdi-plus"></i> Tambah Buku
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($buku as $b)
                            <tr>
                                <td>{{ $b->idbuku }}</td>

                                <td>
                                    <span class="badge badge-gradient-info">
                                        {{ $b->kode }}
                                    </span>
                                </td>

                                <td>{{ $b->judul }}</td>

                                <td>{{ $b->pengarang }}</td>

                                <td>
                                    <span class="badge badge-gradient-success">
                                        {{ $b->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('buku.edit',$b->idbuku) }}"
                                       class="btn btn-gradient-warning btn-sm btn-icon-text">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </a>

                                    <a href="{{ route('buku.delete',$b->idbuku) }}"
                                       class="btn btn-gradient-danger btn-sm btn-icon-text"
                                       onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                       <i class="mdi mdi-delete"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    <i class="mdi mdi-information-outline"></i>
                                    Belum ada data buku
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                {{-- Pagination --}}
                @if(method_exists($buku, 'links'))
                <div class="mt-3">
                    {{ $buku->links() }}
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection
