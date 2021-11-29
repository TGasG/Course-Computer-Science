<?= $this->extend('layout') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="/css/user/register.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="register_body">
    <svg class="vector" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#F0F0F0" fill-opacity="1" d="M0,192L48,208C96,224,192,256,288,272C384,288,480,288,576,240C672,192,768,96,864,58.7C960,21,1056,43,1152,85.3C1248,128,1344,192,1392,224L1440,256L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
    </svg>
    <div class="register_isi">
        <div class="register_gambar">
            <h1>Register</h1>
            <img src="/img/login-graphic.svg" alt="register vector">
        </div>
        <form class="register_form" action="<?= base_url('/user/register') ?>" method="POST">
            <input type="text" name="name" placeholder="Name" class="<?= ($validation->hasError('name')) ? 'is-invalid' : '' ?>" value="<?= old('name'); ?>" required>
            <div class="invalid-feedback">
                <?= $validation->getError('name') ?>
            </div>
            <input type="email" name="email" placeholder="Email Address" class="<?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" value="<?= old('email'); ?>" required>
            <div class="invalid-feedback">
                <?= $validation->getError('email') ?>
            </div>
            <input type="number" name="phone" placeholder="Phone Number" class="<?= ($validation->hasError('phone')) ? 'is-invalid' : '' ?>" value="<?= old('phone'); ?>" required>
            <div class="invalid-feedback">
                <?= $validation->getError('phone') ?>
            </div>
            <input type="password" name="password" placeholder="Password" class="<?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" minlength="8" required>
            <div class="invalid-feedback">
                <?= $validation->getError('password') ?>
            </div>
            <input type="password" name="repeat_password" placeholder="Confirm Password" class="<?= ($validation->hasError('repeat_password')) ? 'is-invalid' : '' ?>" minlength="8" required>
            <div class="invalid-feedback">
                <?= $validation->getError('repeat_password') ?>
            </div>
            <select id="role" name="role" required>
                <option disabled selected>Pilih</option>
                <option value="student">Student</option>
                <option value="mentor">Mentor</option>
            </select>
            <button type="submit">Sign Up</button><br>
            <p>By signing up, I agree to <b>Terms & condition</b> and <b>Privacy Policy</b></p>
            <p>Already have an account? <a href="<?= base_url('/user/login') ?>">Login</a></p>
        </form>
    </div>
</section>
<div class="footer">
    <p><span></span></p>

    <div class="footer-text">
        <p> &copy;2021 Course Computer Science All rights reserved</p>
        <div class="logo-footer">
            <a>
                <img src="/img/instagram-icon.svg" alt="instagramlogo">
            </a>
            <a>
                <img src="/img/email-icon.svg" alt="email-logo">
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>