@extends('layouts.app')

@section('content')
<style>
    .profile-card {
        background: linear-gradient(145deg, #2e3238, #212529);
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        transition: transform 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-5px);
    }

    .profile-card .card-header {
        background-color: transparent;
        border-bottom: 1px solid #444;
        font-weight: bold;
        color: #ffc107; /* Gold accent color */
    }

    #profile-image-container {
        cursor: pointer;
        position: relative;
        width: 160px;
        height: 160px;
        margin: 20px auto;
        border-radius: 50%;
        overflow: hidden;
        border: 5px solid #ffc107;
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.2);
        transition: transform 0.3s ease;
    }

    #profile-image-container:hover {
        transform: scale(1.05);
    }

    #profile-image-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    #profile-image-container .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 50%;
        font-size: 1rem;
    }

    #profile-image-container:hover .overlay {
        opacity: 1;
    }
    
    #profile-image-container .overlay i {
        font-size: 2rem;
        margin-bottom: 5px;
    }

    .form-control {
        background-color: #2c2f33;
        border: 1px solid #444;
        color: #e8e6e3;
        border-radius: 8px;
    }

    .form-control:focus {
        background-color: #33373c;
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
        color: #e8e6e3;
    }

    .btn-save-profile {
        background-color: #ffc107;
        color: #181a1b;
        font-weight: bold;
        border: none;
        border-radius: 50px;
        padding: 12px 30px;
        transition: all 0.3s ease;
    }

    .btn-save-profile:hover {
        background-color: #e0a800;
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
        transform: translateY(-3px);
    }
</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card profile-card text-white">
                <div class="card-header text-center h4">{{ __('แก้ไขโปรไฟล์') }}</div>

                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="text-center mb-4">
                            <div id="profile-image-container" onclick="document.getElementById('profile_image').click();">
                                <img id="profile-image-preview" 
                                     src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/160' }}" 
                                     alt="Profile Image">
                                <div class="overlay">
                                    <i class="fas fa-camera"></i>
                                    <span>เปลี่ยนรูป</span>
                                </div>
                            </div>
                            <input id="profile_image" type="file" class="d-none" name="profile_image">
                            @error('profile_image')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4 align-items-center">
                            <label for="name" class="col-md-3 col-form-label text-md-end">{{ __('ชื่อ') }}</label>
                            <div class="col-md-7">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-7 offset-md-3">
                                <button type="submit" class="btn btn-save-profile">
                                    {{ __('บันทึกการเปลี่ยนแปลง') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const profileImageInput = document.getElementById('profile_image');
    const profileImagePreview = document.getElementById('profile-image-preview');

    profileImageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profileImagePreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
@endsection