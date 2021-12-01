<?= $this->extend('layout') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="/css/home.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (isset($user) && $user['role'] === 'mentor') : ?>
    <section>
        <h1>Mentor page</h1>
    </section>
<?php else : ?>
    <section>
        <div class="header">
            <div class="headerText">
                <h1>Temukan <span>COURSE</span> Pilihanmu!!</h1>
            </div>
            <div class="headerImage">
                <img src="/img/home-user.svg" alt="">
            </div>
        </div>
        <div class="testimoni">
            <div class="testiText">
                <svg width="68" height="68" viewBox="0 0 68 68" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="34" cy="34" r="34" fill="#0C0C0C" />
                    <path d="M26.9894 32.456C28.3974 33.032 29.4854 33.96 30.2534 35.24C31.0854 36.456 31.5014 37.928 31.5014 39.656C31.5014 41.96 30.7654 43.848 29.2934 45.32C27.8214 46.792 25.9974 47.528 23.8214 47.528C21.5174 47.528 19.6294 46.792 18.1574 45.32C16.6854 43.848 15.9494 41.96 15.9494 39.656C15.9494 38.504 16.0774 37.384 16.3334 36.296C16.6534 35.208 17.2294 33.576 18.0614 31.4L23.1494 17.768H30.8294L26.9894 32.456ZM47.3414 32.456C48.7494 33.032 49.8374 33.96 50.6054 35.24C51.4374 36.456 51.8534 37.928 51.8534 39.656C51.8534 41.96 51.1174 43.848 49.6454 45.32C48.1734 46.792 46.3494 47.528 44.1734 47.528C41.8694 47.528 39.9814 46.792 38.5094 45.32C37.0374 43.848 36.3014 41.96 36.3014 39.656C36.3014 38.504 36.4294 37.384 36.6854 36.296C37.0054 35.208 37.5814 33.576 38.4134 31.4L43.5014 17.768H51.1814L47.3414 32.456Z" fill="#F0F0F0" />
                </svg>
                <div class="titleTesti">
                    <h1>Apa Kata Para Alumni?</h1>
                    <div class="descTitle">
                        <p>Testimonial Para Alumni </p>
                        <svg width="9" height="16" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.180771 0.180771C0.237928 0.123469 0.305828 0.0780065 0.380583 0.0469869C0.455337 0.0159672 0.535477 0 0.616412 0C0.697347 0 0.777487 0.0159672 0.852241 0.0469869C0.926996 0.0780065 0.994896 0.123469 1.05205 0.180771L8.4358 7.56452C8.4931 7.62168 8.53857 7.68958 8.56959 7.76433C8.60061 7.83909 8.61657 7.91923 8.61657 8.00016C8.61657 8.0811 8.60061 8.16124 8.56959 8.23599C8.53857 8.31074 8.4931 8.37865 8.4358 8.4358L1.05205 15.8196C0.936514 15.9351 0.779809 16 0.616412 16C0.453015 16 0.29631 15.9351 0.180771 15.8196C0.0652316 15.704 0.000322157 15.5473 0.000322157 15.3839C0.000322157 15.2205 0.0652316 15.0638 0.180771 14.9483L7.13011 8.00016L0.180771 1.05205C0.123469 0.994896 0.078006 0.926996 0.0469863 0.852242C0.0159666 0.777487 0 0.697347 0 0.616412C0 0.535478 0.0159666 0.455338 0.0469863 0.380583C0.078006 0.305829 0.123469 0.237928 0.180771 0.180771Z" fill="#3A18C2" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="testiCard">
                <div class="cardContainer">
                    <div class="cardImage">
                        <img class="profile" src="/img/profile-testi.png" alt="profile">
                        <img class="stars" src="/img/stars.png" alt="profile">
                    </div>
                    <div class="cardText">
                        <p>Sangat Membantu untuk mengembangkan skill saya dalam bidang pemrograman web.</p>
                        <div class="profileName">
                            <h1>Regina Miles</h1>
                            <p>Front End Developer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rekomendasiKelas">
            <div class="titleRK">
                <h1>Rekomendasi Kelas</h1>
                <p>Kelas Pemrograman Web</p>
                <svg width="184" height="7" viewBox="0 0 184 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0H184V7H0V0Z" fill="#E74040" />
                </svg>
            </div>
            <div class="parentCard">
                <?php foreach ($courses as $course) : ?>
                    <div class="cardCourse">
                        <img class='thumbnail' src="<?= $course['thumbnail'] ?>" alt="pemrograman web">
                        <div class="cardCourseText">
                            <p>Bahasa Indonesia</p>
                            <h1><?= $course['title'] ?></h1>
                            <h3><?= $course['description'] ?></h3>
                            <?php if (isset($user)) : ?>
                                <?php if ($course['isRegistered']) : ?>
                                    <button id="daftar" onclick="window.location.href = '<?= base_url('/course/' . $course['id']) ?>'">
                                        Belajar
                                    </button>
                                <?php else : ?>
                                    <form action="<?= base_url('/register/new') ?>" method="post">
                                        <input type="hidden" name="studentId" value="<?= $user['id'] ?>">
                                        <input type="hidden" name="courseId" value="<?= $course['id'] ?>">
                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                        <button type="submit" id="daftar">Daftar</button>
                                    </form>
                                <?php endif ?>
                            <?php else : ?>
                                <button id="daftar" onclick="window.location.href = '<?= base_url('/user/login') ?>'">
                                    Daftar
                                </button>
                            <?php endif ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?= $this->include('footer') ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?php
if (isset($error)) echo "<script>alert('$error');</script>";
?>
<?= $this->endSection() ?>