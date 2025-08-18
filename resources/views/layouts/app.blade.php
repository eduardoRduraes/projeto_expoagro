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
                width: 220px; /* Reduzido de 280px para 220px */
            }
            
            .sidebar .nav-link {
                color: rgba(255,255,255,0.8);
                padding: 8px 16px; /* Reduzido de 12px 32px */
                margin: 2px 8px; /* Reduzido de 4px 12px */
                border-radius: 6px; /* Reduzido de 8px */
                transition: all 0.3s ease;
                display: block;
                width: 200px; /* Reduzido de 256px */
                box-sizing: border-box;
                text-decoration: none;
                font-size: 0.9rem; /* Fonte menor */
            }
            
            .sidebar .nav-link i {
                display: inline-block;
                width: 16px; /* Reduzido de 20px */
                margin-right: 8px; /* Reduzido de 12px */
                text-align: center;
                font-size: 0.9rem; /* Ícones menores */
            }
            
            .sidebar .nav-link:hover,
            .sidebar .nav-link.active {
                background: rgba(255,255,255,0.1);
                color: white;
            }
            
            /* Ajustar header da sidebar */
            .sidebar .p-4 {
                padding: 1rem !important; /* Reduzido */
            }
            
            .sidebar h4 {
                font-size: 1.1rem; /* Reduzido */
                margin-bottom: 0.25rem !important;
            }
            
            .sidebar small {
                font-size: 0.7rem; /* Menor */
            }
            
            /* Ajustar seção do usuário */
            .sidebar .p-3 {
                padding: 0.75rem !important;
            }
            
            .sidebar .bg-white.bg-opacity-20 {
                padding: 0.5rem !important;
            }
            
            .sidebar .fw-medium {
                font-size: 0.85rem;
            }
            
            .sidebar .text-white-50 {
                font-size: 0.7rem;
            }
            
            /* Ajustar botão de logout */
            .sidebar .btn-sm {
                padding: 0.375rem 0.75rem;
                font-size: 0.8rem;
            }
            
            /* Mobile adjustments */
            @media (max-width: 768px) {
                .sidebar {
                    position: fixed;
                    left: -220px; /* Ajustado */
                    width: 220px; /* Ajustado */
                    z-index: 1050;
                    transition: left 0.3s ease;
                    height: 100vh;
                    overflow-y: auto;
                }
                
                .sidebar.show {
                    left: 0;
                }
                
                .main-content {
                    margin: 0;
                    padding: 15px;
                    width: 100%;
                }
                
                .mobile-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0,0,0,0.5);
                    z-index: 1040;
                    opacity: 0;
                    visibility: hidden;
                    transition: all 0.3s ease;
                }
                
                .mobile-overlay.show {
                    opacity: 1;
                    visibility: visible;
                }
                
                .mobile-toggle {
                    position: fixed;
                    top: 15px;
                    left: 15px;
                    z-index: 1060;
                    background: var(--primary-color);
                    border: none;
                    color: white;
                    width: 40px; /* Reduzido de 45px */
                    height: 40px; /* Reduzido de 45px */
                    border-radius: 6px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                }
                
                .page-header {
                    padding-left: 60px; /* Ajustado */
                }
            }
            
            @media (max-width: 576px) {
                .main-content {
                    padding: 10px;
                }
                
                .page-header {
                    padding-left: 55px;
                    padding-right: 10px;
                }
            }
        </style>
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <!-- Mobile Toggle Button -->
        <button class="mobile-toggle d-md-none" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Mobile Overlay -->
        <div class="mobile-overlay" onclick="closeSidebar()"></div>
        
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
        
        <!-- Mobile Navigation Script -->
        <script>
            function toggleSidebar() {
                const sidebar = document.querySelector('.sidebar');
                const overlay = document.querySelector('.mobile-overlay');
                const toggleBtn = document.querySelector('.mobile-toggle i');
                
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                
                // Change icon
                if (sidebar.classList.contains('show')) {
                    toggleBtn.className = 'fas fa-times';
                } else {
                    toggleBtn.className = 'fas fa-bars';
                }
            }
            
            function closeSidebar() {
                const sidebar = document.querySelector('.sidebar');
                const overlay = document.querySelector('.mobile-overlay');
                const toggleBtn = document.querySelector('.mobile-toggle i');
                
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                toggleBtn.className = 'fas fa-bars';
            }
            
            // Close sidebar when clicking on nav links (mobile)
            document.addEventListener('DOMContentLoaded', function() {
                const navLinks = document.querySelectorAll('.sidebar .nav-link');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        if (window.innerWidth <= 768) {
                            closeSidebar();
                        }
                    });
                });
                
                // Close sidebar on window resize if desktop
                window.addEventListener('resize', function() {
                    if (window.innerWidth > 768) {
                        closeSidebar();
                    }
                });
            });
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        </script>
        
        @stack('scripts')
    </body>
</html>
