<nav class="navbar navbar-expand-lg" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border-bottom: 1px solid #e5e7eb; box-shadow: 0 4px 15px rgba(0,0,0,0.08); padding: 0.75rem 0;">
    <div class="container-fluid d-flex align-items-center justify-content-between px-4">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-link p-0" id="sidebarToggle" style="border: none; color: #667eea; font-size: 20px; transition: all 0.3s;">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand fw-700 m-0 d-flex align-items-center gap-2" href="{{ route('home') }}" style="font-size: 22px; letter-spacing: -0.5px;">
                <i class="fas fa-comments" style="color: #667eea; font-size: 24px;"></i>
                <span style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">RealTimeChat</span>
            </a>
        </div>

        <div>
            @auth
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false" style="gap: 12px; text-decoration: none; color: #1f2937;">
                        <img src="{{ $user->media ? $user->media->file_url : asset('storage/uploads/profiles/profile.jpg') }}"
                            alt="Profile" class="rounded-circle border-2"
                            style="width: 42px; height: 42px; object-fit: cover; border-color: #667eea; box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);">
                        <div class="text-start d-none d-sm-block">
                            <div style="font-weight: 600; font-size: 14px; color: #1f2937;">{{ $user->name }}</div>
                            <div style="font-size: 12px; color: #9ca3af;">Online</div>
                        </div>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown"
                        style="min-width: 220px; border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-top: 10px; overflow: hidden;">

                        <li style="padding: 12px 0; border-bottom: 1px solid #e5e7eb;">
                            <div class="px-4 d-flex align-items-center gap-3">
                                <img src="{{ $user->media ? $user->media->file_url : asset('storage/uploads/profiles/profile.jpg') }}"
                                    alt="Profile"
                                    style="width: 48px; height: 48px; object-fit: cover; border-radius: 50%; border: 2px solid #667eea;">
                                <div>
                                    <div style="font-weight: 600; font-size: 14px; color: #1f2937;">{{ $user->name }}</div>
                                    <div style="font-size: 13px; color: #9ca3af;">{{ $user->email }}</div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}"
                               style="padding: 12px 20px; color: #1f2937; font-size: 14px; font-weight: 500; transition: all 0.3s;">
                                <i class="fas fa-user-circle me-3" style="font-size: 16px; color: #667eea; width: 20px;"></i>
                                My Profile
                            </a>
                        </li>

                        <li style="border-top: 1px solid #e5e7eb;">
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center w-100"
                                        style="padding: 12px 20px; color: #ef4444; font-size: 14px; font-weight: 500; border: none; background: none; cursor: pointer; transition: all 0.3s;"
                                        onmouseover="this.style.backgroundColor='#fef2f2';" onmouseout="this.style.backgroundColor='transparent';">
                                    <i class="fas fa-sign-out-alt me-3" style="font-size: 16px; width: 20px;"></i>
                                    Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>
</nav>

<style>
    #sidebarToggle:hover {
        transform: scale(1.15);
    }

    .dropdown-item:hover {
        background-color: #f3f4f6;
    }
</style>

