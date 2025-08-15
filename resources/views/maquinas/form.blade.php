@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nomeInput = document.getElementById('nome');
            const numeroSerieInput = document.getElementById('numero_serie');
            const anoInput = document.getElementById('ano');

            // Validação de nome
            if (nomeInput) {
                nomeInput.addEventListener('input', function () {
                    if (this.value.trim().length >= 2) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else if (this.value.length > 0) {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-valid', 'is-invalid');
                    }
                });
            }

            // Validação de número de série
            if (numeroSerieInput) {
                numeroSerieInput.addEventListener('input', function () {
                    if (this.value.trim().length >= 3) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else if (this.value.length > 0) {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-valid', 'is-invalid');
                    }
                });
            }

            // Validação de ano
            if (anoInput) {
                anoInput.addEventListener('input', function () {
                    const currentYear = new Date().getFullYear();
                    const year = parseInt(this.value);
                    
                    if (year >= 1900 && year <= currentYear + 1) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else if (this.value.length > 0) {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-valid', 'is-invalid');
                    }
                });
            }
        });
    </script>
@endpush

<div class="mb-3">
    <label for="nome" class="form-label">
        <i class="fas fa-tractor me-2"></i>Nome da Máquina
        <span class="text-danger">*</span>
    </label>
    <input type="text" class="form-control @error('nome') is-invalid @enderror" 
           id="nome" name="nome" 
           value="{{ old('nome', $maquina->nome ?? '') }}" 
           required placeholder="Digite o nome da máquina">
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        <div class="invalid-feedback">Nome deve ter pelo menos 2 caracteres</div>
    @enderror
    <div class="form-text">Nome identificador da máquina</div>
</div>

<div class="mb-3">
    <label for="modelo" class="form-label">
        <i class="fas fa-tag me-2"></i>Modelo
    </label>
    <input type="text" class="form-control @error('modelo') is-invalid @enderror" 
           id="modelo" name="modelo" 
           value="{{ old('modelo', $maquina->modelo ?? '') }}" 
           placeholder="Ex: John Deere 6110J">
    @error('modelo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">Modelo específico da máquina (opcional)</div>
</div>

<div class="mb-3">
    <label for="numero_serie" class="form-label">
        <i class="fas fa-barcode me-2"></i>Número de Série
        <span class="text-danger">*</span>
    </label>
    <input type="text" class="form-control @error('numero_serie') is-invalid @enderror" 
           id="numero_serie" name="numero_serie" 
           value="{{ old('numero_serie', $maquina->numero_serie ?? '') }}" 
           required placeholder="Digite o número de série">
    @error('numero_serie')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        <div class="invalid-feedback">Número de série deve ter pelo menos 3 caracteres</div>
    @enderror
    <div class="form-text">Número único de identificação da máquina</div>
</div>

<div class="mb-3">
    <label for="tipo" class="form-label">
        <i class="fas fa-cogs me-2"></i>Tipo de Máquina
        <span class="text-danger">*</span>
    </label>
    <select class="form-select @error('tipo') is-invalid @enderror" 
            id="tipo" name="tipo" required>
        <option value="">Selecione o tipo</option>
        <option value="implemento" {{ old('tipo', $maquina->tipo ?? '') == 'implemento' ? 'selected' : '' }}>
            <i class="fas fa-tools"></i> Implemento Agrícola
        </option>
        <option value="caminhao" {{ old('tipo', $maquina->tipo ?? '') == 'caminhao' ? 'selected' : '' }}>
            <i class="fas fa-truck"></i> Caminhão
        </option>
        <option value="carro" {{ old('tipo', $maquina->tipo ?? '') == 'carro' ? 'selected' : '' }}>
            <i class="fas fa-car"></i> Automóvel
        </option>
        <option value="trator" {{ old('tipo', $maquina->tipo ?? '') == 'trator' ? 'selected' : '' }}>
            <i class="fas fa-tractor"></i> Trator
        </option>
    </select>
    @error('tipo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">Categoria da máquina ou veículo</div>
</div>

<div class="mb-3">
    <label for="ano" class="form-label">
        <i class="fas fa-calendar-alt me-2"></i>Ano de Fabricação
        <span class="text-danger">*</span>
    </label>
    <input type="number" class="form-control @error('ano') is-invalid @enderror" 
           id="ano" name="ano" 
           value="{{ old('ano', $maquina->ano ?? '') }}" 
           required min="1900" max="{{ date('Y') + 1 }}" 
           placeholder="Ex: {{ date('Y') }}">
    @error('ano')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        <div class="invalid-feedback">Ano deve estar entre 1900 e {{ date('Y') + 1 }}</div>
    @enderror
    <div class="form-text">Ano de fabricação da máquina</div>
</div>

<div class="mb-3">
    <label for="status" class="form-label">
        <i class="fas fa-circle me-2"></i>Status da Máquina
        <span class="text-danger">*</span>
    </label>
    <select class="form-select @error('status') is-invalid @enderror" 
            id="status" name="status" 
            {{ isset($maquina) ? 'disabled' : '' }} required>
        <option value="">Selecione o status</option>
        <option value="livre" {{ old('status', $maquina->status ?? '') == 'livre' ? 'selected' : '' }}>
            <i class="fas fa-check-circle text-success"></i> Livre
        </option>
        <option value="inativo" {{ old('status', $maquina->status ?? '') == 'inativo' ? 'selected' : '' }}>
            <i class="fas fa-times-circle text-danger"></i> Inativo
        </option>
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(isset($maquina))
        <div class="form-text text-muted">
            <i class="fas fa-info-circle me-1"></i>
            Status não pode ser alterado durante a edição
        </div>
        <input type="hidden" name="status" value="{{ $maquina->status }}">
    @else
        <div class="form-text">Status atual da máquina no sistema</div>
    @endif
</div>
