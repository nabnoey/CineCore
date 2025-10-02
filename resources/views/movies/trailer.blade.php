@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-outline-secondary mb-3">&larr; กลับไปหน้ารายละเอียด</a>
            <h1 class="mb-3">{{ $movie->title }} - ตัวอย่างหนัง</h1>

            @if($youtubeId)
                <div class="ratio ratio-16x9">
                    <iframe
                        src="https://www.youtube.com/embed/{{ $youtubeId }}?autoplay=1&rel=0&modestbranding=1"
                        title="YouTube video player for {{ $movie->title }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            @else
                <div class="alert alert-warning" role="alert">
                    ขออภัย, ไม่พบตัวอย่างหนังสำหรับเรื่องนี้ หรือ URL ไม่ถูกต้อง
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
