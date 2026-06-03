import './bootstrap';
import './exam-attempt';
import './question-editor';
import Chart from 'chart.js/auto';

import { createIcons, icons } from 'lucide';
import Quill from 'quill';
import katex from 'katex';

window.Quill = Quill;
window.katex = katex;
window.Chart = Chart;

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});


