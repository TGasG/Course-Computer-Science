const image = document.getElementById('imageThumbnail');
const fileInput = document.getElementById('thumbnailInput');

const inputHandler = (e) => {
    // Jika gak ada isinya jangan lakukan apa apa
    if (!e.target.value) return;

    // Ambil isi dari filenya
    const file = e.target.files[0];
    console.log(file);

    // Buat object reader buat nge baca file
    const reader = new FileReader();

    // Ketika file di load maka ganti src gambar jadi src file yang baru
    reader.onload = (e) => {
        image.src = e.target.result;
    };

    // Ini function ketika ada error
    reader.onerror = (e) => {
        console.log("Error : " + e.type);
    };

    // Ini buat jalanin function baca file
    reader.readAsDataURL(file);
}

image.addEventListener("click", () => {
    fileInput.click();
    fileInput.addEventListener("change", inputHandler);
});