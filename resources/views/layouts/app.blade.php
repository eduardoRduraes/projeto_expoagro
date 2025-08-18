<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Gestor de Implementos Agrícolas') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Icons -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Custom Styles -->
        <style>
            :root {
                --primary-color: #2563eb;
                --primary-dark: #1d4ed8;
                --secondary-color: #64748b;
                --success-color: #059669;
                --warning-color: #d97706;
                --danger-color: #dc2626;
                --light-bg: #f8fafc;
                --dark-bg: #1e293b;
                --border-color: #e2e8f0;
            }
            
            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--light-bg);
                color: #334155;
            }
            
            .sidebar {
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
                min-height: 100vh;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            }
            
            .sidebar .nav-link {
                color: rgba(255,255,255,0.8);
                padding: 12px 32px;
                margin: 4px 12px;
                border-radius: 8px;
                transition: all 0.3s ease;
                display: block;
                width: 256px;
                box-sizing: border-box;
                text-decoration: none;
            }
            
            .sidebar .nav-link i {
                display: inline-block;
                width: 20px;
                margin-right: 12px;
                text-align: center;
            }
            
            .sidebar .nav-link:hover,
            .sidebar .nav-link.active {
                background: rgba(255,255,255,0.1);
                color: white;
            }
            
            .main-content {
                background: white;
                border-radius: 12px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                margin: 20px;
                padding: 30px;
            }
            
            .page-header {
                background: white;
                border-bottom: 1px solid var(--border-color);
                padding: 20px 0;
                margin-bottom: 30px;
            }
            
            .btn-primary {
                background: var(--primary-color);
                border-color: var(--primary-color);
                padding: 10px 20px;
                border-radius: 8px;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            
            .btn-primary:hover {
                background: var(--primary-dark);
                border-color: var(--primary-dark);
                box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            }
            
            .card {
                border: none;
                border-radius: 12px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                transition: all 0.3s ease;
            }
            
            .card:hover {
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            }
            
            .table {
                border-radius: 8px;
                overflow: hidden;
            }
            
            .table thead th {
                background: var(--light-bg);
                border: none;
                font-weight: 600;
                color: var(--secondary-color);
                padding: 16px;
            }
            
            .table tbody td {
                padding: 16px;
                border-color: var(--border-color);
                vertical-align: middle;
            }
            
            .badge {
                padding: 6px 12px;
                border-radius: 20px;
                font-weight: 500;
            }
            
            .form-control, .form-select {
                border: 1px solid var(--border-color);
                border-radius: 8px;
                padding: 12px 16px;
                transition: all 0.3s ease;
            }
            
            .form-control:focus, .form-select:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            }
            
            .alert {
                border: none;
                border-radius: 8px;
                padding: 16px 20px;
            }
            
            @media (max-width: 768px) {
                .sidebar {
                    position: fixed;
                    left: -250px;
                    width: 250px;
                    z-index: 1000;
                    transition: left 0.3s ease;
                }
                
                .sidebar.show {
                    left: 0;
                }
                
                .main-content {
                    margin: 10px;
                    padding: 20px;
                }
            }
        </style>
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="d-flex">
            @include('layouts.navigation')
            
            <div class="flex-grow-1">
                <!-- Page Header -->
                @isset($header)
                    <div class="page-header">
                        <div class="container-fluid px-4">
                            {{ $header }}
                        </div>
                    </div>
                @endisset
                
                <!-- Page Content -->
                <div class="main-content">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Erro de validação:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </div>
        </div>
        
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Custom Scripts -->
        <script>
            // Mobile sidebar toggle
            function toggleSidebar() {
                document.querySelector('.sidebar').classList.toggle('show');
            }
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        </script>
    </body>
</html>
