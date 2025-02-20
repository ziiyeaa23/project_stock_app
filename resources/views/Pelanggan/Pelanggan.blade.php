@extends('main')

@section('title')
    Data Pelanggan
@endsection

@section('content')
    <div class="container-fluid">    
        <h3 class="mt-2 mb-3">Data Pelanggan</h3>
        <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Data Pelanggan</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col">
                <div class="mt-3 card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="pt-1 w-100">
                                <strong>Data Pelanggan</strong>
                            </div>
                            <div class="w-100 text-end">
                                <a href="{{url('/pelanggan')}}" class="btn btn-outline-primary btn-sm">
                                    Refresh Data <i class="bi bi-arrow-clockwise"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (Session::has('message'))
                            <div class="alert alert-success" id="flash-message">
                                {{Session::get('message')}}
                            </div>
                            <script>
                                setTimeout(function (){
                                    document.getElementById('flash-message').style.display='none';
                                }, {{ session('timeout', 5000) }});
                            </script>
                        @endif

                        <div class="mx-3 my-4 row">
                            <div class="col-6 bg-">
                                <a href="{{ url('/pelanggan/add') }}" class="btn btn-primary btn-sm">
                                    Pelanggan Baru <i class="fa-solid fa-plus"></i>
                                </a>
                            </div>
                            <div class="col-6">
                                <form action="">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" placeholder="Cari Nama Pelanggan/Nomor Telepon ...">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="bi bi-search"></i> Search
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama</th>
                                    <th class="text-center">No. Telp</th>
                                    <th class="text-center">Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th class="text-center">Kota</th>
                                    <th class="text-center">Provinsi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>
                                            {{ (($data->currentPage() - 1) * $data->perPage()) + $loop->iteration }} 
                                        </td>
                                        <td>{{ $item->nama_pelanggan }} </td>
                                        <td class="text-center">{{ $item->telp }} </td>
                                        <td>{{ $item->jenis_kelamin }} </td>
                                        <td>{{ $item->alamat }} </td>
                                        <td>{{ $item->kota }} </td>
                                        <td>{{ $item->provinsi }} </td>
                                        <td class="text-center">
                                            <a href="{{ url('/pelanggan/edit') }}/{{ $item->id }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            
                                            <a href="{{ url('/pelanggan', ['id' => $item->id]) }}" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Hapus Data {{ $item->nama_suplier }} ??');">
                                                 <i class="bi bi-trash"></i> Delete
                                             </a>
                                             
                                        </td>
                                    </tr>   
                                @endforeach
                            </tbody>
                        </table>
                        {{ $data->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>    

@endsection