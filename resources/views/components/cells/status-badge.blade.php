@switch($value)
    @case('livre')
        <span class="badge bg-success">
            <i class="fas fa-check-circle me-1"></i>Livre
        </span>
        @break
    @case('em_servico')
        <span class="badge bg-warning text-dark">
            <i class="fas fa-clock me-1"></i>Em Serviço
        </span>
        @break
    @case('manutencao')
        <span class="badge bg-info">
            <i class="fas fa-wrench me-1"></i>Manutenção
        </span>
        @break
    @default
        <span class="badge bg-secondary">{{ ucfirst($value) }}</span>
@endswitch