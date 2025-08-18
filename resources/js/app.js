import './bootstrap';
import './masks';
import Chart from 'chart.js/auto';

// Disponibilizar Chart globalmente
window.Chart = Chart;

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
