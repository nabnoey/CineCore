@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold mb-3">Edit Your Comment</h2>

    <div class="card shadow-sm rounded-4">
        <div class="card-body">

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Rating Input -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">ให้คะแนน:</label>
                    <div class="rating">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" {{ $comment->rating == $i ? 'checked' : '' }} required>
                            <label for="star{{$i}}" title="{{$i}} stars">&#9733;</label>
                        @endfor
                    </div>
                </div>

                <!-- Comment Textarea -->
                <div class="mb-3">
                    <textarea class="form-control rounded-3" name="body" rows="4" placeholder="แก้ไขความคิดเห็นของคุณ..." required>{{ $comment->body }}</textarea>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark btn-modern">Update Comment</button>
                    <a href="{{ route('movies.show', $comment->movie_id) }}" class="btn btn-secondary btn-modern">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Star Rating */
    .rating {
        display: inline-block;
        direction: rtl;
    }
    .rating > input { display: none; }
    .rating > label {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s;
    }
    .rating > label:hover,
    .rating > label:hover ~ label,
    .rating > input:checked ~ label {
        color: #FFD700;
    }

    /* Modern Buttons */
    .btn-modern {
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.2s;
        padding: 0.5rem 1.5rem;
    }
    .btn-modern:hover {
        opacity: 0.85;
    }

    /* Card */
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    /* Textarea */
    .form-control {
        border-radius: 10px;
    }
</style>
@endsection
