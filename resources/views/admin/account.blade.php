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
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $data)
                                            <tr>
                                                <td class="text-wrap">{{ $loop->iteration }}</td>
                                                <td class="text-wrap">{{ $data->name ?? '' }}</td>
                                                <td class="text-wrap">{{ $data->email ?? '' }}</td>
                                                <td class="text-wrap">{{ $data->role ?? '' }}</td>
                                                <td class="text-wrap card-body pc-component">
                                                    <a type="button" class="btn btn-light-primary"
                                                        href="{{ $data->edit_url }}">Edit</a>

                                                    @if ($data->role !== 'student' && $data->role !== 'admin')
                                                        <a type="button" class="btn btn-light-danger"
                                                            href="{{ URL::signedRoute('admin.account.destroy', ['id' => $data->id]) }}"
                                                            onclick="return confirm('Yakin ingin menghapus User ini?')">
                                                            Hapus
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Status</th>
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
