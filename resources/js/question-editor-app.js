import Alpine from 'alpinejs'
import './bootstrap';
import './question-editor';

import { createIcons, icons } from 'lucide';
import Quill from 'quill';

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});

window.Alpine = Alpine

Alpine.start()
