const menus = document.querySelectorAll('.menu-item');
const displays = document.querySelectorAll('.dynamic');
console.log(displays);

menus.forEach((menu) => {
    menu.addEventListener('click', (e) => {
        // Highlight menu yang aktif
        menus.forEach((m) => m.classList.remove('active-menu'));
        e.target.classList.add('active-menu');

        // Atur atribut hidden untuk display
        displays.forEach((d) => d.classList.add('hide'));
        const control = e.target.getAttribute('aria-controls');
        if (control === 'akun') {
            document.getElementById('akun').classList.remove('hide');
        } else if (control === 'keamanan') {
            document.getElementById('keamanan').classList.remove('hide');
        } else if (control === 'course') {
            document.getElementById('course').classList.remove('hide');
        }
    });
});
