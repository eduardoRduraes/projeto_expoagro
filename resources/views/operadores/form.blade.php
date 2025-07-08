<div class="mb-3">
    <label for="nome" class="form-label">Nome</label>
    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $operador->nome ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="cpf" class="form-label">CPF</label>
    <input type="text" class="form-control" id="cpf" name="cpf" value="{{ old('cpf', $operador->cpf ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="telefone" class="form-label">Telefone</label>
    <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $operador->telefone ?? '') }}">
</div>

<div class="mb-3">
    <label for="categoria_cnh" class="form-label">Status</label>
    <select class="form-select" id="categoria_cnh" name="categoria_cnh" required>
        <option value="A" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'livre' ? 'selected' : '' }}>A</option>
        <option value="B" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'em_servico' ? 'selected' : '' }}>B</option>
        <option value="AB" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'em_servico' ? 'selected' : '' }}>AB</option>
        <option value="C" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'em_servico' ? 'selected' : '' }}>C</option>
        <option value="D" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'em_servico' ? 'selected' : '' }}>D</option>
        <option value="E" {{ old('categoria_cnh', $operador->categoria_cnh ?? '') == 'em_servico' ? 'selected' : '' }}>E</option>
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
