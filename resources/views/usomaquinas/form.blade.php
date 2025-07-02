<div class="mb-3">
    <label for="maquina_id" class="form-label">Máquina</label>
    <select class="form-select" id="maquina_id" name="maquina_id" required>
        <option value="">Selecione uma máquina</option>
        @foreach($maquinas as $maquina)
            <option value="{{ $maquina->id }}" {{ old('maquina_id', $usomaquina->maquina_id ?? '') == $maquina->id ? 'selected' : '' }}>
                {{ $maquina->nome }} ({{ $maquina->modelo }})
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="operador_id" class="form-label">Operador</label>
    <select class="form-select" id="operador_id" name="operador_id" required>
        <option value="">Selecione um operador</option>
        @foreach($operadores as $operador)
            <option value="{{ $operador->id }}" {{ old('operador_id', $usomaquina->operador_id ?? '') == $operador->id ? 'selected' : '' }}>
                {{ $operador->nome }} (CPF: {{ $operador->cpf }})
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="data" class="form-label">Data</label>
    <input type="date" class="form-control" id="data" name="data" value="{{ old('data', $usomaquina->data ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="hora_inicio" class="form-label">Hora de Início</label>
    <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" value="{{ old('hora_inicio', $usomaquina->hora_inicio ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="hora_fim" class="form-label">Hora de Fim</label>
    <input type="time" class="form-control" id="hora_fim" name="hora_fim" value="{{ old('hora_fim', $usomaquina->hora_fim ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="tarefa" class="form-label">Tarefa Executada</label>
    <textarea class="form-control" id="tarefa" name="tarefa">{{ old('tarefa', $usomaquina->tarefa ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="observacao" class="form-label">Observacao</label>
    <textarea class="form-control" id="observacao" name="observacao">{{ old('observacao', $usomaquina->observacao ?? '') }}</textarea>
</div>

