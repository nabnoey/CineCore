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
        --movie-card-bg: #2c2f33; /* Dark card background */
        --movie-card-hover: #3e4247; /* Slightly lighter dark on hover */
    }

    /* 2. Heading Style */
    .section-title {
        color: #ffffff; /* White title */
        font-weight: 700;
        border-bottom: 3px solid var(--movie-primary); /* Gold underline accent */
        padding-bottom: 10px;
    }

    /* 3. Category Cards */
    .category-card {
        background: var(--movie-card-bg);
        border: 1px solid #3c4044;
        transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
        text-decoration: none;
        color: var(--movie-primary) !important; /* Gold text for high visibility */
        font-size: 1.25rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }
    .category-card:hover {
        transform: translateY(-5px); /* Lift up more noticeably */
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5); /* Stronger shadow on hover */
        background: var(--movie-card-hover);
        color: #ffffff !important; /* White text on hover */
        border-color: var(--movie-primary);
    }
</style>

<div class="container my-5">
    <h2 class="mb-5 section-title">
        <i class="fas fa-folder-open me-2" style="color: var(--movie-primary);"></i> หมวดหมู่หนังทั้งหมด
    </h2>

    <div class="row g-4">
        @forelse ($categories as $category)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <a href="{{ route('categories.show', $category->id) }}" class="category-card d-block p-4 rounded-4 text-center fw-semibold">
                    {{ $category->name }}
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> ไม่พบหมวดหมู่ภาพยนตร์
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection