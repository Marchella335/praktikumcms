<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-hospital me-2"></i>
            RS Cepat Sembuh
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('pasien.*') ? 'active' : '' }}" 
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-users me-1"></i>Pasien
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('pasien.index') }}">
                            <i class="fas fa-list me-2"></i>Daftar Pasien
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('pasien.create') }}">
                            <i class="fas fa-user-plus me-2"></i>Tambah Pasien
                        </a></li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('dokter.*') ? 'active' : '' }}" 
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-md me-1"></i>Dokter
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('dokter.index') }}">
                            <i class="fas fa-list me-2"></i>Daftar Dokter
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('dokter.create') }}">
                            <i class="fas fa-stethoscope me-2"></i>Tambah Dokter
                        </a></li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('staf.*') ? 'active' : '' }}" 
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-tie me-1"></i>Staf
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('staf.index') }}">
                            <i class="fas fa-list me-2"></i>Daftar Staf
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('staf.create') }}">
                            <i class="fas fa-user-plus me-2"></i>Tambah Staf
                        </a></li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('janji_temu.*') ? 'active' : '' }}" 
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-calendar-check me-1"></i>Janji Temu
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('janji_temu.index') }}">
                            <i class="fas fa-list me-2"></i>Daftar Janji Temu
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('janji_temu.create') }}">
                            <i class="fas fa-calendar-plus me-2"></i>Buat Janji Temu
                        </a></li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('rekam_medis.*') ? 'active' : '' }}" 
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-file-medical me-1"></i>Rekam Medis
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('rekam_medis.index') }}">
                            <i class="fas fa-list me-2"></i>Daftar Rekam Medis
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('rekam_medis.create') }}">
                            <i class="fas fa-file-medical-alt me-2"></i>Buat Rekam Medis
                        </a></li>
                    </ul>
                </li>
            </ul>
            
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i>Admin
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">
                            <i class="fas fa-user me-2"></i>Profile
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fas fa-cog me-2"></i>Settings
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>