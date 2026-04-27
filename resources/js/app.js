import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('darkMode', () => ({
        isDark: localStorage.getItem('theme') === 'light' ? false : true,
        toggleDark() {
            this.isDark = !this.isDark;
            localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
        }
    }));
});

Alpine.start();