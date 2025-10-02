@extends('layouts.app')

@section('content')
<style>
    /* 1. Global Cinematic Tone */
    body {
        background: #181a1b; /* Dark background for a cinematic feel */
        color: #e8e6e3; /* Light text for contrast */
    }

    /* 2. Sidebar Style */
    .sidebar-card {
        background-color: #2c2f33 !important; /* Slightly darker than body */
        border: 1px solid #3c4044;
        color: #e8e6e3;
    }
    .sidebar-card .card-header {
        background-color: #3e4247 !important;
        color: #ffc107; /* Accent color for the header */
        border-bottom: 1px solid #3c4044;
    }
    .sidebar-card .list-group-item {
        background-color: #2c2f33 !important;
        border-color: #3c4044;
    }
    .sidebar-card a {
        color: #c9c9c9;
        transition: color 0.2s;
    }
    .sidebar-card a:hover {
        color: #ffffff; /* Brighter on hover */
        text-decoration: none;
        background-color: #3e4247;
    }
    .list-group-item {
        padding: 10px 15px;
    }

    /* 3. Movie Card Enhancements */
    .movie-card {
        background-color: #2c2f33 !important;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4); /* Stronger shadow */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px !important;
        overflow: hidden;
    }
    .movie-card:hover {
        transform: translateY(-8px); /* More pronounced lift */
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.6);
    }
    .movie-poster {
        height: 300px; /* Slightly taller poster */
        object-fit: cover;
    }
    .movie-card .card-body {
        color: #c9c9c9;
    }
    .movie-card .card-title {
        color: #ffffff;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    /* 4. Detail Button Style */
    .btn-detail {
        background-color: #ffc107; /* Yellow/Gold accent color */
        color: #181a1b;
        font-weight: bold;
        border: none;
        transition: background-color 0.2s ease;
    }
    .btn-detail:hover {
        background-color: #e0a800; /* Darker yellow on hover */
        color: #181a1b;
    }
</style>

<div class="container my-5">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card shadow-lg border-0 rounded-4 sidebar-card">
                <div class="card-header fw-bold">
                    <i class="fas fa-bars me-2"></i> เมนู
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item border-0">
                        <a href="{{ route('categories.list') }}" class="d-flex align-items-center">
                            <i class="fas fa-folder-open me-2"></i> หมวดหมู่หนัง
                        </a>
                    </li>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="list-group-item border-0">
                                <a href="{{ route('admin.movies.index') }}" class="d-flex align-items-center">
                                    <i class="fas fa-film me-2"></i> จัดการ/เพิ่มหนัง
                                </a>
                            </li>
                        @endif
                        <li class="list-group-item border-0">
                            <a href="{{ route('favorites.index') }}" class="d-flex align-items-center">
                                <i class="fas fa-star me-2"></i> รายการโปรด
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>

        <div class="col-md-9">
            <h2 class="mb-5 fw-bolder text-white border-bottom border-warning pb-2">🎥 หนังที่น่าสนใจ</h2>

            <form action="{{ url('/') }}" method="GET" class="mb-4" id="search-form">
                <div class="input-group">
                    <input type="text" name="search" id="search-input" class="form-control" placeholder="ค้นหาหนัง..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">ค้นหา</button>
                </div>
            </form>

            <div class="row g-4" id="movie-list">
                @forelse ($movies as $movie)
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                    <div class="card movie-card h-100">
                        <img src="{{ $movie->poster_image_url }}" 
                             class="card-img-top movie-poster" 
                             alt="{{ $movie->title }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $movie->title }}</h5>
                            <p class="card-text small text-truncate-3">
                                {{ \Illuminate\Support\Str::limit($movie->description, 70) }}
                            </p>
                            <div class="mt-3">
                                <a href="{{ url('movies', $movie->id) }}" 
                                   class="btn btn-detail w-100 rounded-pill">
                                    <i class="fas fa-eye me-1"></i> ดูรายละเอียด
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> ยังไม่มีภาพยนตร์ในรายการ
                    </div>
                </div>
                @endforelse
            </div>
            
            @if(isset($movies) && method_exists($movies, 'links'))
                <div class="mt-5 d-flex justify-content-center">
                    {{ $movies->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const movieList = document.getElementById('movie-list');
    const searchForm = document.getElementById('search-form');

    // Prevent form submission on enter
    searchForm.addEventListener('submit', function (e) {
        e.preventDefault();
    });

    searchInput.addEventListener('keyup', function () {
        const query = this.value;

        fetch(`{{ route('movies.search') }}?query=${query}`)
            .then(response => response.json())
            .then(data => {
                movieList.innerHTML = ''; // Clear existing movies
                if (data.length > 0) {
                    data.forEach(movie => {
                        const movieCard = `
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                            <div class="card movie-card h-100">
                                <img src="${movie.poster_image_url}" 
                                     class="card-img-top movie-poster" 
                                     alt="${movie.title}">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">${movie.title}</h5>
                                    <p class="card-text small text-truncate-3">
                                        ${movie.description ? movie.description.substring(0, 70) : ''}
                                    </p>
                                    <div class="mt-3">
                                        <a href="/movies/${movie.id}"
                                           class="btn btn-detail w-100 rounded-pill">
                                            <i class="fas fa-eye me-1"></i> ดูรายละเอียด
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                        movieList.innerHTML += movieCard;
                    });
                } else {
                    movieList.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> ไม่พบหนังที่ค้นหา
                        </div>
                    </div>
                    `;
                }
            });
    });
});
</script>
@endpush
@endsection