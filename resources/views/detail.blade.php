@extends('layouts.app')

@section('content')
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-bottom: 90px;">
        <div class="container text-center py-5">
            <h1 class="text-white display-1">Course Detail</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Course Detail</p>
            </div>
            <div class="mx-auto mb-5" style="width: 100%; max-width: 600px;">
                <div class="input-group">
                    <input type="text" class="form-control border-light" style="padding: 30px 25px;"
                        placeholder="Keyword">
                    <div class="input-group-append">
                        <button class="btn btn-secondary px-4 px-lg-5">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Detail Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-5">
                        <div class="section-title position-relative mb-5">
                            <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Course
                                Detail
                            </h6>
                            <h1 class="display-4">{{ $course->title }}</h1>
                        </div>
                        <img class="img-fluid rounded w-100 mb-4" src="{{ asset('storage/' . $course->thumbnail) }}"
                            alt="{{ $course->title }}" style=" object-fit: cover;">
                        <p>{{ $course->description }}</p>
                    </div>

                    <h2 class="mb-3">Related Courses</h2>
                    <div class="owl-carousel related-carousel position-relative" style="padding: 0 30px;">
                        @forelse ($list_course as $data)
                            <a class="courses-list-item position-relative d-block overflow-hidden mb-2"
                                href="{{ $data->detail_url }}">
                                <img class="img-fluid" src="{{ asset('storage') . '/' . $data->thumbnail }}"
                                    alt="{{ $data->title }}" style="height: 150px; object-fit: cover;">
                                <div class="courses-text">
                                    <h4 class="text-center text-white px-3">{{ $data->title }}</h4>
                                    <div class="border-top w-100 mt-3">
                                        <div class="d-flex justify-content-between p-4">
                                            <span class="text-white"><i
                                                    class="fa fa-user mr-2"></i>{{ $data->instructor->user->name }}</span>
                                            <span class="text-white"><i class="fa fa-star mr-2"></i>4.5
                                                <small>(250)</small></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-center text-muted">Belum ada course tersedia.</p>
                        @endforelse
                    </div>
                </div>


                <div class="col-lg-4 mt-5 mt-lg-0">
                    <div class="bg-primary mb-5 py-3">
                        <h3 class="text-white py-3 px-4 m-0">Course Features</h3>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Instructor</h6>
                            <h6 class="text-white my-3">{{ $course->instructor->user->name }}</h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Rating</h6>
                            <h6 class="text-white my-3">4.5 <small>(250)</small></h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Duration</h6>
                            <h6 class="text-white my-3">{{ $course->duration }} Hrs</h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Skill level</h6>
                            <h6 class="text-white my-3">
                                @switch($course->category)
                                    @case(1)
                                        Beginner
                                    @break

                                    @case(2)
                                        Intermediate
                                    @break

                                    @case(3)
                                        Advanced
                                    @break

                                    @default
                                        -
                                @endswitch
                            </h6>
                        </div>
                        <div class="d-flex justify-content-between px-4">
                            <h6 class="text-white my-3">Language</h6>
                            <h6 class="text-white my-3">Indonesian</h6>
                        </div>
                        <h5 class="text-white py-3 px-4 m-0">Course Price: {{ $course->price }} IDR</h5>
                        <div class="py-3 px-4">
                            <a class="btn btn-block btn-secondary py-3 px-5" href="">Enroll Now</a>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="mb-4">News Courses</h2>
                        @forelse ($paginate as $data)
                            <a class="d-flex align-items-center text-decoration-none mb-4" href="">
                                <img class="img-fluid rounded" src="{{ asset('storage') . '/' . $data->thumbnail }}"
                                    alt="{{ $data->title }}" style="width: 100px; height: 100px; object-fit: cover;">
                                <div class="pl-3">
                                    <h6>{{ $data->title }}</h6>
                                    <div class="d-flex">
                                        <small class="text-body mr-3"><i
                                                class="fa fa-user text-primary mr-2"></i>{{ $data->instructor->user->name }}</small>
                                        <small class="text-body"><i class="fa fa-star text-primary mr-2"></i>4.5
                                            (250)
                                        </small>
                                    </div>
                                </div>
                            </a>

                        @empty
                            <p class="text-center text-muted">Belum ada course tersedia.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Detail End -->
@endsection
