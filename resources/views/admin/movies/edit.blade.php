@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 fw-bold">Edit Movie</h1>
    <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $movie->title }}" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required>{{ $movie->description }}</textarea>
        </div>

        <!-- Poster URL -->
        <div class="mb-3">
            <label for="poster_image_url" class="form-label">โปสเตอร์ (URL)</label>
            <input type="text" name="poster_image_url" class="form-control" value="{{ $movie->poster_image_url }}" required>
        </div>

        <!-- Trailer URL -->
        <div class="mb-3">
            <label for="trailer_url" class="form-label">ตัวอย่างหนัง (URL)</label>
            <input type="text" name="trailer_url" class="form-control" value="{{ $movie->trailer_url }}">
        </div>

        <!-- Categories -->
        <div class="mb-3">
            <label for="categories" class="form-label">Categories</label>
            <select name="categories[]" class="form-select select2" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $movie->categories->contains($category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Movie</button>
        <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- Select2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select categories",
            allowClear: true,
            width: '100%'
        });
    });
</script>

<!-- Custom Styles -->
<style>
body {
    background-color: #f5f5f5; /* พื้นหลังเทาอ่อน */
    font-family: 'Prompt', sans-serif;
}

/* ฟอร์ม container */
.container {
    background-color: #f8f8f8; /* พื้นหลังฟอร์มอ่อน */
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

/* Labels */
.form-label {
    color: #555; /* ตัวอักษรสีดำอ่อน */
    font-weight: 500;
}

/* Inputs & textarea */
.form-control, .form-select {
    background-color: #ffffff;
    border: 1px solid #ddd;
    color: #333;
}

.form-control:focus, .form-select:focus {
    border-color: #888;
    box-shadow: 0 0 0 0.2rem rgba(136,136,136,0.2);
}

/* Buttons */
.btn-primary {
    background-color: #555;
    border: none;
    color: #f5f5f5;
    transition: background 0.2s ease;
}
.btn-primary:hover {
    background-color: #444;
}

.btn-secondary {
    background-color: #aaa;
    border: none;
    color: #333;
}
.btn-secondary:hover {
    background-color: #888;
}

/* Select2 overrides for theme */
.select2-container--default .select2-selection--multiple {
    background-color: #fff;
    border: 1px solid #ddd;
    color: #333;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #555;
    color: #f5f5f5;
    border: none;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #f5f5f5;
}
.select2-container--default .select2-selection--multiple:focus {
    border-color: #888;
    box-shadow: 0 0 0 0.2rem rgba(136,136,136,0.2);
}
</style>
@endsection
