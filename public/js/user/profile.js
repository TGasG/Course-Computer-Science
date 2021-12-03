const menus = document.querySelectorAll('.menu-item');
const displays = document.querySelectorAll('.dynamic');
const profileSpan = document.getElementById("profileSpan");
const fileInput = document.getElementById("fileInput");

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

// Function ini buat nge handle ketika ada file yang di upload
const fileInputHandler = (e) => {
    // Jika gak ada isinya jangan lakukan apa apa
    if (!e.target.value) return;

    // Ambil isi dari filenya
    const file = e.target.files[0];
    console.log(file);

    // Buat object reader buat nge baca file
    const reader = new FileReader();

    // Ketika file di load maka ganti src gambar jadi src file yang baru
    reader.onload = (e) => {
        document.getElementById("profileImage").src = e.target.result;
    };

    // Ini function ketika ada error
    reader.onerror = (e) => {
        console.log("Error : " + e.type);
    };

    // Ini buat jalanin function baca file
    reader.readAsDataURL(file);
};

// Ini event ketika profile di pencet
// Ketika profile dipencet input file bakal ikutan kepencet
profileSpan.addEventListener("click", () => {
    fileInput.click();
    fileInput.addEventListener("change", fileInputHandler);
});
