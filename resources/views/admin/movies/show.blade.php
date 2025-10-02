@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Card หนัง --}}
            <div class="card shadow-sm border-0 rounded-4 hover-card">
                <img src="{{ $movie->poster_image_url }}" 
                     class="card-img-top rounded-top-4" 
                     alt="{{ $movie->title }}" 
                     style="height: 400px; object-fit: cover;">

                <div class="card-body">
                    <h2 class="card-title fw-bold text-dark">{{ $movie->title }}</h2>
                    <p class="card-text text-muted">{{ $movie->description }}</p>

                    {{-- หมวดหมู่ --}}
                    <p class="card-text">
                        <strong>หมวดหมู่:</strong>
                        @foreach ($movie->categories as $category)
                            <span class="badge bg-secondary">{{ $category->name }}</span>
                        @endforeach
                    </p>

                    {{-- ปุ่มโปรด --}}
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        @auth
                            @if (Auth::user()->favoriteMovies->contains($movie->id))
                                <form action="{{ route('movies.unfavorite', $movie) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger rounded-pill">
                                        <i class="fas fa-heart-broken"></i> ลบจากโปรด
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('movies.favorite', $movie) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning rounded-pill">
                                        <i class="fas fa-heart"></i> เพิ่มในโปรด
                                    </button>
                                </form>
                            @endif
                        @else
                            <p class="text-muted">โปรด <a href="{{ route('login') }}">ล็อกอิน</a> เพื่อเพิ่มหนังในรายการโปรด</p>
                        @endif
                        <a href="{{ url('/') }}" class="btn btn-outline-dark rounded-pill">ย้อนกลับ</a>
                    </div>
                </div>
            </div>

            {{-- Card Comment --}}
            <div class="card shadow-sm border-0 rounded-4 hover-card mt-4 p-4">
                <h3>แสดงความคิดเห็น</h3>
                <hr>

                {{-- ฟอร์มคอมเมนต์ --}}
                @auth
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="movie_id" value="{{ $movie->id }}">

                    <div class="mb-3">
                        <label for="rating" class="form-label">ให้คะแนน</label>
                        <select name="rating" id="rating" class="form-control">
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }} ดาว</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label">ความคิดเห็น</label>
                        <textarea class="form-control" name="body" id="comment" rows="3" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">ส่งความคิดเห็น</button>
                </form>
                @else
                <p class="text-center">โปรด <a href="{{ route('login') }}">ล็อกอิน</a> เพื่อแสดงความคิดเห็น</p>
                @endauth

                <hr>

                <h4 class="mt-4">ความคิดเห็นจากผู้ใช้งาน</h4>
                @forelse($movie->comments as $comment)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $comment->user->name }}
                                {{-- แสดงดาว rating --}}
                                @for($i = 0; $i < $comment->rating; $i++)
                                    <i class="fa fa-star text-warning"></i>
                                @endfor
                                @for($i = $comment->rating; $i < 5; $i++)
                                    <i class="fa fa-star text-secondary"></i>
                                @endfor
                            </h5>
                            <p class="card-text">{{ $comment->body }}</p>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>

                            {{-- ถ้าเป็นเจ้าของ comment แสดงปุ่มแก้ไข --}}
                            @can('update', $comment)
                                <a href="{{ route('comments.edit', $comment) }}" class="btn btn-sm btn-warning mt-2">Edit</a>
                            @endcan

                            {{-- admin ลบ comment --}}
                            @can('delete', $comment)
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger mt-2" onclick="return confirm('Delete this comment?')">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @empty
                    <p>ยังไม่มีความคิดเห็นสำหรับหนังเรื่องนี้</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Custom Style --}}
<style>
body {
    background: #f5f6f8;
    font-family: 'Prompt', sans-serif;
}

.hover-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.btn-warning {
    background-color: #ffc107;
    color: #fff;
    border: none;
}
.btn-warning:hover {
    background-color: #e0a800;
    color: #fff;
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
    border: none;
}
.btn-danger:hover {
    background-color: #bd2130;
    color: #fff;
}

.card-title {
    margin-bottom: 0.75rem;
}

.card-text {
    font-size: 0.95rem;
    line-height: 1.5;
}
</style>
@endsection
