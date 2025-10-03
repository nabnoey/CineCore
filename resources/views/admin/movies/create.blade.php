@extends('layouts.app')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<style>
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #444;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .poster-preview {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 8px;
        background-color: #343a40;
        display: none; /* Hidden by default */
    }
</style>
@endpush

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-dark text-white p-4">
                <div class="card-header bg-transparent border-0 text-center">
                    <h2 class="card-title mb-0">เพิ่มรายการภาพยนต์</h2>
                    <p class="text-white-50">กรอกรายละเอียดเพื่อเพิ่มภาพยนต์ใหม่</p>
                </div>
                <div class="card-body">
                    
                    <form method="POST" action="{{ route('admin.movies.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" id="title" name="title" class="form-control bg-secondary text-white" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" name="description" class="form-control bg-secondary text-white" rows="5" required></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="trailer_url" class="form-label">Teaser URL</label>
                                        <input type="text" id="trailer_url" name="trailer_url" class="form-control bg-secondary text-white">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="release_date" class="form-label">Release Date</label>
                                        <input type="date" id="release_date" name="release_date" class="form-control bg-secondary text-white" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="categories" class="form-label">Categories</label>
                                    <select class="form-select" id="categories" name="categories[]" multiple>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="poster_image_url" class="form-label">Poster URL</label>
                                    <input type="text" id="poster_image_url" name="poster_image_url" class="form-control bg-secondary text-white" required>
                                </div>
                                <img id="poster-preview" src="#" alt="Poster Preview" class="poster-preview mt-2"/>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Save Movie</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#categories').select2({
            placeholder: "Select categories",
            theme: "bootstrap-5",
            allowClear: true
        });

        // Poster preview
        $('#poster_image_url').on('input', function() {
            let url = $(this).val();
            if (url) {
                $('#poster-preview').attr('src', url).show();
            } else {
                $('#poster-preview').hide();
            }
        });
    });
</script>
@endpush
