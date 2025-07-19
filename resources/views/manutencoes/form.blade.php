<div class="mb-3">
    <label for="maquina_id" class="form-label">Máquina</label>
    <select class="form-select" id="maquina_id" name="maquina_id" required>
        <option value="">Selecione uma máquina</option>
        @foreach($maquinas as $maquina)
            <option value="{{ $maquina->id }}" {{ old('maquina_id', $manutencao->maquina_id ?? '') == $maquina->id ? 'selected' : '' }}>
                {{ $maquina->nome }} ({{ $maquina->modelo }})
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="descricao" class="form-label">Descricao</label>
    <textarea class="form-control" id="descricao" name="descricao" value="{{ old('descricao', $manutencao->descricao ?? '') }}" required> </textarea>
</div>

<div class="mb-3">
    <label for="tipo" class="form-label">Tipo</label>
    <select class="form-select" id="tipo" name="tipo" required>
        <option value="preventiva" {{ old('tipo', $maquina->tipo ?? '') == 'preventiva' ? 'selected' : '' }}>Preventiva</option>
        <option value="corretiva" {{ old('tipo', $maquina->tipo ?? '') == 'corretiva' ? 'selected' : '' }}>Corretiva</option>
    </select>
</div>

<div class="mb-3">
    <label for="custo" class="form-label">Custo</label>
    <input type="number" class="form-control" id="custo" name="custo" value="{{ old('custo', $manutencao->custo ?? '') }}" required>
</div>


