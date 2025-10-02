@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h2 class="fw-bold display-5 text-gradient">🎬 Movies in {{ $category->name }}</h2>
        <div class="mx-auto mt-2" style="width: 120px; height: 4px; background: linear-gradient(90deg, #ff512f, #dd2476); border-radius: 3px;"></div>
    </div>

    <!-- Movies Grid -->
    <div class="row g-4">
        @if ($movies->isEmpty())
            <div class="col-12 text-center">
                <p class="text-muted fs-5">No movies found in this category.</p>
            </div>
        @else
            @foreach ($movies as $movie)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="movie-card position-relative overflow-hidden rounded-4 shadow-lg">
                        <img src="{{ $movie->poster_image_url }}" alt="{{ $movie->title }}" class="img-fluid w-100">

                        <!-- Overlay -->
                        <div class="overlay d-flex flex-column justify-content-end p-3">
                            <h5 class="text-white fw-bold">{{ $movie->title }}</h5>
                            <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-sm btn-gradient mt-2">ดูรายละเอียด</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Back Button -->
    <div class="text-center mt-5">
        <a href="{{ route('categories.list') }}" class="btn btn-lg btn-outline-secondary">← Back to Categories</a>
    </div>
</div>

<style>
/* Gradient text */
.text-gradient {
    background: linear-gradient(90deg, #ff512f, #dd2476);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Movie card */
.movie-card {
    cursor: pointer;
    position: relative;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}
.movie-card:hover {
    transform: scale(1.05);
    box-shadow: 0 20px 30px rgba(0,0,0,0.25);
}

/* Overlay for title and button */
.movie-card .overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.85), transparent);
    padding: 15px;
    opacity: 0;
    transition: opacity 0.3s ease, transform 0.3s ease;
    transform: translateY(20%);
    color: #ffffff; /* ทำให้ตัวอักษรขาว */
    text-shadow: 1px 1px 3px rgba(0,0,0,0.6); /* เพิ่มความคมชัด */
}
.movie-card:hover .overlay {
    opacity: 1;
    transform: translateY(0);
}

/* Overlay title */
.movie-card .overlay h5 {
    font-weight: 600;
    margin: 0;
    color: #ffffff; /* ตัวอักษรขาว */
    text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
}

/* Gradient buttons */
.btn-gradient {
    background: linear-gradient(90deg, #ff512f, #dd2476);
    color: white;
    border: none;
    font-weight: 500;
    transition: background 0.3s ease, transform 0.2s ease;
    text-shadow: 0px 1px 2px rgba(0,0,0,0.5); /* ตัวอักษรปุ่มอ่านง่ายขึ้น */
}
.btn-gradient:hover {
    background: linear-gradient(90deg, #dd2476, #ff512f);
    transform: translateY(-2px);
}

/* Responsive hover effect for mobile: show overlay always */
@media (max-width: 768px) {
    .movie-card .overlay {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>
@endsection
