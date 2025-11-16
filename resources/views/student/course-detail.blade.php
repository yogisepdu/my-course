@extends('layouts.app')

@section('content')
    <!-- My Course Start -->
    <div class="container py-5">
        <div class="row">
            <!-- Left: Course Content -->
            <div class="col-lg-8">
                <div class="mb-5">
                    <h1 class="mb-3">{{ $course->title }}</h1>
                    <p class="text-muted">By {{ $course->instructor->user->name }}</p>
                    <img class="img-fluid rounded mb-4" src="{{ asset('storage/' . $course->thumbnail) }}"
                        alt="{{ $course->title }}" style="max-height: 300px; object-fit: cover;">
                    <p>{{ $course->description }}</p>
                </div>

                <!-- Progress -->
                <h3 class="mb-4">Course Content</h3>
                <h5 class="mb-3">
                    Progress: <span id="progress-text">{{ round($progress) }}</span>%
                </h5>
                <div class="progress mb-4" style="height: 20px;">
                    <div class="progress-bar" id="progress-bar" role="progressbar" style="width: {{ round($progress) }}%;"
                        aria-valuenow="{{ round($progress) }}" aria-valuemin="0" aria-valuemax="100">
                        {{ round($progress) }}%
                    </div>
                </div>

                <!-- Accordion Sections -->
                <div class="accordion" id="courseSections">
                    @foreach ($course->sections as $section)
                        <div class="card mb-2">
                            <div class="card-header p-2" id="heading{{ $section->id }}">
                                <h6 class="mb-0 d-flex justify-content-between align-items-center">
                                    <button class="btn btn-link text-left w-100" type="button" data-toggle="collapse"
                                        data-target="#collapse{{ $section->id }}">
                                        {{ $section->order }}. {{ $section->title }}
                                    </button>
                                    @if ($section->locked)
                                        <span class="badge badge-secondary">🔒 Locked</span>
                                    @endif
                                </h6>
                            </div>

                            <div id="collapse{{ $section->id }}" class="collapse" data-parent="#courseSections">
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($section->contents as $content)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $content->order }}. {{ $content->title }}</strong><br>
                                                    @if ($content->locked)
                                                        🔒 <span class="text-muted">Locked</span>
                                                    @else
                                                        @if ($content->content_type === 'video')
                                                            🎥 <a href="{{ $content->content_url }}" target="_blank">Watch
                                                                Video</a>
                                                        @elseif ($content->content_type === 'pdf')
                                                            📄 <a href="{{ $content->content_url }}" target="_blank">Open
                                                                PDF</a>
                                                        @elseif ($content->content_type === 'text')
                                                            ✏️ {!! $content->body !!}
                                                        @endif
                                                    @endif
                                                </div>

                                                @if (!$content->locked)
                                                    <button
                                                        class="btn btn-sm {{ $content->completed ? 'btn-success' : 'btn-secondary' }} mark-complete-btn"
                                                        data-id="{{ $content->id }}">
                                                        {{ $content->completed ? 'Completed' : 'Mark as Complete' }}
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-dark" disabled
                                                        data-id="{{ $content->id }}">Locked</button>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right: Course Info -->
            <div class="col-lg-4">
                <div class="bg-primary text-white p-4 rounded shadow-sm">
                    <h4 class="mb-3">Course Info</h4>
                    <p><strong>Instructor:</strong> {{ $course->instructor->user->name }}</p>
                    <p><strong>Duration:</strong> {{ $course->duration }} hrs</p>
                    <p><strong>Skill Level:</strong>
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
                    </p>
                    <p><strong>Language:</strong> Indonesian</p>
                    <p><strong>Price:</strong> {{ number_format($course->price) }} IDR</p>
                </div>
            </div>
        </div>
    </div>
    <!-- My Course End -->
@endsection
@section('scripts')
    <script>
        function attachListeners() {
            document.querySelectorAll('.mark-complete-btn:not([data-listener])').forEach(button => {
                button.setAttribute('data-listener', 'true'); // biar nggak double listener
                button.addEventListener('click', function() {
                    const btn = this;
                    const contentId = btn.dataset.id;

                    fetch(`/course-content/${contentId}/complete`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                // ✅ Ubah tombol saat ini jadi Completed
                                btn.classList.remove('btn-secondary');
                                btn.classList.add('btn-success');
                                btn.innerText = 'Completed';
                                btn.disabled = true;

                                // ✅ Update progress bar
                                const progressBar = document.getElementById('progress-bar');
                                const progressText = document.getElementById('progress-text');
                                progressBar.style.width = data.progress + '%';
                                progressBar.setAttribute('aria-valuenow', data.progress);
                                progressBar.innerText = data.progress + '%';
                                progressText.innerText = data.progress;

                                // ✅ Unlock content berikutnya dalam section yang sama
                                const currentLi = btn.closest('li');
                                const nextLi = currentLi.nextElementSibling;
                                if (nextLi) {
                                    const lockBtn = nextLi.querySelector('button[disabled]');
                                    if (lockBtn) {
                                        lockBtn.removeAttribute('disabled');
                                        lockBtn.classList.remove('btn-dark');
                                        lockBtn.classList.add('btn-secondary', 'mark-complete-btn');
                                        lockBtn.innerText = 'Mark as Complete';
                                    }

                                    const lockText = nextLi.querySelector('.text-muted');
                                    if (lockText) lockText.remove();
                                }

                                // ✅ Unlock antar section jika ada
                                if (data.unlocked_sections) {
                                    data.unlocked_sections.forEach(sectionId => {
                                        const sectionCard = document.querySelector(
                                            `#heading${sectionId}`);
                                        if (sectionCard) {
                                            const badge = sectionCard.querySelector('.badge');
                                            if (badge) badge.remove(); // hapus badge Locked
                                        }

                                        const sectionCollapse = document.querySelector(
                                            `#collapse${sectionId}`);
                                        if (sectionCollapse) {
                                            sectionCollapse.querySelectorAll('button[disabled]')
                                                .forEach(btn => {
                                                    btn.removeAttribute('disabled');
                                                    btn.classList.remove('btn-dark');
                                                    btn.classList.add('btn-secondary',
                                                        'mark-complete-btn');
                                                    btn.innerText = 'Mark as Complete';
                                                });

                                            sectionCollapse.querySelectorAll('.text-muted')
                                                .forEach(el => el.remove());

                                            // 🔥 Auto expand section yang baru kebuka
                                            $(sectionCollapse).collapse('show');
                                        }
                                    });
                                }

                                // ✅ Pasang listener ke tombol baru yang terbuka
                                attachListeners();
                            }
                        });
                });
            });
        }

        // Jalankan pertama kali saat load
        attachListeners();
    </script>
@endsection
