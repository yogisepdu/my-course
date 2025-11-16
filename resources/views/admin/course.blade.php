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
                                <a class="btn btn-primary" role="button" href="{{ route('admin.ecourse.create') }}">Create
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
                                            <th>title</th>
                                            <th>description</th>
                                            <th>slug</th>
                                            <th>thumbnail</th>
                                            <th>category</th>
                                            <th>duration</th>
                                            <th>price</th>
                                            <th>Name instructor</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($courses as $data)
                                            <tr>
                                                <td class="text-wrap">{{ $loop->iteration }}</td>
                                                <td class="text-wrap">{{ $data->title ?? '' }}</td>
                                                <td class="text-wrap">{{ $data->description ?? '' }}</td>
                                                <td class="text-wrap">{{ $data->slug ?? '' }}</td>
                                                <td>
                                                    @if ($data->thumbnail)
                                                        <img class="w-12 h-12 object-cover rounded-full mx-auto shadow"
                                                            style="width: 48px; height: 48px;"
                                                            src="{{ asset('storage/' . $data->thumbnail) }}"
                                                            alt="{{ $data->title }}">
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-wrap">
                                                    @if ($data->category == 1)
                                                        Beginner
                                                    @elseif ($data->category == 2)
                                                        Intermediate
                                                    @elseif ($data->category == 3)
                                                        Advanced
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-wrap">{{ $data->duration ?? '' }} Hours</td>
                                                <td class="text-wrap">{{ $data->price ?? '' }} IDR</td>
                                                <td class="text-wrap">{{ $data->instructor->user->name ?? '-' }}</td>
                                                <td class="text-wrap card-body pc-component">
                                                    <a type="button" class="btn btn-light-primary"
                                                        href="{{ route('admin.ecourse.edit', $data->id) }}">Edit</a>
                                                    <a type="button" class="btn btn-light-danger"
                                                        href="{{ route('admin.ecourse.destroy', $data->id) }}">Hapus</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>title</th>
                                            <th>description</th>
                                            <th>slug</th>
                                            <th>thumbnail</th>
                                            <th>category</th>
                                            <th>duration</th>
                                            <th>price</th>
                                            <th>Name instructor</th>
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
