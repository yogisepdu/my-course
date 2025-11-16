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
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
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
                        <form action="{{ route('admin.ecourse.content.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                {{-- Section --}}
                                <div class="form-group mb-3">
                                    <label class="form-label" for="section_id">Section</label>
                                    <select name="section_id" id="section_id"
                                        class="form-control @error('section_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>-- Select Section --</option>
                                        @foreach ($section as $sec)
                                            <option value="{{ $sec->id }}"
                                                {{ old('section_id') == $sec->id ? 'selected' : '' }}>
                                                {{ $sec->title }} (Course: {{ $sec->course->title ?? '-' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('section_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Title --}}
                                <div class="form-group mb-3">
                                    <label class="form-label" for="title">Content Title</label>
                                    <input type="text" name="title" id="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Enter content title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Content Type --}}
                                <div class="form-group mb-3">
                                    <label class="form-label" for="content_type">Content Type</label>
                                    <select name="content_type" id="content_type"
                                        class="form-control @error('content_type') is-invalid @enderror" required>
                                        <option value="" disabled selected>-- Select Type --</option>
                                        <option value="video" {{ old('content_type') == 'video' ? 'selected' : '' }}>Video
                                        </option>
                                        <option value="pdf" {{ old('content_type') == 'pdf' ? 'selected' : '' }}>PDF
                                        </option>
                                        <option value="text" {{ old('content_type') == 'text' ? 'selected' : '' }}>Text
                                        </option>
                                    </select>
                                    @error('content_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Content URL --}}
                                <div class="form-group mb-3">
                                    <label class="form-label" for="content_url">Content URL</label>
                                    <input type="url" name="content_url" id="content_url"
                                        class="form-control @error('content_url') is-invalid @enderror"
                                        placeholder="Enter content URL (if any)" value="{{ old('content_url') }}">
                                    @error('content_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Body --}}
                                <div class="form-group mb-3">
                                    <label class="form-label" for="body">Body (Text Content)</label>
                                    <textarea name="body" id="body" rows="4" class="form-control @error('body') is-invalid @enderror"
                                        placeholder="Enter text content (optional)">{{ old('body') }}</textarea>
                                    @error('body')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Order --}}
                                <div class="form-group mb-3">
                                    <label class="form-label" for="order">Order</label>
                                    <input type="number" name="order" id="order"
                                        class="form-control @error('order') is-invalid @enderror"
                                        placeholder="Enter order number" value="{{ old('order') ?? 0 }}" required>
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <button type="reset" class="btn btn-light">Reset</button>
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
