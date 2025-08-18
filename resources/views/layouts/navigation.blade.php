<!-- Modern Sidebar Navigation -->
<div class="sidebar d-flex flex-column" style="width: 220px;"> <!-- Reduzido de 280px -->
    <!-- Logo/Brand -->
    <div class="p-3 text-center border-bottom border-light border-opacity-25"> <!-- Reduzido padding -->
        <h4 class="text-white mb-0" style="font-size: 1.1rem;"> <!-- Fonte menor -->
            <i class="fas fa-tractor me-2" style="font-size: 1rem;"></i>
            Gestor Agrícola
        </h4>
        <small class="text-white-50" style="font-size: 0.7rem;">Sistema de Implementos</small>
    </div>
    
    <!-- Mobile Toggle Button -->
    <button class="btn btn-link text-white d-md-none position-absolute" 
            style="top: 10px; right: 10px; z-index: 1001; padding: 0.25rem;" 
            onclick="toggleSidebar()">
        <i class="fas fa-times" style="font-size: 0.9rem;"></i>
    </button>
    
    <!-- Navigation Menu -->
    <nav class="flex-grow-1 py-2"> <!-- Reduzido padding -->
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" 
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <!-- Máquinas -->
            <li class="nav-item">
                <a href="{{ route('maquinas.index') }}" 
                   class="nav-link {{ request()->routeIs('maquinas.*') ? 'active' : '' }}">
                    <i class="fas fa-cogs"></i>
                    <span>Máquinas</span>
                </a>
            </li>
            
            <!-- Operadores -->
            <li class="nav-item">
                <a href="{{ route('operadores.index') }}" 
                   class="nav-link {{ request()->routeIs('operadores.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Operadores</span>
                </a>
            </li>
            
            <!-- Uso de Máquinas -->
            <li class="nav-item">
                <a href="{{ route('usomaquinas.index') }}" 
                   class="nav-link {{ request()->routeIs('usomaquinas.*') ? 'active' : '' }}">
                    <i class="fas fa-clock"></i>
                    <span>Uso de Máquinas</span>
                </a>
            </li>
            
            <!-- Manutenções -->
            <li class="nav-item">
                <a href="{{ route('manutencoes.index') }}" 
                   class="nav-link {{ request()->routeIs('manutencoes.*') ? 'active' : '' }}">
                    <i class="fas fa-wrench"></i>
                    <span>Manutenções</span>
                </a>
            </li>
            
            <!-- Relatórios -->
            <li class="nav-item">
                <a href="{{ route('relatorios.index') }}" 
                   class="nav-link {{ request()->routeIs('relatorios.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Relatórios</span>
                </a>
            </li>
            
            <!-- Divider -->
            <li class="nav-item">
                <hr class="border-light border-opacity-25 mx-3 my-2"> <!-- Margem reduzida -->
            </li>
            
            <!-- Configurações -->
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}" 
                   class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i>
                    <span>Perfil</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- User Info & Logout -->
    <div class="p-2 border-top border-light border-opacity-25"> <!-- Padding reduzido -->
        <div class="d-flex align-items-center mb-2"> <!-- Margem reduzida -->
            <div class="bg-white bg-opacity-20 rounded-circle p-1 me-2"> <!-- Padding e margem reduzidos -->
                <i class="fas fa-user text-white" style="font-size: 0.8rem;"></i>
            </div>
            <div class="flex-grow-1">
                <div class="text-white fw-medium" style="font-size: 0.85rem;">{{ Auth::user()->name }}</div>
                <small class="text-white-50" style="font-size: 0.7rem;">{{ Auth::user()->email }}</small>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}" class="d-grid">
            @csrf
            <button type="submit" class="btn-modern btn-outline-light btn-sm" style="padding: 0.375rem 0.75rem; font-size: 0.8rem;">
                <i class="fas fa-sign-out-alt me-1" style="font-size: 0.75rem;"></i>
                Sair
            </button>
        </form>
    </div>
</div>

<!-- Mobile Overlay -->
<div class="d-md-none position-fixed w-100 h-100 bg-dark bg-opacity-50" 
     style="top: 0; left: 0; z-index: 999; display: none;" 
     id="sidebar-overlay" 
     onclick="toggleSidebar()"></div>

<!-- Mobile Menu Button -->
<button class="btn-modern btn-primary d-md-none position-fixed" 
        style="top: 15px; left: 15px; z-index: 1002; width: 40px; height: 40px; padding: 0.5rem;" 
        onclick="toggleSidebar()">
    <i class="fas fa-bars" style="font-size: 0.9rem;"></i>
</button>
