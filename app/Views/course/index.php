<?= $this->extend('layout') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="/css/course/index.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section>
    <h1 class="fw-bold">Course yang Tersedia</h1>
    <span class="line mb-5"></span>
    <div class="container">
        <div class="row">
            <?php foreach ($courses as $course) : ?>
                <div class="col mb-5">
                    <div class="card course shadow">
                        <img src="<?= $course['thumbnail'] ?>" class="card-img-top course-img"
                             alt="<?= $course['title'] ?>">
                        <div class="card-body">
                            <p class="language">Bahasa Indonesia</p>
                            <h4 class="card-title"><?= $course['title'] ?></h4>
                            <p class="card-text"><?= $course['description'] ?></p>
                            <?php if (isset($user)) : ?>
                                <?php if ($course['isRegistered']) : ?>
                                    <a href="<?= base_url('/course/' . $course['id']) ?>"
                                       class="btn btn-outline-primary daftar-belajar">Belajar</a>
                                <?php else : ?>
                                    <form action="<?= base_url('/register/new') ?>" method="post">
                                        <input type="hidden" name="courseId" value="<?= $course['id'] ?>">
                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                                        <button type="submit" id="daftar"
                                                class="btn btn-outline-primary daftar-belajar">Daftar
                                        </button>
                                    </form>
                                <?php endif ?>
                            <?php else : ?>
                                <a href="<?= base_url('/user/login') ?>" class="btn btn-outline-primary daftar-belajar">Daftar</a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?= $this->include('footer') ?>
<?= $this->endSection() ?>

