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
                                <a class="btn btn-primary" role="button"
                                    href="{{ route('admin.ecourse.content.create') }}">Create
                                    Course</a>
                            </div>
                        </div>
                        <!-- [ link-button ] end -->
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                @php $no = 1; @endphp

                                {{-- Grouping berdasarkan Course --}}
                                @foreach ($section->groupBy('course_id') as $courseId => $sections)
                                    @php $courseTitle = $sections->first()->course->title ?? '-'; @endphp
                                    <h3 class="mt-3">Section (Course: {{ $courseTitle }})</h3>

                                    <div class="mb-4">
                                        <table class="table table-striped table-bordered nowrap">
                                            {{-- Loop per Section di Course ini --}}
                                            @foreach ($sections as $sec)
                                                <thead class="table-primary">
                                                    <tr>
                                                        <td rowspan="2" class="align-middle text-center fw-bold">
                                                            {{ $no++ }}
                                                        </td>
                                                        <td colspan="6" class="fw-bold">
                                                            Section: {{ $sec->title ?? '-' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Title Content</th>
                                                        <th>Type</th>
                                                        <th>View Content</th>
                                                        <th>Body Content</th>
                                                        <th style="width:150px;">Order</th>
                                                        <th style="width:200px;">Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    {{-- Loop isi content berdasarkan section --}}
                                                    @foreach ($content->where('section_id', $sec->id) as $data)
                                                        <tr>
                                                            <td></td>

                                                            {{-- Judul Materi --}}
                                                            <td class="text-wrap">{{ $data->title ?? '-' }}</td>

                                                            {{-- Tipe Konten --}}
                                                            <td class="text-wrap">{{ ucfirst($data->content_type) ?? '-' }}
                                                            </td>

                                                            {{-- Link File / Video --}}
                                                            <td class="text-wrap">
                                                                @if ($data->content_url)
                                                                    <a href="{{ $data->content_url }}"
                                                                        target="_blank">Lihat Konten</a>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>

                                                            {{-- Body (jika ada teks) --}}
                                                            <td class="text-wrap">
                                                                {{ \Illuminate\Support\Str::limit($data->body, 50) ?? '-' }}
                                                            </td>

                                                            {{-- Urutan --}}
                                                            <td class="text-wrap">{{ $data->order ?? '-' }}</td>

                                                            {{-- Action --}}
                                                            <td class="text-wrap card-body pc-component">
                                                                <a type="button" class="btn btn-sm btn-light-primary"
                                                                    href="{{ route('admin.ecourse.content.edit', $data->id) }}">Edit</a>
                                                                <a type="button" class="btn btn-sm btn-light-danger"
                                                                    href="{{ route('admin.ecourse.content.destroy', $data->id) }}">Hapus</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                @endforeach
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
