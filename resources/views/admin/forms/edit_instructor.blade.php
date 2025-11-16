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
                        <form action="{{ route('admin.instructor.update', $instructor->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT') {{-- pakai PUT karena update --}}
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="nameInstructor">Name Instructor</label>
                                    <input type="text" name="name" id="nameInstructor" class="form-control"
                                        value="{{ old('name', $instructor->name) }}" placeholder="Enter instructor name">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="jobInstructor">Job</label>
                                    <input type="text" name="job" id="jobInstructor" class="form-control"
                                        value="{{ old('job', $instructor->job) }}" placeholder="Enter job title">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="profilePicture">Profile Picture</label>
                                    @if ($instructor->profile_picture)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $instructor->profile_picture) }}"
                                                alt="{{ $instructor->name }}" class="object-cover rounded shadow"
                                                style="width: 150px; height: 150px; object-fit: cover;">
                                        </div>
                                    @endif
                                    <input type="file" name="profile_picture" id="profilePicture" class="form-control">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="twitterAccount">Account Twitter</label>
                                    <input type="text" name="twitter" id="twitterAccount" class="form-control"
                                        value="{{ old('twitter', $instructor->links_twitter) }}"
                                        placeholder="Enter Twitter account">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="linkedinAccount">Account LinkedIn</label>
                                    <input type="text" name="linkedin" id="linkedinAccount" class="form-control"
                                        value="{{ old('linkedin', $instructor->links_linkedin) }}"
                                        placeholder="Enter LinkedIn account">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="facebookAccount">Account Facebook</label>
                                    <input type="text" name="facebook" id="facebookAccount" class="form-control"
                                        value="{{ old('facebook', $instructor->links_facebook) }}"
                                        placeholder="Enter Facebook account">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="instagramAccount">Account Instagram</label>
                                    <input type="text" name="instagram" id="instagramAccount" class="form-control"
                                        value="{{ old('instagram', $instructor->links_instagram) }}"
                                        placeholder="Enter Instagram account">
                                </div>

                                <div class="form-group mb-0">
                                    <label class="form-label" for="youtubeAccount">Account YouTube</label>
                                    <input type="text" name="youtube" id="youtubeAccount" class="form-control"
                                        value="{{ old('youtube', $instructor->links_youtube) }}"
                                        placeholder="Enter YouTube account">
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="{{ route('admin.instructor.index') }}" class="btn btn-light">Cancel</a>
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
