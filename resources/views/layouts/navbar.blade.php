<nav class="navbar navbar-expand-lg navbar-app shadow-sm bg-white">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-primary" href="{{route('home')}}">ChatApp</a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav align-items-center">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false" style="gap: 10px;">
                            <img src="{{asset($user->media ?'storage/'.$user->media->file_path:'storage/uploads/profiles/profile.jpg') }}"
                                 alt="Profile"
                                 class="rounded-circle border border-2 border-primary"
                                 style="width:40px; height:40px; object-fit: cover; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                            <span class="fw-semibold text-dark">{{ $user->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="userDropdown"
                            style="min-width: 200px;">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{route('profile.edit')}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-person me-2" viewBox="0 0 16 16">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        <path fill-rule="evenodd" d="M8 9a5 5 0 0 0-5 5v1h10v-1a5 5 0 0 0-5-5z"/>
                                    </svg>
                                    profile
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{route('logout')}}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-box-arrow-right me-2" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                  d="M10 12a.5.5 0 0 1-.5-.5v-1h-5a.5.5 0 0 1 0-1h5v-1a.5.5 0 0 1 1 0v3a.5.5 0 0 1-.5.5z"/>
                                            <path fill-rule="evenodd"
                                                  d="M4.146 8.354a.5.5 0 0 1 0-.708L6.793 5H1.5a.5.5 0 0 1 0-1h5.293L4.146 3.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0z"/>
                                        </svg>
                                        logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
