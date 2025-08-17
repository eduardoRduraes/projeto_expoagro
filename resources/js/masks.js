// Máscaras de input para formulários

// Máscara para CPF
function applyCpfMask(input) {
    input.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length <= 11) {
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }
        
        e.target.value = value;
    });
}

// Máscara para telefone
function applyPhoneMask(input) {
    input.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length <= 11) {
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
            } else {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
            }
        }
        
        e.target.value = value;
    });
}

// Máscara para valores monetários
function applyMoneyMask(input) {
    input.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length > 0) {
            value = (parseInt(value) / 100).toFixed(2);
            value = value.replace('.', ',');
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            value = 'R$ ' + value;
        }
        
        e.target.value = value;
    });
}

// Máscara para horas (HH:MM)
function applyTimeMask(input) {
    input.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length <= 4) {
            value = value.replace(/(\d{2})(\d)/, '$1:$2');
        }
        
        e.target.value = value;
    });
}

// Máscara para horas decimais (ex: 8.5 horas)
function applyDecimalHoursMask(input) {
    input.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d.,]/g, '');
        
        // Permitir apenas um ponto ou vírgula
        const parts = value.split(/[.,]/);
        if (parts.length > 2) {
            value = parts[0] + '.' + parts[1];
        } else if (parts.length === 2) {
            value = parts[0] + '.' + parts[1].substring(0, 3); // Máximo 3 casas decimais
        }
        
        e.target.value = value;
    });
}

// Inicializar máscaras quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    // Aplicar máscara de CPF
    const cpfInputs = document.querySelectorAll('input[name="cpf"], input[data-mask="cpf"]');
    cpfInputs.forEach(input => applyCpfMask(input));
    
    // Aplicar máscara de telefone
    const phoneInputs = document.querySelectorAll('input[name="telefone"], input[data-mask="phone"]');
    phoneInputs.forEach(input => applyPhoneMask(input));
    
    // Aplicar máscara de dinheiro
    const moneyInputs = document.querySelectorAll('input[name="custo"], input[data-mask="money"]');
    moneyInputs.forEach(input => applyMoneyMask(input));
    
    // Aplicar máscara de tempo
    const timeInputs = document.querySelectorAll('input[name="hora_inicio"], input[name="hora_fim"], input[data-mask="time"]');
    timeInputs.forEach(input => applyTimeMask(input));
    
    // Aplicar máscara de horas decimais
    const decimalHoursInputs = document.querySelectorAll('input[name="total_horas"], input[name="horas_totais"], input[data-mask="decimal-hours"]');
    decimalHoursInputs.forEach(input => applyDecimalHoursMask(input));
});

// Exportar funções para uso global
window.applyCpfMask = applyCpfMask;
window.applyPhoneMask = applyPhoneMask;
window.applyMoneyMask = applyMoneyMask;
window.applyTimeMask = applyTimeMask;
window.applyDecimalHoursMask = applyDecimalHoursMask;