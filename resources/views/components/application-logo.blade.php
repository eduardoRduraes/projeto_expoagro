<svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <!-- Círculo de fundo -->
    <circle cx="100" cy="100" r="95" fill="#2563eb" stroke="#1d4ed8" stroke-width="3"/>
    
    <!-- Trator principal -->
    <g transform="translate(30, 60)">
        <!-- Corpo do trator -->
        <rect x="40" y="30" width="60" height="25" rx="5" fill="#059669"/>
        
        <!-- Cabine -->
        <rect x="70" y="15" width="25" height="20" rx="3" fill="#047857"/>
        
        <!-- Roda traseira grande -->
        <circle cx="85" cy="60" r="18" fill="#374151" stroke="#111827" stroke-width="2"/>
        <circle cx="85" cy="60" r="12" fill="#6b7280"/>
        <circle cx="85" cy="60" r="6" fill="#9ca3af"/>
        
        <!-- Roda dianteira pequena -->
        <circle cx="45" cy="60" r="12" fill="#374151" stroke="#111827" stroke-width="2"/>
        <circle cx="45" cy="60" r="8" fill="#6b7280"/>
        <circle cx="45" cy="60" r="4" fill="#9ca3af"/>
        
        <!-- Detalhes do trator -->
        <rect x="42" y="32" width="8" height="3" fill="#fbbf24"/>
        <rect x="88" y="32" width="8" height="3" fill="#fbbf24"/>
        
        <!-- Chaminé -->
        <rect x="92" y="10" width="3" height="8" fill="#374151"/>
    </g>
    
    <!-- Implemento agrícola (arado) -->
    <g transform="translate(120, 85)">
        <!-- Estrutura principal -->
        <rect x="0" y="10" width="40" height="8" rx="2" fill="#dc2626"/>
        
        <!-- Lâminas do arado -->
        <path d="M5 18 L15 35 L25 18 Z" fill="#991b1b"/>
        <path d="M15 18 L25 35 L35 18 Z" fill="#991b1b"/>
        
        <!-- Conexão -->
        <rect x="-5" y="12" width="8" height="4" fill="#374151"/>
    </g>
    
    <!-- Texto/Iniciais -->
    <text x="100" y="160" text-anchor="middle" font-family="Arial, sans-serif" font-size="16" font-weight="bold" fill="white">GIA</text>
    <text x="100" y="175" text-anchor="middle" font-family="Arial, sans-serif" font-size="8" fill="#e5e7eb">Gestor Implementos</text>
</svg>
