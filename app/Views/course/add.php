<?= $this->extend('layout') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="/css/course/add-edit.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="d-flex flex-column align-items-center w-100">
    <h1 class="fw-bold">Tambah Course</h1>
    <p class="subtitle mb-2">Tambahkan Course Baru Anda</p>
    <span class="red-line"></span>
    <form class="d-flex flex-column align-items-center pt-5 w-50" action="<?= base_url('/course/add') ?>"
          method="post" enctype="multipart/form-data">
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
        <div class="mb-5 w-100 d-flex justify-content-center">
            <img id="imageThumbnail" class="thumbnail" src="/img/add-course.svg" alt="thumbnail">
            <input id="thumbnailInput" type="file" name="thumbnail" accept="image/png, image/jpeg, image/jpeg" hidden>
        </div>
        <div class="mb-5 w-100">
            <label for="titleInput" class="form-label">Judul Course</label>
            <input name="title" type="text"
                   class="form-control <?= ($validation->hasError('title')) ? 'is-invalid' : '' ?>" id="titleInput"
                   minlength="3" maxlength="255" value="<?= old('title'); ?>" required>
            <div class="invalid-feedback">
                <?= $validation->getError('title') ?>
            </div>
        </div>
        <div class="mb-5 w-100">
            <label for="descriptionInput" class="form-label">Deskripsi Course</label>
            <input name="description" type="text"
                   class="form-control <?= ($validation->hasError('description')) ? 'is-invalid' : '' ?>"
                   id="descriptionInput" value="<?= old('description'); ?>">
            <div class="invalid-feedback">
                <?= $validation->getError('description') ?>
            </div>
        </div>
        <div class="mb-5 w-100">
            <label for="linkInput" class="form-label">Link Video Youtube</label>
            <input name="video" type="text"
                   class="form-control <?= ($validation->hasError('video')) ? 'is-invalid' : '' ?>" id="linkInput"
                   value="<?= old('video'); ?>" required>
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
<script src="/js/course/add-edit.js"></script>
<?= $this->endSection() ?>

