@extends('layouts.app')

@section('content')
<style>
    /* 1. Global Cinematic Theme & Variables */
    body {
        background: #181a1b; /* Dark background */
        color: #e8e6e3; /* Light text */
    }
    :root {
        --movie-primary: #ffc107; /* Yellow/Gold accent color */
        --movie-secondary: #2c2f33; /* Dark card/section background */
        --movie-text: #ffffff; /* White text for main titles */
        --star-filled: #FFC107; /* Consistent star color */
    }
    .text-muted {
        color: #999 !important; /* Lighter grey for subtle text */
    }
    .fw-bolder {
        color: var(--movie-text);
    }
    .hr-cinematic {
        border-top: 1px solid #3c4044;
    }

    /* 2. Star Rating System (Interactive) - Adjusted for Dark Mode */
    .rating {
        display: inline-block;
        direction: rtl;
        font-size: 0;
    }
    .rating > input {
        display: none;
    }
    .rating > label {
        font-size: 2rem;
        color: #555; /* Darker grey for unselected on dark background */
        cursor: pointer;
        transition: color 0.2s;
        padding: 0 0.1rem;
    }
    .rating > label:hover,
    .rating > label:hover ~ label {
        color: var(--star-filled);
    }
    .rating > input:checked ~ label {
        color: var(--star-filled);
    }

    /* 3. Static Star Display (Read-only) */
    .static-rating {
        font-size: 1.5rem;
        color: #555;
    }
    .static-rating .filled {
        color: var(--star-filled);
    }

    /* 4. Average Rating Block */
    .avg-rating-block {
        display: flex;
        align-items: center;
        gap: 20px;
        background-color: #3e4247; /* Slightly lighter dark background */
        padding: 15px 25px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }
    .avg-rating-value {
        font-size: 2.8rem; /* Larger score */
        font-weight: 700;
        color: var(--movie-primary); /* Use accent color for the score */
        line-height: 1;
    }
    .avg-rating-text {
        font-size: 0.9rem;
        color: #ccc;
        margin-top: -5px;
    }

    /* 5. Poster Shadow */
    .movie-poster-img {
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); /* Stronger shadow */
        transition: transform 0.3s ease;
    }
    .movie-poster-img:hover {
        transform: scale(1.02);
    }

    /* 6. Comment Card & Form Style */
    .comment-card, .comment-form-card {
        background-color: var(--movie-secondary) !important;
        border: 1px solid #3c4044;
        color: #e8e6e3;
        border-radius: 8px;
    }
    .comment-card {
        border-left: 5px solid var(--movie-primary);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    /* 7. Buttons - Themed */
    .btn-info { /* Watch Trailer */
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .btn-success { /* Add to Favorites */
        background-color: #28a745;
        border-color: #28a745;
    }
    .btn-danger { /* Remove Favorite / Delete */
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .btn-primary { /* Submit Comment */
        background-color: var(--movie-primary);
        border-color: var(--movie-primary);
        color: #181a1b;
    }
    .btn-primary:hover {
        background-color: #e0a800;
        border-color: #e0a800;
        color: #181a1b;
    }
    .btn-outline-primary { /* Like button */
        color: var(--movie-primary);
        border-color: var(--movie-primary);
    }
    .btn-outline-primary:hover {
        background-color: var(--movie-primary);
        color: #181a1b;
    }

    /* 8. Form Controls */
    .form-control {
        background-color: #3e4247;
        color: #e8e6e3;
        border: 1px solid #555;
    }
    .form-control::placeholder {
        color: #999;
    }
    .form-control:focus {
        background-color: #3e4247;
        color: #e8e6e3;
        border-color: var(--movie-primary);
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
    }

    /* 9. Categories Badge */
    .badge.bg-primary {
        background-color: #0d6efd !important;
    }

    .comment-card {
        background-color: #222;
        border: 1px solid #444;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s;
    }
    .comment-card:hover {
        transform: translateY(-5px);
    }
    .comment-form-card {
        background-color: #2c2c2c;
        border-radius: 10px;
    }
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <img src="{{ $movie->poster_image_url }}" class="img-fluid movie-poster-img" alt="{{ $movie->title }}">
        </div>

        <div class="col-md-8">
            <h1 class="fw-bolder mb-3">{{ $movie->title }}</h1>

            @php
                $averageRating = $movie->comments->avg('rating');
                $totalComments = $movie->comments->count();
            @endphp

            <div class="avg-rating-block mb-4">
                <div class="text-center">
                    <span class="avg-rating-value">{{ number_format($averageRating, 1) }}</span>
                    <p class="avg-rating-text mb-0">of 5</p>
                </div>
                <div>
                    <div class="static-rating" title="Average rating: {{ number_format($averageRating, 1) }} out of 5">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= round($averageRating) ? 'filled' : '' }}">&#9733;</span>
                        @endfor
                    </div>
                    <p class="text-muted mt-1 mb-0">{{ $totalComments }} Reviews</p>
                </div>
            </div>

            <p class="text-muted small">Released on: <span class="fw-bold text-light">{{ \Carbon\Carbon::parse($movie->release_date)->format('F d, Y') }}</span></p>
            
            <hr class="hr-cinematic">
            
            <h5 class="mt-4 mb-3 fw-bold text-light">Synopsis</h5>
            <p class="text-white">{{ $movie->description }}</p>

            <div class="mt-4 d-flex align-items-center gap-3">
                @if($movie->trailer_url)
                    <a href="{{ route('movies.trailer', $movie->id) }}" class="btn btn-info btn-lg fw-bold">
                        <i class="fas fa-play me-2"></i> Watch Trailer
                    </a>
                @endif

                @auth
                    @if(auth()->user()->favoriteMovies->contains($movie))
                        <form action="{{ route('movies.unfavorite', $movie) }}" method="POST" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-lg">
                                <i class="fas fa-heart-crack me-2"></i> Remove from Favorites
                            </button>
                        </form>
                    @else
                        <form action="{{ route('movies.favorite', $movie) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-heart me-2"></i> Add to Favorites
                            </button>
                        </form>
                    @endif
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i> Log in to Favorite
                    </a>
                @endguest
            </div>

            <hr class="mt-4 mb-4 hr-cinematic">

            <h5 class="mb-3 fw-bold text-light">Categories:</h5>
            @if($movie->categories->count() > 0)
                <div>
                    @foreach($movie->categories as $category)
                        <span class="badge rounded-pill bg-info me-2 py-2 px-3 fw-bold">{{ $category->name }}</span>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No categories assigned.</p>
            @endif
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h2 class="fw-bolder border-bottom border-warning pb-2 mb-4 text-white">User Reviews ({{ $totalComments }})</h2>

            @auth
            <div class="card mb-5 shadow-sm comment-form-card">
                <div class="card-body">
                    <h5 class="card-title fw-bold" style="color: var(--movie-primary);">แสดงความคิดเห็นของคุณ</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">

                        <div class="mb-3">
                            <label class="form-label fw-bold">ให้คะแนน:</label>
                            <div class="rating">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" required>
                                    <label for="star{{$i}}" title="{{$i}} stars">&#9733;</label>
                                @endfor
                            </div>
                        </div>

                        <div class="mb-3">
                            <textarea class="form-control" name="body" rows="3" placeholder="เขียนคอมเมนต์..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary fw-bold">
                            <i class="fas fa-paper-plane me-1"></i> ส่งความคิดเห็น
                        </button>
                    </form>
                </div>
            </div>
            @endauth

            @guest
                <p class="alert alert-secondary border-0" style="background-color: #3e4247; color: #ccc;">
                    <i class="fas fa-lock me-2"></i> <a href="{{ route('login') }}" class="alert-link text-warning fw-bold">เข้าสู่ระบบ</a>เพื่อแสดงความคิดเห็น
                </p>
            @endguest

            @auth
                @forelse ($movie->comments->sortByDesc('created_at') as $comment)
                    <div class="card mb-4 comment-card">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <!-- Profile Image -->
                                <img src="{{ $comment->user?->profile_image_url ?? 'https://via.placeholder.com/50' }}" 
                                     alt="{{ $comment->user?->name ?? 'User' }}'s profile" 
                                     class="rounded-circle me-3" 
                                     width="50" 
                                     height="50"
                                     style="object-fit: cover;">

                                <div class="w-100">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="card-title fw-bold mb-1 text-white">
                                                @if($comment->user)
                                                    {{ $comment->user->name }}
                                                @else
                                                    [ผู้ใช้ถูกลบ]
                                                @endif
                                            </h6>
                                            <div class="static-rating mb-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span class="{{ $i <= $comment->rating ? 'filled' : '' }}">&#9733;</span>
                                                @endfor
                                            </div>
                                        </div>
                                        <small class="text-muted text-end flex-shrink-0">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    
                                    <p class="card-text">{{ $comment->body }}</p>
                                    
                                    <hr class="my-2 hr-cinematic">

                                    <div class="d-flex align-items-center gap-2">
                                        @if(auth()->user() && auth()->user()->role === 'user' && auth()->id() !== $comment->user_id)
                                            <form action="{{ route('comments.like', $comment->id) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-thumbs-up me-1"></i> Like ({{ $comment->likes_count ?? 0 }})
                                                </button>
                                            </form>
                                        @endif

                                        @if(auth()->user() && auth()->id() === $comment->user_id)
                                            <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                        @endif

                                        @if(auth()->user() && auth()->user()->role === 'admin')
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="m-0 delete-comment-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">ยังไม่มีความคิดเห็น</p>
                @endforelse
            @endauth
            @guest
                <p class="alert alert-secondary border-0" style="background-color: #3e4247; color: #ccc;">
                    <i class="fas fa-lock me-2"></i> <a href="{{ route('login') }}" class="alert-link text-warning fw-bold">เข้าสู่ระบบ</a>เพื่อดูความคิดเห็น
                </p>
            @endguest
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-comment-form').forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "คุณจะไม่สามารถกู้คืนคอมเมนต์นี้ได้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Use Fetch API to submit the form
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            _method: 'DELETE'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'ลบสำเร็จ',
                                'ความคิดเห็นถูกลบแล้ว',
                                'success'
                            ).then(() => {
                                location.reload(); // Reload the page to see the change
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire(
                            'Error!',
                            'Something went wrong.',
                            'error'
                        );
                    });
                }
            });
        });
    });
});
</script>
@endpush