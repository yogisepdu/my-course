@extends('admin.layouts.app')

@section('content')
    <!-- [ Main Content ] start -->
    <section class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Forms</a></li>
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
                <!-- [ form-element ] start -->
                <div class="col-lg-12">
                    <!-- Basic Inputs -->
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $description }}</h5>
                        </div>
                        <form action="{{ route('admin.ecourse.update', $course->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="titleCourse">Title Course</label>
                                    <input type="text" name="title" id="titleCourse" class="form-control"
                                        value="{{ old('title', $course->title) }}" placeholder="Enter course title">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="descriptionCourse">Description Course</label>
                                    <textarea name="description" id="descriptionCourse" class="form-control" rows="3"
                                        placeholder="Enter course description">{{ old('description', $course->description) }}</textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="slugCourse">Slug of Course</label>
                                    <input type="text" name="slug" id="slugCourse" class="form-control"
                                        value="{{ old('slug', $course->slug) }}" placeholder="Enter course slug">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="thumbnailCourse">Thumbnail Course</label>
                                    @if ($course->thumbnail)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                                alt="{{ $course->title }}" class="object-cover rounded shadow"
                                                style="width: 350px;">
                                        </div>
                                    @endif
                                    <input type="file" name="thumbnail" id="thumbnailCourse" class="form-control">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="categoryCourse">Category Course</label>
                                    <select name="category" id="categoryCourse" class="form-select">
                                        <option value="1"
                                            {{ old('category', $course->category) == 1 ? 'selected' : '' }}>Beginner
                                        </option>
                                        <option value="2"
                                            {{ old('category', $course->category) == 2 ? 'selected' : '' }}>Intermediate
                                        </option>
                                        <option value="3"
                                            {{ old('category', $course->category) == 3 ? 'selected' : '' }}>Advanced
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="durationCourse">Duration</label>
                                    <input type="text" name="duration" id="durationCourse" class="form-control"
                                        value="{{ old('duration', $course->duration) }}"
                                        placeholder="Enter duration (e.g., 3 hours)">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="priceCourse">Price</label>
                                    <input type="number" name="price" id="priceCourse" class="form-control"
                                        value="{{ old('price', $course->price) }}" placeholder="Enter price in IDR">
                                </div>

                                <div class="form-group mb-0">
                                    <label class="form-label" for="instructorCourse">Instructor Course</label>
                                    <select name="instructor_id" id="instructorCourse" class="form-select"
                                        {{ $instructors->isEmpty() ? 'disabled' : '' }}>
                                        @if ($instructors->isEmpty())
                                            <option value="" disabled selected>No instructors available</option>
                                        @else
                                            <option value="" disabled>Select instructor</option>
                                            @foreach ($instructors as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ old('instructor_id', $course->instructor_id) == $data->id ? 'selected' : '' }}>
                                                    {{ $data->user->name . ' - ' . $data->job }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="{{ route('admin.ecourse.index') }}" class="btn btn-light">Cancel</a>
                            </div>
                        </form>
                    </div>
                    <!-- [ form-element ] end -->
                </div>
                <!-- [ Main Content ] end -->
            </div>
    </section>
@endsection
@section('scripts')
@endsection
