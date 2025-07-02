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
    <input type="text" class="form-control" id="tipo" name="tipo" value="{{ old('tipo', $maquina->tipo ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="ano" class="form-label">Ano</label>
    <input type="number" class="form-control" id="ano" name="ano" value="{{ old('ano', $maquina->ano ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select class="form-select" id="status" name="status" required>
        <option value="ativo" {{ old('status', $maquina->status ?? '') == 'ativo' ? 'selected' : '' }}>Ativo</option>
        <option value="manutencao" {{ old('status', $maquina->status ?? '') == 'manutencao' ? 'selected' : '' }}>Manutenção</option>
        <option value="inativo" {{ old('status', $maquina->status ?? '') == 'inativo' ? 'selected' : '' }}>Inativo</option>
    </select>
</div>

