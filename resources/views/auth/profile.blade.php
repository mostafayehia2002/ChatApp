@extends('layouts.app')
@section('content')
    <div class="col-md-12 p-4" style="height: 90vh; background-color: #f8f9fa;">

        <div class="card shadow-sm border-0 rounded-4 mx-auto" style="max-width: 600px;">
            <div class="card-body p-4">

                <h5 class="mb-4 fw-bold text-center">Profile Settings</h5>
                <form action="{{route('profile.update')}}"  enctype="multipart/form-data" method="POST">
                    @method('PUT')
                    @csrf
                <!-- Profile Image -->
                <div class="d-flex justify-content-center mb-4">
                    <div class="position-relative">

                        <img id="profilePreview"
                             src="{{asset($user->media?'storage/'.$user->media->file_path:'storage/uploads/profile/profile.jpg') }}"
                             alt="no profile photo"
                             class="rounded-circle border"
                             style="width:120px; height:120px; object-fit:cover;">

                        <!-- edit icon -->
                        <label for="profileImage"
                               class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                               style="width:35px; height:35px; cursor:pointer;">
                            <i class="fas fa-pen"></i>
                        </label>

                        <input type="file"
                               id="profileImage"
                               class="d-none"
                               accept="image/*"
                               name="image"
                        >
                    </div>
                </div>

                <!-- Form -->
                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter your name" name="name" value="{{$user->name}}">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" name="email" value="{{$user->email}}">
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <p class="text-muted mb-3" style="font-size: 14px;">Change Password (optional)</p>
                    <!-- Password -->
                    <div class="mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="New Password" name="password">
                        @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" name="password_confirmation">
                        @error('password_confirmation')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Button -->
                    <button class="btn btn-primary w-100 mt-2" type="submit">
                        Save Changes
                    </button>

                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        document.getElementById('profileImage').addEventListener('change', function (e) {
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById('profilePreview').src = e.target.result;
                }

                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
