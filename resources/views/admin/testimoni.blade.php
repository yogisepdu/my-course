@extends('admin.layouts.app')

@section('content')
    <section class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">DataTable</a></li>
                                <li class="breadcrumb-item" aria-current="page">{{ $title }}</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">{{ $title }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- Single Select table start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class=" d-flex flex-wrap gap-2 justify-content-between align-items-center">
                            <div class="card-header ">
                                <h5>{{ $title }}</h5>
                                <small>{{ $description }}</small>
                            </div>
                            <!-- [ link-button ] start -->
                            <div class="card-header">
                                <a class="btn btn-primary" role="button" href="{{ $createUrl }}">Create
                                    Course</a>
                            </div>
                        </div>
                        <!-- [ link-button ] end -->
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table id="single-select" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Pekerjaan</th>
                                            <th>Description</th>
                                            <th>Profil Picture</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($testimonis as $data)
                                            <tr>
                                                <td class="text-wrap">{{ $loop->iteration }}</td>
                                                <td class="text-wrap">{{ $data->name ?? '' }}</td>
                                                <td class="text-wrap">{{ $data->job ?? '' }}</td>
                                                <td class="text-wrap">{{ $data->description ?? '' }}</td>
                                                <td>
                                                    @if ($data->profile_picture)
                                                        <img class="w-12 h-12 object-cover rounded-full mx-auto shadow"
                                                            style="width: 48px; height: 48px;"
                                                            src="{{ asset('storage/' . $data->profile_picture) }}"
                                                            alt="{{ $data->name }}">
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-wrap card-body pc-component">
                                                    <a type="button" class="btn btn-light-primary"
                                                        href="{{ $data->edit_url }}">Edit</a>
                                                    <a type="button" class="btn btn-light-danger"
                                                        href="{{ URL::signedRoute('admin.testimoni.destroy', ['id' => $data->id]) }}"
                                                        onclick="return confirm('Yakin ingin menghapus testimoni ini?')">
                                                        Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Pekerjaan</th>
                                            <th>Description</th>
                                            <th>Profil Picture</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Single Select table end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </section>
@endsection
@section('scripts')
@endsection
