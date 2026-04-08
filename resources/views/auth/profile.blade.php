@extends('layouts.app')
@section('content')
    <div class="col-md-12 p-4" style="height: 90vh; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); overflow-y: auto;">

        <div style="max-width: 600px; margin: 0 auto;">
            <!-- Header -->
            <div style="margin-bottom: 30px;">
                <a href="{{ route('home') }}" style="color: #667eea; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-weight: 500; transition: all 0.3s;"
                   onmouseover="this.style.transform='translateX(-4px)';" onmouseout="this.style.transform='translateX(0)';">
                    <i class="fas fa-arrow-left"></i> Back to Chat
                </a>
            </div>

            <!-- Profile Card -->
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); border: 1px solid #e5e7eb;">

                <!-- Title -->
                <h2 style="margin: 0 0 30px 0; font-size: 24px; font-weight: 700; text-align: center; color: #1f2937;">
                    <i class="fas fa-user-cog me-2" style="color: #667eea;"></i>Profile Settings
                </h2>

                <form action="{{route('profile.update')}}" enctype="multipart/form-data" method="POST">
                    @method('PUT')
                    @csrf

                    <!-- Profile Image Section -->
                    <div style="text-align: center; margin-bottom: 40px;">
                        <div style="position: relative; display: inline-block; margin-bottom: 20px;">
                            <img id="profilePreview"
                                src="{{$user->media ? $user->media->file_url : asset('storage/uploads/profiles/profile.jpg')}}"
                                alt="Profile photo"
                                style="width: 140px; height: 140px; object-fit: cover; border-radius: 50%; border: 4px solid #667eea; box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); display: block;">

                            <!-- Edit Button -->
                            <label for="profileImage"
                                style="position: absolute; bottom: 0; right: 0; background: linear-gradient(135deg, #667eea, #764ba2); color: white; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3); transition: all 0.3s; border: 3px solid white;"
                                onmouseover="this.style.transform='scale(1.1)';" onmouseout="this.style.transform='scale(1)';">
                                <i class="fas fa-camera" style="font-size: 18px;"></i>
                            </label>

                            <input type="file"
                                id="profileImage"
                                style="display: none;"
                                accept="image/*"
                                name="image">
                        </div>
                        <p style="color: #9ca3af; font-size: 13px; margin: 12px 0 0 0;">Click the camera icon to upload a new photo</p>
                    </div>

                    <!-- Form Fields -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #1f2937; font-size: 14px; margin-bottom: 8px;">
                            <i class="fas fa-user me-2" style="color: #667eea;"></i>Full Name
                        </label>
                        <input type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter your name"
                            name="name"
                            value="{{$user->name}}"
                            style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;"
                            onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        @error('name')
                        <div style="color: #ef4444; font-size: 13px; margin-top: 6px; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-exclamation-circle"></i>{{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div style="margin-bottom: 30px;">
                        <label style="display: block; font-weight: 600; color: #1f2937; font-size: 14px; margin-bottom: 8px;">
                            <i class="fas fa-envelope me-2" style="color: #667eea;"></i>Email Address
                        </label>
                        <input type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Enter your email"
                            name="email"
                            value="{{$user->email}}"
                            style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;"
                            onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        @error('email')
                        <div style="color: #ef4444; font-size: 13px; margin-top: 6px; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-exclamation-circle"></i>{{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Password Section -->
                    <div style="background: #f9fafb; border: 2px dashed #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 30px;">
                        <p style="margin: 0 0 16px 0; font-weight: 600; color: #1f2937; font-size: 13px;">
                            <i class="fas fa-lock me-2" style="color: #667eea;"></i>Change Password (optional)
                        </p>

                        <div style="margin-bottom: 16px;">
                            <input type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="New Password"
                                name="password"
                                style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;"
                                onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                            @error('password')
                            <div style="color: #ef4444; font-size: 13px; margin-top: 6px; display: flex; align-items: center; gap: 6px;">
                                <i class="fas fa-exclamation-circle"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div>
                            <input type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="Confirm Password"
                                name="password_confirmation"
                                style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;"
                                onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                            @error('password_confirmation')
                            <div style="color: #ef4444; font-size: 13px; margin-top: 6px; display: flex; align-items: center; gap: 6px;">
                                <i class="fas fa-exclamation-circle"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Button -->
                    <button class="btn w-100" type="submit"
                        style="padding: 12px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; font-weight: 600; border-radius: 12px; font-size: 16px; cursor: pointer; transition: all 0.3s;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 25px rgba(102, 126, 234, 0.4)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <i class="fas fa-check-circle me-2"></i>Save Changes
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
