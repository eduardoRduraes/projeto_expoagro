@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cpfInput = document.getElementById('cpf');
            const telefoneInput = document.getElementById('telefone');
            const nomeInput = document.getElementById('nome');

            // Máscara e validação de CPF
            if (cpfInput) {
                cpfInput.addEventListener('input', function () {
                    let value = this.value.replace(/\D/g, '').slice(0, 11);
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                    this.value = value;
                    
                    // Validação visual
                    const cpfClean = value.replace(/\D/g, '');
                    const feedback = this.parentElement.querySelector('.invalid-feedback');
                    
                    if (cpfClean.length === 11 && isValidCPF(cpfClean)) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                        if (feedback) feedback.style.display = 'none';
                    } else if (cpfClean.length > 0) {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                        if (feedback) feedback.style.display = 'block';
                    } else {
                        this.classList.remove('is-valid', 'is-invalid');
                        if (feedback) feedback.style.display = 'none';
                    }
                });
            }

            // Máscara de telefone
            if (telefoneInput) {
                telefoneInput.addEventListener('input', function () {
                    let value = this.value.replace(/\D/g, '').slice(0, 11);
                    value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
                    value = value.replace(/(\d{5})(\d)/, '$1-$2');
                    this.value = value;
                    
                    // Validação visual
                    const phoneClean = value.replace(/\D/g, '');
                    if (phoneClean.length >= 10) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else if (phoneClean.length > 0) {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-valid', 'is-invalid');
                    }
                });
            }

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

            // Função para validar CPF
            function isValidCPF(cpf) {
                if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;
                
                let sum = 0;
                for (let i = 0; i < 9; i++) {
                    sum += parseInt(cpf.charAt(i)) * (10 - i);
                }
                let remainder = (sum * 10) % 11;
                if (remainder === 10 || remainder === 11) remainder = 0;
                if (remainder !== parseInt(cpf.charAt(9))) return false;
                
                sum = 0;
                for (let i = 0; i < 10; i++) {
                    sum += parseInt(cpf.charAt(i)) * (11 - i);
                }
                remainder = (sum * 10) % 11;
                if (remainder === 10 || remainder === 11) remainder = 0;
                return remainder === parseInt(cpf.charAt(10));
            }
        });
    </script>
@endpush

<div class="mb-3">
    <label for="nome" class="form-label">
        <i class="fas fa-user me-2"></i>Nome Completo
        <span class="text-danger">*</span>
    </label>
    <input type="text" class="form-control @error('nome') is-invalid @enderror" 
           id="nome" name="nome" 
           value="{{ old('nome', $operador->nome ?? '') }}" 
           required placeholder="Digite o nome completo do operador">
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        <div class="invalid-feedback">Nome deve ter pelo menos 2 caracteres</div>
    @enderror
    <div class="form-text">Nome completo do operador</div>
</div>

@php
    $cpfValue = old('cpf', isset($operador->cpf) ? preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', preg_replace('/\D/', '', $operador->cpf)) : '');
@endphp

<div class="mb-3">
    <label for="cpf" class="form-label">
        <i class="fas fa-id-card me-2"></i>CPF
        <span class="text-danger">*</span>
    </label>
    <input type="text" class="form-control @error('cpf') is-invalid @enderror" 
           id="cpf" name="cpf" 
           value="{{ $cpfValue }}" 
           required placeholder="000.000.000-00">
    @error('cpf')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        <div class="invalid-feedback">CPF inválido</div>
    @enderror
    <div class="form-text">Documento de identificação único</div>
</div>

@php
    $telefoneValue = old('telefone', isset($operador->telefone) ? preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', preg_replace('/\D/', '', $operador->telefone)) : '');
@endphp

<div class="mb-3">
    <label for="telefone" class="form-label">
        <i class="fas fa-phone me-2"></i>Telefone
    </label>
    <input type="text" class="form-control @error('telefone') is-invalid @enderror" 
           id="telefone" name="telefone" 
           value="{{ $telefoneValue }}" 
           placeholder="(00) 00000-0000">
    @error('telefone')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        <div class="invalid-feedback">Telefone deve ter pelo menos 10 dígitos</div>
    @enderror
    <div class="form-text">Número de contato (opcional)</div>
</div>

<div class="mb-3">
    <label for="categoria_cnh" class="form-label">
        <i class="fas fa-id-badge me-2"></i>Categoria CNH
        <span class="text-danger">*</span>
    </label>
    <select class="form-select @error('categoria_cnh') is-invalid @enderror" 
            id="categoria_cnh" name="categoria_cnh" required>
        <option value="">Selecione a categoria</option>
        <option value="A" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'A' ? 'selected' : '' }}>A - Motocicletas</option>
        <option value="B" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'B' ? 'selected' : '' }}>B - Automóveis</option>
        <option value="AB" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'AB' ? 'selected' : '' }}>AB - Motocicletas e Automóveis</option>
        <option value="C" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'C' ? 'selected' : '' }}>C - Veículos de Carga</option>
        <option value="D" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'D' ? 'selected' : '' }}>D - Transporte de Passageiros</option>
        <option value="E" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'E' ? 'selected' : '' }}>E - Veículos Articulados</option>
    </select>
    @error('categoria_cnh')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">Categoria da Carteira Nacional de Habilitação</div>
</div>

<div class="mb-3">
    <label for="status" class="form-label">
        <i class="fas fa-circle me-2"></i>Status do Operador
        <span class="text-danger">*</span>
    </label>
    <select class="form-select @error('status') is-invalid @enderror" 
            id="status" name="status" 
            {{ isset($operador) ? 'disabled' : '' }} required>
        <option value="">Selecione o status</option>
        <option value="livre" {{ old('status', $operador->status ?? '') == 'livre' ? 'selected' : '' }}>
            <i class="fas fa-check-circle text-success"></i> Livre
        </option>
        <option value="em_servico" {{ old('status', $operador->status ?? '') == 'em_servico' ? 'selected' : '' }}>
            <i class="fas fa-clock text-warning"></i> Em Serviço
        </option>
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(isset($operador))
        <div class="form-text text-muted">
            <i class="fas fa-info-circle me-1"></i>
            Status não pode ser alterado durante a edição
        </div>
        <input type="hidden" name="status" value="{{ $operador->status }}">
    @else
        <div class="form-text">Status atual do operador no sistema</div>
    @endif
</div>
