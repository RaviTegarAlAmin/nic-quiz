import './bootstrap';
import './exam-attempt';
import './question-editor';

import { createIcons, icons } from 'lucide';
import Quill from 'quill';
import katex from 'katex';

window.Quill = Quill;
window.katex = katex;

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});


