<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'WorkHive') }} - HRMS</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <!-- Custom CSS -->
    <link href="/HR%20Management/public/css/custom.css" rel="stylesheet">
    
    <!-- Animation -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- FullCalendar -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --sidebar-width: 280px;
            --primary: #9A8C98;      /* Lilac Ash - Navbar & Primary Actions */
            --primary-dark: #4A4E69; /* Dusty Grape - Hover/Active */
            --secondary: #C9ADA7;    /* Almond Silk - Accents */
            --dark: #22223B;         /* Space Indigo - Text/Sidebar */
            --light: #F2E9E4;        /* Seashell - Backgrounds */
            
            /* RGB Values for Opacity Utilities */
            --primary-rgb: 154, 140, 152;
            --secondary-rgb: 201, 173, 167;
            --dark-rgb: 34, 34, 59;
            --success-rgb: 25, 135, 84; 
            --info-rgb: 13, 202, 240;
            --warning-rgb: 255, 193, 7;
            
            --font-display: 'Outfit', sans-serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
        }

        body { 
            font-family: var(--font-body); 
            background-color: var(--light);
            color: var(--dark);
            overflow-x: hidden;
            font-weight: 500;
        }
        
        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: var(--font-display);
            letter-spacing: -0.025em;
            font-weight: 700;
        }

        /* Fixed Background Image with Blur */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('img/bg.png') }}') no-repeat center center/cover;
            filter: blur(15px); /* Strong blur as requested */
            transform: scale(1.1); /* Prevent blurred edges */
            z-index: -1;
        }
        
        /* Sidebar & Layout Styles (Restored) */
        .sidebar {
            width: var(--sidebar-width, 280px);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--dark);
            z-index: 1000;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            white-space: nowrap;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateX(5px);
        }

        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            border-left: 3px solid #fff;
        }
        
        .sidebar-link i { width: 24px; margin-right: 12px; font-size: 1.1rem; flex-shrink: 0; }
        
        .main-content {
            margin-left: var(--sidebar-width, 280px);
            padding: 2rem;
            min-height: 100vh;
        }

        /* Responsive Sidebar */
        @media (max-width: 991.98px) {
            .sidebar { margin-left: -100%; }
            .sidebar.active { margin-left: 0; }
            .main-content { margin-left: 0; }
        }
        
        /* Navbar Links */
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            padding: 10px 20px !important;
            border-radius: 50px !important;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }
        
        .navbar-nav .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }
        
        /* Active State - Round Button Style */
        .navbar-nav .nav-link.active {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.25) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-weight: 700;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Glass Utilities Inline */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 16px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        }

        /* Bootstrap Overrides for Custom Palette */
        .text-primary { color: var(--primary) !important; }
        
        /* Fix for bg-opacity utilities */
        .bg-primary { 
            background-color: rgba(var(--primary-rgb), var(--bs-bg-opacity, 1)) !important; 
        }
        
        .bg-dark { 
            background-color: rgba(var(--dark-rgb), var(--bs-bg-opacity, 1)) !important; 
        }
        
        .btn-primary { 
            background-color: var(--primary); 
            border-color: var(--primary); 
        }
        .btn-primary:hover { 
            background-color: var(--primary-dark); 
            border-color: var(--primary-dark); 
        }
        
        .text-dark { color: var(--dark) !important; }
    </style>
</head>
<body>

    @auth
        <!-- Horizontal Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top glass-navbar border-bottom border-light border-opacity-10" style="background-color: rgba(154, 140, 152, 0.85) !important; backdrop-filter: blur(12px);">
            <div class="container-fluid">
                <!-- Brand -->
                <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                    <div class="bg-primary rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 35px; height: 35px;">
                        <i class="fas fa-cubes text-white"></i>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold" style="letter-spacing: -0.5px;">WorkHive</span>
                        @if(Auth::user()->role === 'admin')
                            <span class="badge bg-light text-dark rounded-pill px-2 small shadow-sm" style="font-size: 0.65rem; background: rgba(255,255,255,0.2) !important; color: #fff !important;">HR</span>
                        @endif
                    </div>
                </a>

                <!-- Mobile Toggle -->
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto gap-3 align-items-center mb-2 mb-lg-0"> <!-- Centered Links -->
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-chart-pie me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('admin.employees.*') ? 'active' : '' }}" href="{{ route('admin.employees.index') }}">
                                    <i class="fas fa-users me-1"></i> Employees
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('admin.announcements.*') ? 'active' : '' }}" href="{{ route('admin.announcements.index') }}">
                                    <i class="fas fa-bullhorn me-1"></i> Announcements
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('admin.attendance.*') ? 'active' : '' }}" href="{{ route('admin.attendance.index') }}">
                                    <i class="fas fa-clock me-1"></i> Attendance
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('admin.leaves.*') ? 'active' : '' }}" href="{{ route('admin.leaves.index') }}">
                                    <i class="fas fa-calendar-check me-1"></i> Leaves
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('admin.designations.*') ? 'active' : '' }}" href="{{ route('admin.designations.index') }}">
                                    <i class="fas fa-briefcase me-1"></i> Designations
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('admin.payroll.*') ? 'active' : '' }}" href="{{ route('admin.payroll.index') }}">
                                    <i class="fas fa-file-invoice-dollar me-1"></i> Payroll
                                </a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('calendar.index') ? 'active' : '' }}" href="{{ route('calendar.index') }}">
                                    <i class="fas fa-calendar-alt me-1"></i> Calendar
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('employee.dashboard') ? 'active' : '' }}" href="{{ route('employee.dashboard') }}">
                                    <i class="fas fa-home me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('employee.attendance.*') ? 'active' : '' }}" href="{{ route('employee.attendance.index') }}">
                                    <i class="fas fa-history me-1"></i> Attendance
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('employee.team.*') ? 'active' : '' }}" href="{{ route('employee.team.index') }}">
                                    <i class="fas fa-users me-1"></i> Team
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('employee.leaves.*') ? 'active' : '' }}" href="{{ route('employee.leaves.index') }}">
                                    <i class="fas fa-coffee me-1"></i> Leaves
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('employee.payroll.*') ? 'active' : '' }}" href="{{ route('employee.payroll.index') }}">
                                    <i class="fas fa-receipt me-1"></i> Payslips
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('employee.id-card') ? 'active' : '' }}" href="{{ route('employee.id-card') }}">
                                    <i class="fas fa-id-card me-1"></i> ID Card
                                </a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('calendar.index') ? 'active' : '' }}" href="{{ route('calendar.index') }}">
                                    <i class="fas fa-calendar-alt me-1"></i> Calendar
                                </a>
                            </li>
                        @endif
                    </ul>

                    <!-- User Menu -->
                    <div class="d-flex align-items-center gap-3">
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="avatar bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center me-2 text-white fw-bold shadow-sm" style="width: 32px; height: 32px; background: var(--primary);">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="d-none d-lg-block">
                                    <div class="small fw-bold">{{ Auth::user()->name }}</div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2" aria-labelledby="userDropdown">
                                <li>
                                    <div class="dropdown-header">
                                        {{ Auth::user()->email }}
                                        <div class="small text-muted">{{ ucfirst(Auth::user()->role) }}</div>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @if(Auth::user()->role === 'employee')
                                    <li><a class="dropdown-item" href="{{ route('employee.profile') }}"><i class="fas fa-user-circle me-2"></i> Profile</a></li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Sign Out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content (Adjusted margin) -->
        <main class="main-content" style="margin-left: 0; padding-top: 80px;">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show glass-card border-0 mb-4 animate__animated animate__fadeInDown" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show glass-card border-0 mb-4 animate__animated animate__fadeInDown" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
    
                @yield('content')
            </div>
        </main>
    @else
        <!-- Guest Content -->
        @yield('content')
    @endauth

    <!-- Page Preloader -->
    <div id="preloader" style="position: fixed; top:0; left:0; width: 100%; height: 100vh; background: #0f172a; z-index: 9999; display: flex; justify-content: center; align-items: center; transition: opacity 0.5s ease;">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            const loader = document.getElementById('preloader');
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500);
        });
    </script>
</body>
</html>