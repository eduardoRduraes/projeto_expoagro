@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cpfInput = document.getElementById('cpf');
            const telefoneInput = document.getElementById('telefone');

            if (cpfInput) {
                cpfInput.addEventListener('input', function () {
                    let value = this.value.replace(/\D/g, '').slice(0, 11);
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                    this.value = value;
                });
            }

            if (telefoneInput) {
                telefoneInput.addEventListener('input', function () {
                    let value = this.value.replace(/\D/g, '').slice(0, 11);
                    value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
                    value = value.replace(/(\d{5})(\d)/, '$1-$2');
                    this.value = value;
                });
            }
        });
    </script>
@endpush

<div class="mb-3">
    <label for="nome" class="form-label">Nome</label>
    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $operador->nome ?? '') }}" required>
</div>

@php
    $cpfValue = old('cpf', isset($operador->cpf) ? preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', preg_replace('/\D/', '', $operador->cpf)) : '');
@endphp

<div class="mb-3">
    <label for="cpf" class="form-label">CPF</label>
    <input type="text" class="form-control" id="cpf" name="cpf" value="{{ $cpfValue }}" required>
</div>

@php
    $telefoneValue = old('telefone', isset($operador->telefone) ? preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', preg_replace('/\D/', '', $operador->telefone)) : '');
@endphp

<div class="mb-3">
    <label for="telefone" class="form-label">Telefone</label>
    <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $telefoneValue }}">
</div>

<div class="mb-3">
    <label for="categoria_cnh" class="form-label">Status</label>
    <select class="form-select" id="categoria_cnh" name="categoria_cnh" required>
        <option value="A" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'A' ? 'selected' : '' }}>A</option>
        <option value="B" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'B' ? 'selected' : '' }}>B</option>
        <option value="AB" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'AB' ? 'selected' : '' }}>AB</option>
        <option value="C" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'C' ? 'selected' : '' }}>C</option>
        <option value="D" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'D' ? 'selected' : '' }}>D</option>
        <option value="E" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'E' ? 'selected' : '' }}>E</option>
    </select>
</div>

<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select class="form-select" id="status" name="status" {{ isset($operador) ? 'disabled' : '' }} required>
        <option value="livre" {{ old('status', $operador->status ?? '') == 'livre' ? 'selected' : '' }}>Livre</option>
        <option value="em_servico" {{ old('status', $operador->status ?? '') == 'em_servico' ? 'selected' : '' }}>Em Serviço</option>
    </select>

    {{-- Campo hidden para manter o valor do status ao editar --}}
    @if(isset($operador))
        <input type="hidden" name="status" value="{{ $operador->status }}">
    @endif
</div>
