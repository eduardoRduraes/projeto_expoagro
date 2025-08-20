@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dataInput = document.getElementById('data');
            const horaInicioInput = document.getElementById('hora_inicio');
            const horaFimInput = document.getElementById('hora_fim');
            const tarefaInput = document.getElementById('tarefa');

            // Validação de data
            if (dataInput) {
                dataInput.addEventListener('change', function () {
                    const selectedDate = new Date(this.value);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    
                    if (selectedDate <= today) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                    }
                });
            }

            // Validação de horários
            function validateTimes() {
                if (horaInicioInput && horaFimInput && horaInicioInput.value && horaFimInput.value) {
                    const inicio = horaInicioInput.value;
                    const fim = horaFimInput.value;
                    
                    if (fim > inicio) {
                        horaInicioInput.classList.remove('is-invalid');
                        horaInicioInput.classList.add('is-valid');
                        horaFimInput.classList.remove('is-invalid');
                        horaFimInput.classList.add('is-valid');
                    } else {
                        horaInicioInput.classList.add('is-invalid');
                        horaFimInput.classList.add('is-invalid');
                    }
                }
            }

            if (horaInicioInput) {
                horaInicioInput.addEventListener('change', validateTimes);
            }

            if (horaFimInput) {
                horaFimInput.addEventListener('change', validateTimes);
            }

            // Validação de tarefa
            if (tarefaInput) {
                tarefaInput.addEventListener('input', function () {
                    if (this.value.trim().length >= 5) {
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
    <label for="maquina_id" class="form-label">
        <i class="fas fa-tractor me-2"></i>Máquina
        <span class="text-danger">*</span>
    </label>
    <select class="form-select @error('maquina_id') is-invalid @enderror" 
            id="maquina_id" name="maquina_id" required>
        <option value="">Selecione uma máquina</option>
        @foreach($maquinas as $maquina)
            <option value="{{ $maquina->id }}" {{ old('maquina_id', $usomaquina->maquina_id ?? '') == $maquina->id ? 'selected' : '' }}>
                {{ $maquina->nome }} ({{ $maquina->modelo }})
            </option>
        @endforeach
    </select>
    @error('maquina_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">Selecione a máquina que será utilizada</div>
</div>

<div class="mb-3">
    <label for="operador_id" class="form-label">
        <i class="fas fa-user me-2"></i>Operador
        <span class="text-danger">*</span>
    </label>
    <select class="form-select @error('operador_id') is-invalid @enderror" 
            id="operador_id" name="operador_id" required>
        <option value="">Selecione um operador</option>
        @foreach($operadores as $operador)
            <option value="{{ $operador->id }}" {{ old('operador_id', $usomaquina->operador_id ?? '') == $operador->id ? 'selected' : '' }}>
                {{ $operador->nome }} (CPF: {{ $operador->cpf }})
            </option>
        @endforeach
    </select>
    @error('operador_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">Selecione o operador responsável</div>
</div>

<div class="mb-3">
    <label for="data" class="form-label">
        <i class="fas fa-calendar me-2"></i>Data de Uso
        <span class="text-danger">*</span>
    </label>
    <input type="date" class="form-control @error('data') is-invalid @enderror" 
           id="data" name="data" 
           value="{{ old('data', isset($usomaquina) && $usomaquina->data ? $usomaquina->data->format('Y-m-d') : '') }}" 
           max="{{ date('Y-m-d') }}" required>
    @error('data')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        <div class="invalid-feedback">Data não pode ser futura</div>
    @enderror
    <div class="form-text">Data em que a máquina foi utilizada</div>
</div>

<div class="mb-3">
    <label for="hora_inicio" class="form-label">
        <i class="fas fa-play me-2"></i>Hora de Início
        <span class="text-danger">*</span>
    </label>
    <input type="time" class="form-control @error('hora_inicio') is-invalid @enderror" 
           id="hora_inicio" name="hora_inicio" 
           value="{{ old('hora_inicio', $usomaquina->hora_inicio ?? '') }}" required>
    @error('hora_inicio')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        <div class="invalid-feedback">Hora de início deve ser anterior à hora de fim</div>
    @enderror
    <div class="form-text">Horário de início da operação</div>
</div>

<div class="mb-3">
    <label for="hora_fim" class="form-label">
        <i class="fas fa-stop me-2"></i>Hora de Fim
        <span class="text-danger">*</span>
    </label>
    <input type="time" class="form-control @error('hora_fim') is-invalid @enderror" 
           id="hora_fim" name="hora_fim" 
           value="{{ old('hora_fim', $usomaquina->hora_fim ?? '') }}" required>
    @error('hora_fim')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        <div class="invalid-feedback">Hora de fim deve ser posterior à hora de início</div>
    @enderror
    <div class="form-text">Horário de término da operação</div>
</div>

<div class="mb-3">
    <label for="tarefa" class="form-label">
        <i class="fas fa-tasks me-2"></i>Tarefa Executada
    </label>
    <textarea class="form-control @error('tarefa') is-invalid @enderror" 
              id="tarefa" name="tarefa" rows="3" 
              placeholder="Descreva a tarefa executada (ex: Aração do campo, Plantio de milho, etc.)">{{ old('tarefa', $usomaquina->tarefa ?? '') }}</textarea>
    @error('tarefa')
        <div class="invalid-feedback">{{ $message }}</div>
    @else
        <div class="invalid-feedback">Descrição deve ter pelo menos 5 caracteres</div>
    @enderror
    <div class="form-text">Descrição detalhada da atividade realizada</div>
</div>

<div class="mb-3">
    <label for="observacao" class="form-label">
        <i class="fas fa-sticky-note me-2"></i>Observações
    </label>
    <textarea class="form-control @error('observacao') is-invalid @enderror" 
              id="observacao" name="observacao" rows="3" 
              placeholder="Observações adicionais, problemas encontrados, etc. (opcional)">{{ old('observacao', $usomaquina->observacao ?? '') }}</textarea>
    @error('observacao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">Informações complementares sobre o uso da máquina</div>
</div>

<!-- Adicione este campo hidden antes do botão submit -->
<input type="hidden" name="total_horas" id="total_horas" value="{{ old('total_horas', $usomaquina->total_horas ?? '0') }}">

