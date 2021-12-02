<?= $this->extend('layout') ?>

<?= $this->section('style') ?>
<style>
    section {
        padding-top: 11.9375rem;
    }

    .subtitle {
        color: #737373;
        font-size: 14px;
    }

    .red-line {
        display: block;
        height: 7px;
        width: 11.5rem;
        background-color: #E74040;
    }

    .thumbnail {
        width: 20.65rem;
        height: 9.9rem;
    }

    .thumbnail:hover {
        cursor: pointer;
    }

    form {
        width: 44.1rem;
    }

    label {
        font-weight: bold;
    }

    input {
        border-radius: 25px !important;
        height: 5rem;
        background-color: #F0F0F0 !important;
    }

    input[type=text] {
        font-size: 1.5rem;
        font-weight: 500;
    }

    .btn-submit {
        border-radius: 37px !important;
        height: 2.7rem;
        width: 7.45rem;
        font-size: 0.7rem;
        font-weight: bold;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="d-flex flex-column align-items-center w-100">
    <h1 class="fw-bold">Perbaharui Course</h1>
    <p class="subtitle mb-2">Perbaharui Course Baru Anda</p>
    <span class="red-line"></span>
    <form class="d-flex flex-column align-items-center pt-5 w-50" action="<?= base_url('/course/edit/'.$course['id']) ?>"
          method="post" enctype="multipart/form-data">
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
        <input type="hidden" name="_method" value="PUT"/>
        <div class="mb-5 w-100 d-flex justify-content-center">
            <img id="imageThumbnail" class="thumbnail" src="<?= $course['thumbnail'] ?>" alt="thumbnail">
            <input id="thumbnailInput" type="file" name="thumbnail" accept="image/png, image/jpeg, image/jpeg" hidden>
        </div>
        <div class="mb-5 w-100">
            <label for="titleInput" class="form-label">Judul Course</label>
            <input name="title" type="text"
                   class="form-control <?= ($validation->hasError('title')) ? 'is-invalid' : '' ?>" id="titleInput"
                   minlength="3" maxlength="255" value="<?= $course['title']; ?>" required>
            <div class="invalid-feedback">
                <?= $validation->getError('title') ?>
            </div>
        </div>
        <div class="mb-5 w-100">
            <label for="descriptionInput" class="form-label">Deskripsi Course</label>
            <input name="description" type="text"
                   class="form-control <?= ($validation->hasError('description')) ? 'is-invalid' : '' ?>"
                   id="descriptionInput" value="<?= $course['description']; ?>">
            <div class="invalid-feedback">
                <?= $validation->getError('description') ?>
            </div>
        </div>
        <div class="mb-5 w-100">
            <label for="linkInput" class="form-label">Link Video Youtube</label>
            <input name="video" type="text"
                   class="form-control <?= ($validation->hasError('video')) ? 'is-invalid' : '' ?>" id="linkInput"
                   value="https://youtu.be/<?= $course['video']; ?>" required>
            <div class="invalid-feedback">
                <?= $validation->getError('video') ?>
            </div>
        </div>
        <button type="submit" class="btn-submit btn btn-outline-primary">Submit</button>
    </form>
</section>
<?= $this->include('footer') ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?php
$img_error = $validation->getError('thumbnail');
if ($img_error != null) echo "<script>alert('$img_error');</script>"
?>
<script>
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
</script>
<?= $this->endSection() ?>

