<?= $this->extend('layout') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="/css/course/course.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section>
    <div class="container">
        <div class="judulCourse">
            <h1><?= $course['title'] ?></h1>
            <svg width="548" height="7" viewBox="0 0 548 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0H548V7H0V0Z" fill="#E74040" />
            </svg>
            <iframe width="857" height="487" src="https://www.youtube.com/embed/<?= $course['video'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="deskripsiCourse">
            <h1><?= $course['title'] ?></h1>
            <h3><?= $course['description'] ?></h3>
        </div>
    </div>
</section>

<?= $this->include('footer') ?>
<?= $this->endSection() ?>