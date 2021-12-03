<?= $this->extend('layout') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="/css/user/profile.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="container">
    <div class="row">
        <div class="col-4 border border-dark border-1 d-flex flex-column align-items-center left">
            <img class="img-thumbnail mb-3" src="<?= $user['picture'] ?>" alt="profile" />
            <h1 class="mb-5 fw-bold"><?= explode(' ', trim($user['name']))[0] ?></h1>
            <ul class="menu d-flex flex-column align-self-start w-100">
                <li class="menu-item" aria-controls="akun">Akun</li>
                <li class="menu-item" aria-controls="keamanan">Keamanan</li>
                <li class="menu-item" aria-controls="course">Course</li>
                <li onclick="return window.location.href = '<?= base_url('/user/logout') ?>';" class="menu-item">Keluar
                </li>
            </ul>
        </div>
        <div class="col-8 border border-dark border-1 d-flex flex-column align-items-center p-0">
            <div class="public-profile">
                <h1 class="fw-bold">Public Profile</h1>
                <h5 class="fw-bold">Tambah Informasi Tentang Dirimu</h5>
            </div>
            <div id="dynamicPage" class="w-100 h-100">
                <div class="dynamic w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                    <h1 class="fw-bold">Hai <?= $user['name'] ?></h1>
                    <h3>Selamat Datang Di Akunmu</h3>
                </div>
                <div id="akun" class="dynamic w-100 h-100 d-flex flex-column align-items-center hide">
                    <form class="w-100 d-flex flex-column" action="<?= base_url('/user/edit/akun') ?>" method="post">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <input type="hidden" name="_method" value="PUT">
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">Name</label>
                            <input id="nameInput" type="text" class="form-control" name="name" value="<?= $user['name'] ?>" minlength="3" maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label for="phoneInput" class="form-label">No. HP</label>
                            <input id="phoneInput" type="number" class="form-control" name="phone" value="<?= $user['phone'] ?>" maxlength="14">
                        </div>
                        <div class="mb-3">
                            <label for="emailInput" class="form-label">Email</label>
                            <input id="emailInput" type="email" class="form-control" name="email" value="<?= $user['email'] ?>">
                        </div>
                        <button type="submit" class="btn btn-outline-primary submit align-self-end">Submit</button>
                    </form>
                </div>
                <div id="keamanan" class="dynamic w-100 h-100 d-flex flex-column align-items-center hide">
                    <form class="w-100 d-flex flex-column" action="<?= base_url('/user/edit/password') ?>" method="post">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <input type="hidden" name="_method" value="PUT">
                        <div class="mb-3">
                            <label for="oldPasswordInput" class="form-label">Sandi Lama</label>
                            <input id="oldPasswordInput" type="password" class="form-control" name="old_password" minlength="8" maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label for="passwordInput" class="form-label">Sandi Baru</label>
                            <input id="passwordInput" type="password" class="form-control" name="password" minlength="8" maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Konfirmasi Sandi</label>
                            <input id="confirmPassword" type="password" class="form-control" name="repeat_password" minlength="8" maxlength="255">
                        </div>
                        <button type="submit" class="btn btn-outline-primary submit align-self-end">Submit</button>
                    </form>
                </div>
                <?php if ($user['role'] === 'mentor') : ?>
                    <?php if (count($courses) < 1) : ?>
                        <div id="course" class="dynamic w-100 h-100 d-flex flex-column align-items-center justify-content-center hide">
                            <h2 class="fw-bold">Anda Belum Menambahkan Course</h2>
                        </div>
                    <?php else : ?>
                        <div id="course" class="dynamic w-100 h-100 d-flex flex-column align-items-center hide">
                            <div class="row">
                                <?php foreach ($courses as $course) : ?>
                                    <div class="col mb-5">
                                        <div class="card course shadow">
                                            <a href="<?= base_url('/course/' . $course['id']) ?>"><img src="<?= $course['thumbnail'] ?>" class="card-img-top course-img" alt="<?= $course['title'] ?>"></a>
                                            <div class="card-body">
                                                <p class="language">Bahasa Indonesia</p>
                                                <h4 class="card-title"><?= $course['title'] ?></h4>
                                                <p class="card-text"><?= $course['description'] ?></p>
                                                <div class="d-flex w-100 justify-content-between align-items-center">
                                                    <button class="btn-outline-primary btn daftar-belajar" onclick="window.location.href = '<?= base_url('/course/edit/' . $course['id']) ?>'">
                                                        Edit Course
                                                    </button>
                                                    <form action="<?= base_url('/course/delete/' . $course['id']) ?>" method="post">
                                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button class="btn btn-outline-danger hapus-course" type="submit" onclick="return confirm('Apakah anda yakin ingin menghapus course ini?')">
                                                            Hapus Course
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <?php if (count($registered) < 1) : ?>
                        <div id="course" class="dynamic w-100 h-100 d-flex flex-column align-items-center justify-content-center hide">
                            <h2 class="fw-bold">Anda Belum Mendaftarkan Course</h2>
                        </div>
                    <?php else : ?>
                        <div id="course" class="dynamic w-100 h-100 d-flex flex-column align-items-center hide">
                            <div class="row">
                                <?php foreach ($registered as $course) : ?>
                                    <div class="col mb-5">
                                        <div class="card course shadow">
                                            <img src="<?= $course['thumbnail'] ?>" class="card-img-top course-img" alt="<?= $course['title'] ?>">
                                            <div class="card-body">
                                                <p class="language">Bahasa Indonesia</p>
                                                <h4 class="card-title"><?= $course['title'] ?></h4>
                                                <p class="card-text"><?= $course['description'] ?></p>
                                                <a href="<?= base_url('/course/' . $course['courseId']) ?>" class="btn btn-outline-primary daftar-belajar">Belajar</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?= $this->include('footer') ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="/js/user/profile.js"></script>
<?= $this->endSection() ?>