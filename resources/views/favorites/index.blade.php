@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 fw-bold text-white">⭐ My Favorite Movies</h2>
    <hr style="border-top: 2px solid #ffffff;">

    <div class="row g-4">
        @if ($movies->isEmpty())
            <div class="col-12">
                <p class="text-white">คุณยังไม่ได้เพิ่มภาพยนตร์ใดๆ ลงในรายการโปรดของคุณ</p>
            </div>
        @else
            @foreach ($movies as $movie)
                <div class="col-md-4">
                    <div class="card favorite-card h-100 shadow-sm rounded-4 hover-card">
                        <img src="{{ $movie->poster_image_url }}" class="card-img-top rounded-top-4" alt="{{ $movie->title }}" style="height: 280px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark">{{ $movie->title }}</h5>
                            <a href="{{ route('admin.movies.show', $movie->id) }}" class="btn btn-outline-dark mt-auto rounded-pill w-100">
                                ดูรายละเอียด
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<style>
body {
    background: #f5f6f8;
    font-family: 'Prompt', sans-serif;
}

/* Favorite Card */
.favorite-card {
    background: #fff;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}

/* Card Title */
.card-title {
    margin-bottom: 1rem;
}

/* Button */
.btn-outline-dark {
    border: 1px solid #333;
    color: #333;
    transition: all 0.3s ease;
}
.btn-outline-dark:hover {
    background-color: #333;
    color: #fff;
    transform: scale(1.05);
}
</style>
@endsection
