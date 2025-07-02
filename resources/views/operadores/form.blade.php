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
    <label for="cnh" class="form-label">CNH</label>
    <input type="text" class="form-control" id="cnh" name="cnh" value="{{ old('cnh', $operador->cnh ?? '') }}">
</div>
