import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('darkMode', () => ({
        isDark: localStorage.getItem('theme') !== 'light',

        init() {
            // Don't apply here — blocking script already handled it
            // Just keep state in sync
            this.isDark = document.documentElement.classList.contains('dark');
        },

        toggleDark() {
            this.isDark = !this.isDark;
            if (this.isDark) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }
    }));
});

Alpine.start();