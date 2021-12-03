<?= $this->extend('layout') ?>

<?= $this->section('style') ?>
    <link rel="stylesheet" href="/css/user/profile.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="modal fade" id="pictureModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Your Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column align-items-center justify-content-center">
                    <img id="profileImage" class="img-thumbnail mb-3" src="<?= $user['picture'] ?>" alt="profile">
                    <span id="profileSpan" class="layer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#FFFFFF"
                             class="bi bi-upload" viewBox="0 0 16 16">
                              <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                              <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                        </svg>
                    </span>
                </div>
                <div class="modal-footer">
                    <form action="<?= base_url('/user/edit/picture') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                        <input type="hidden" name="_method" value="PUT">
                        <input id="fileInput" type="file" name="picture" accept="image/jpg, image/jpeg, image/png"
                               hidden>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <section class="container">
        <div class="row">
            <div class="col-4 border border-dark border-1 d-flex flex-column align-items-center left">
                <button type="button" class="modal-button" data-bs-toggle="modal" data-bs-target="#pictureModal">
                    <span class="layer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#FFFFFF"
                             class="bi bi-upload" viewBox="0 0 16 16">
                              <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                              <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                        </svg>
                    </span>
                    <img class="img-thumbnail mb-3" src="<?= $user['picture'] ?>"
                         alt="profile"/>
                </button>
                <h1 class="mb-5 fw-bold"><?= explode(' ', trim($user['name']))[0] ?></h1>
                <ul class="menu d-flex flex-column align-self-start w-100">
                    <li class="menu-item <?= $from === 'akun' ? 'active-menu' : '' ?>" aria-controls="akun">Akun</li>
                    <li class="menu-item <?= $from === 'keamanan' ? 'active-menu' : '' ?>" aria-controls="keamanan">
                        Keamanan
                    </li>
                    <li class="menu-item <?= $from === 'course' ? 'active-menu' : '' ?>" aria-controls="course">Course
                    </li>
                    <li onclick="return window.location.href = '<?= base_url('/user/logout') ?>';" class="menu-item">
                        Keluar
                    </li>
                </ul>
            </div>
            <div class="col-8 border border-dark border-1 d-flex flex-column align-items-center p-0">
                <div class="public-profile">
                    <h1 class="fw-bold">Public Profile</h1>
                    <h5 class="fw-bold">Tambah Informasi Tentang Dirimu</h5>
                </div>
                <div id="dynamicPage" class="w-100 h-100">
                    <div class="dynamic w-100 h-100 d-flex flex-column align-items-center justify-content-center <?= $from === null ? '' : 'hide' ?>">
                        <h1 class="fw-bold">Hai <?= $user['name'] ?></h1>
                        <h3>Selamat Datang Di Akunmu</h3>
                    </div>
                    <div id="akun"
                         class="dynamic w-100 h-100 d-flex flex-column align-items-center <?= $from === 'akun' ? '' : 'hide' ?>">
                        <form class="w-100 d-flex flex-column" action="<?= base_url('/user/edit/akun') ?>"
                              method="post">
                            <?php if (isset($success_account)) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= $success_account ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                            <input type="hidden" name="_method" value="PUT">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Name</label>
                                <input id="nameInput" type="text"
                                       class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : '' ?>"
                                       name="name"
                                       value="<?= $user['name'] ?>" minlength="3" maxlength="255">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('name') ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="phoneInput" class="form-label">No. HP</label>
                                <input id="phoneInput" type="number"
                                       class="form-control <?= ($validation->hasError('phone')) ? 'is-invalid' : '' ?>"
                                       name="phone"
                                       value="<?= $user['phone'] ?>" maxlength="14">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('phone') ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="emailInput" class="form-label">Email</label>
                                <input id="emailInput" type="email"
                                       class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>"
                                       name="email"
                                       value="<?= $user['email'] ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('email') ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-primary submit align-self-end">Submit</button>
                        </form>
                    </div>
                    <div id="keamanan"
                         class="dynamic w-100 h-100 d-flex flex-column align-items-center <?= $from === 'keamanan' ? '' : 'hide' ?>">
                        <form class="w-100 d-flex flex-column" action="<?= base_url('/user/edit/password') ?>"
                              method="post">
                            <?php if (isset($success_keamanan)) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= $success_keamanan ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($error_keamanan)) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= $error_keamanan ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                            <input type="hidden" name="_method" value="PUT">
                            <div class="mb-3">
                                <label for="oldPasswordInput" class="form-label">Sandi Lama</label>
                                <input id="oldPasswordInput" type="password" class="form-control" name="old_password"
                                       minlength="8" maxlength="255">
                            </div>
                            <div class="mb-3">
                                <label for="passwordInput" class="form-label">Sandi Baru</label>
                                <input id="passwordInput" type="password"
                                       class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>"
                                       name="password"
                                       minlength="8" maxlength="255">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('password') ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Konfirmasi Sandi</label>
                                <input id="confirmPassword" type="password"
                                       class="form-control <?= ($validation->hasError('repeat_password')) ? 'is-invalid' : '' ?>"
                                       name="repeat_password"
                                       minlength="8" maxlength="255">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('repeat_password') ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-primary submit align-self-end">Submit</button>
                        </form>
                    </div>
                    <?php if ($user['role'] === 'mentor') : ?>
                        <?php if (count($courses) < 1) : ?>
                            <div id="course"
                                 class="dynamic w-100 h-100 d-flex flex-column align-items-center justify-content-center <?= $from === 'course' ? '' : 'hide' ?>">
                                <h2 class="fw-bold">Anda Belum Menambahkan Course</h2>
                            </div>
                        <?php else : ?>
                            <div id="course"
                                 class="dynamic w-100 h-100 d-flex flex-column align-items-center <?= $from === 'course' ? '' : 'hide' ?>">
                                <div class="row">
                                    <?php foreach ($courses as $course) : ?>
                                        <div class="col mb-5">
                                            <div class="card course shadow">
                                                <a href="<?= base_url('/course/' . $course['id']) ?>"><img
                                                            src="<?= $course['thumbnail'] ?>"
                                                            class="card-img-top course-img"
                                                            alt="<?= $course['title'] ?>"></a>
                                                <div class="card-body">
                                                    <p class="language">Bahasa Indonesia</p>
                                                    <h4 class="card-title"><?= $course['title'] ?></h4>
                                                    <p class="card-text"><?= $course['description'] ?></p>
                                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                                        <button class="btn-outline-primary btn daftar-belajar"
                                                                onclick="window.location.href = '<?= base_url('/course/edit/' . $course['id']) ?>'">
                                                            Edit Course
                                                        </button>
                                                        <form action="<?= base_url('/course/delete/' . $course['id']) ?>"
                                                              method="post">
                                                            <input type="hidden" name="<?= csrf_token() ?>"
                                                                   value="<?= csrf_hash() ?>"/>
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button class="btn btn-outline-danger hapus-course"
                                                                    type="submit"
                                                                    onclick="return confirm('Apakah anda yakin ingin menghapus course ini?')">
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
                            <div id="course"
                                 class="dynamic w-100 h-100 d-flex flex-column align-items-center justify-content-center <?= $from === 'course' ? '' : 'hide' ?>">
                                <h2 class="fw-bold">Anda Belum Mendaftarkan Course</h2>
                            </div>
                        <?php else : ?>
                            <div id="course"
                                 class="dynamic w-100 h-100 d-flex flex-column align-items-center <?= $from === 'course' ? '' : 'hide' ?>">
                                <div class="row">
                                    <?php foreach ($registered as $course) : ?>
                                        <div class="col mb-5">
                                            <div class="card course shadow">
                                                <img src="<?= $course['thumbnail'] ?>" class="card-img-top course-img"
                                                     alt="<?= $course['title'] ?>">
                                                <div class="card-body">
                                                    <p class="language">Bahasa Indonesia</p>
                                                    <h4 class="card-title"><?= $course['title'] ?></h4>
                                                    <p class="card-text"><?= $course['description'] ?></p>
                                                    <a href="<?= base_url('/course/' . $course['courseId']) ?>"
                                                       class="btn btn-outline-primary daftar-belajar">Belajar</a>
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
<?php
$picture_error = $validation->getError('picture');
if (isset($success_picture)) echo "<script>alert('$success_picture');</script>";
if ($picture_error !== '') echo "<script>alert('$picture_error');</script>";
?>
    <script src="/js/user/profile.js"></script>
<?= $this->endSection() ?>