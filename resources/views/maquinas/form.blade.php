<div class="mb-3">
    <label for="nome" class="form-label">Nome</label>
    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $maquina->nome ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="modelo" class="form-label">Modelo</label>
    <input type="text" class="form-control" id="modelo" name="modelo" value="{{ old('modelo', $maquina->modelo ?? '') }}">
</div>

<div class="mb-3">
    <label for="numero_serie" class="form-label">Número de Série</label>
    <input type="text" class="form-control" id="numero_serie" name="numero_serie" value="{{ old('numero_serie', $maquina->numero_serie ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="tipo" class="form-label">Tipo</label>
    <select class="form-select" id="tipo" name="tipo" required>
        <option value="emplemento" {{ old('tipo', $maquina->tipo ?? '') == 'emplemento' ? 'selected' : '' }}>Emplemento</option>
        <option value="caminhao" {{ old('tipo', $maquina->tipo ?? '') == 'caminhao' ? 'selected' : '' }}>Caminhão</option>
        <option value="carro" {{ old('tipo', $maquina->tipo ?? '') == 'carro' ? 'selected' : '' }}>Carro</option>
        <option value="trator" {{ old('tipo', $maquina->tipo ?? '') == 'trator' ? 'selected' : '' }}>Trator</option>
    </select>
</div>

<div class="mb-3">
    <label for="ano" class="form-label">Ano</label>
    <input type="number" class="form-control" id="ano" name="ano" value="{{ old('ano', $maquina->ano ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select class="form-select" id="status" name="status" {{ isset($maquina) ? 'disabled' : '' }} required>
        <option value="livre" {{ old('status', $maquina->status ?? '') == 'livre' ? 'selected' : '' }}>Livre</option>
        <option value="inativo" {{ old('status', $maquina->status ?? '') == 'inativo' ? 'selected' : '' }}>Inativo</option>
    </select>

    {{-- Campo hidden para manter o valor do status ao editar --}}
    @if(isset($maquina))
        <input type="hidden" name="status" value="{{ $maquina->status }}">
    @endif
</div>
