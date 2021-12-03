<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Course Computer Science</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/">Beranda</a>
                </li>
                <?php if (isset($user) && $user['role'] === 'mentor') : ?>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/course') ?>">Course</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($user)) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Riwayat
                        </a>
                        <?php if ($user['role'] === 'student') : ?>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <?php foreach ($user['registeredCourses'] as $course) : ?>
                                    <li class="history"><a class="dropdown-item px-2" href="<?= base_url('/course/' . $course['id']) ?>">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div><img class="history-img me-3" src="<?= $course['thumbnail'] ?>" alt="<?= $course['title'] ?>"></div>
                                                <p class="mb-0 h-100 text-wrap text-decoration-underline" style="font-weight: 600;">
                                                    Anda telah mendaftar di course <?= $course['title'] ?>
                                                </p>
                                            </div>
                                        </a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <?php foreach ($user['courses'] as $course) : ?>
                                    <li class="history"><a class="dropdown-item px-2" href="<?= base_url('/course/' . $course['id']) ?>">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div><img class="history-img me-3" src="<?= $course['thumbnail'] ?>" alt="<?= $course['title'] ?>"></div>
                                                <p class="mb-0 h-100 text-wrap text-decoration-underline" style="font-weight: 600;">
                                                    Anda menambahkan <?= $course['title'] ?>
                                                </p>
                                            </div>
                                        </a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Kontak
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li class="kontak">
                            <a class="dropdown-item" href="https://www.instagram.com/kevinleonardsg/">
                                <div class="d-flex align-items-center kontak-container">
                                    <img class="kontak-icon me-3" src="/img/instagram.svg" alt="instagram">
                                    <p class="mb-0">Instagram</p>
                                </div>
                            </a>
                        </li>
                        <li class="kontak">
                            <a class="dropdown-item" href="mailto:leonardk56.kl@gmail.com">
                                <div class="d-flex align-items-center kontak-container">
                                    <img class="kontak-icon me-3" src="/img/gmail.svg" alt="instagram">
                                    <p class="mb-0">Email</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php if (isset($user)) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= $user['picture'] ?>" alt="<?= $user['name'] ?>" class="profile-icon">
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="<?= base_url('/user') ?>">Akun</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('/user/logout') ?>">Keluar</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="btn btn-light" href="<?= base_url('/user/login') ?>">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>