import Alpine from 'alpinejs'
import './bootstrap';
import './exam-attempt';

import { createIcons, icons } from 'lucide';

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});

window.Alpine = Alpine

Alpine.start()
