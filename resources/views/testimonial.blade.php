@extends('layouts.app')

@section('content')
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-bottom: 90px;">
        <div class="container text-center py-5">
            <h1 class="text-white display-1">Testimonial</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Testimonial</p>
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


    <!-- Testimonial Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="section-title position-relative mb-4">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Testimonial</h6>
                        <h1 class="display-4">What Say Our Students</h1>
                    </div>
                    <p class="m-0">Dolor est dolores et nonumy sit labore dolores est sed rebum amet, justo duo ipsum
                        sanctus dolore magna rebum sit et. Diam lorem ea sea at. Nonumy et at at sed justo est nonumy
                        tempor. Vero sea ea eirmod, elitr ea amet diam ipsum at amet. Erat sed stet eos ipsum diam</p>
                </div>
                <div class="col-lg-7">
                    <div class="owl-carousel testimonial-carousel">
                        @forelse ($testimonis as $testi)
                            <div class="bg-white p-5">
                                <i class="fa fa-3x fa-quote-left text-primary mb-4"></i>
                                <p>{{ $testi->description }}</p>
                                <div class="d-flex flex-shrink-0 align-items-center mt-4">
                                    <img class="img-fluid mr-4" src="{{ asset('storage') . '/' . $testi->profile_picture }}"
                                        alt="{{ $testi->name }}" style="width: 250px; height: 220px; object-fit: cover;">
                                    <div>
                                        <h5>{{ \Illuminate\Support\Str::title($testi->name) }}</h5>
                                        <span>{{ $testi->job }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">Belum ada testimoni tersedia.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial Start -->
@endsection
