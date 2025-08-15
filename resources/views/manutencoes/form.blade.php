<div class="mb-3">
    <label for="maquina_id" class="form-label">
        <i class="fas fa-tractor me-2"></i>Máquina
    </label>
    <select class="form-select" id="maquina_id" name="maquina_id" required>
        <option value="">Selecione uma máquina</option>
        @foreach($maquinas as $maquina)
            <option value="{{ $maquina->id }}" {{ old('maquina_id', $manutencao->maquina_id ?? '') == $maquina->id ? 'selected' : '' }}>
                {{ $maquina->nome }} ({{ $maquina->modelo }})
            </option>
        @endforeach
    </select>
    <div class="invalid-feedback"></div>
    <div class="form-text">Selecione a máquina que receberá a manutenção</div>
</div>

<div class="mb-3">
    <label for="descricao" class="form-label">
        <i class="fas fa-file-alt me-2"></i>Descrição
    </label>
    <textarea class="form-control" id="descricao" name="descricao" rows="4" placeholder="Descreva detalhadamente a manutenção realizada ou a ser realizada..." required>{{ old('descricao', $manutencao->descricao ?? '') }}</textarea>
    <div class="invalid-feedback"></div>
    <div class="form-text">Mínimo de 10 caracteres</div>
</div>

<div class="mb-3">
    <label for="tipo" class="form-label">
        <i class="fas fa-wrench me-2"></i>Tipo
    </label>
    <select class="form-select" id="tipo" name="tipo" required>
        <option value="">Selecione o tipo</option>
        <option value="preventiva" {{ old('tipo', $manutencao->tipo ?? '') == 'preventiva' ? 'selected' : '' }}>Preventiva</option>
        <option value="corretiva" {{ old('tipo', $manutencao->tipo ?? '') == 'corretiva' ? 'selected' : '' }}>Corretiva</option>
    </select>
    <div class="invalid-feedback"></div>
    <div class="form-text">Preventiva: manutenção programada | Corretiva: reparo de problema</div>
</div>

<div class="mb-3">
    <label for="custo" class="form-label">
        <i class="fas fa-dollar-sign me-2"></i>Custo (R$)
    </label>
    <input type="number" class="form-control" id="custo" name="custo" value="{{ old('custo', $manutencao->custo ?? '') }}" step="0.01" min="0" placeholder="0,00" required>
    <div class="invalid-feedback"></div>
    <div class="form-text">Valor total gasto com a manutenção</div>
</div>

<div class="mb-3">
    <label for="data_manutencao" class="form-label">
        <i class="fas fa-calendar me-2"></i>Data da Manutenção
    </label>
    <input type="date" class="form-control" id="data_manutencao" name="data_manutencao" value="{{ old('data_manutencao', $manutencao && $manutencao->data_manutencao ? $manutencao->data_manutencao->format('Y-m-d') : '') }}">
    <div class="invalid-feedback"></div>
    <div class="form-text">Data em que a manutenção foi ou será realizada</div>
</div>

<div class="mb-3">
    <label for="responsavel" class="form-label">
        <i class="fas fa-user me-2"></i>Responsável
    </label>
    <input type="text" class="form-control" id="responsavel" name="responsavel" value="{{ old('responsavel', $manutencao->responsavel ?? '') }}" placeholder="Nome do responsável pela manutenção">
    <div class="invalid-feedback"></div>
    <div class="form-text">Nome da pessoa ou empresa responsável pela manutenção</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const maquinaSelect = document.getElementById('maquina_id');
    const descricaoTextarea = document.getElementById('descricao');
    const tipoSelect = document.getElementById('tipo');
    const custoInput = document.getElementById('custo');
    const dataInput = document.getElementById('data_manutencao');
    const responsavelInput = document.getElementById('responsavel');

    // Validação da máquina
    function validateMaquina() {
        const value = maquinaSelect.value;
        if (value) {
            maquinaSelect.classList.remove('is-invalid');
            maquinaSelect.classList.add('is-valid');
            return true;
        } else {
            maquinaSelect.classList.remove('is-valid');
            maquinaSelect.classList.add('is-invalid');
            maquinaSelect.nextElementSibling.textContent = 'Por favor, selecione uma máquina.';
            return false;
        }
    }

    // Validação da descrição
    function validateDescricao() {
        const value = descricaoTextarea.value.trim();
        if (value.length >= 10) {
            descricaoTextarea.classList.remove('is-invalid');
            descricaoTextarea.classList.add('is-valid');
            return true;
        } else {
            descricaoTextarea.classList.remove('is-valid');
            descricaoTextarea.classList.add('is-invalid');
            descricaoTextarea.nextElementSibling.textContent = 'A descrição deve ter pelo menos 10 caracteres.';
            return false;
        }
    }

    // Validação do tipo
    function validateTipo() {
        const value = tipoSelect.value;
        if (value) {
            tipoSelect.classList.remove('is-invalid');
            tipoSelect.classList.add('is-valid');
            return true;
        } else {
            tipoSelect.classList.remove('is-valid');
            tipoSelect.classList.add('is-invalid');
            tipoSelect.nextElementSibling.textContent = 'Por favor, selecione o tipo de manutenção.';
            return false;
        }
    }

    // Validação do custo
    function validateCusto() {
        const value = parseFloat(custoInput.value);
        if (value >= 0) {
            custoInput.classList.remove('is-invalid');
            custoInput.classList.add('is-valid');
            return true;
        } else {
            custoInput.classList.remove('is-valid');
            custoInput.classList.add('is-invalid');
            custoInput.nextElementSibling.textContent = 'O custo deve ser um valor positivo.';
            return false;
        }
    }

    // Validação da data
    function validateData() {
        const value = dataInput.value;
        if (value) {
            const selectedDate = new Date(value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            // Permite datas passadas e futuras (manutenções programadas)
            dataInput.classList.remove('is-invalid');
            dataInput.classList.add('is-valid');
            return true;
        } else {
            // Data é opcional
            dataInput.classList.remove('is-invalid', 'is-valid');
            return true;
        }
    }

    // Validação do responsável
    function validateResponsavel() {
        const value = responsavelInput.value.trim();
        if (value.length >= 2 || value.length === 0) {
            responsavelInput.classList.remove('is-invalid');
            if (value.length > 0) {
                responsavelInput.classList.add('is-valid');
            }
            return true;
        } else {
            responsavelInput.classList.remove('is-valid');
            responsavelInput.classList.add('is-invalid');
            responsavelInput.nextElementSibling.textContent = 'O nome do responsável deve ter pelo menos 2 caracteres.';
            return false;
        }
    }

    // Event listeners
    maquinaSelect.addEventListener('change', validateMaquina);
    descricaoTextarea.addEventListener('input', validateDescricao);
    tipoSelect.addEventListener('change', validateTipo);
    custoInput.addEventListener('input', validateCusto);
    dataInput.addEventListener('change', validateData);
    responsavelInput.addEventListener('input', validateResponsavel);

    // Validação no submit
    if (form) {
        form.addEventListener('submit', function(e) {
            const isValid = validateMaquina() & validateDescricao() & validateTipo() & validateCusto() & validateData() & validateResponsavel();
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
});
</script>


