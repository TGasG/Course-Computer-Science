<?= $this->extend('layout') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="/css/user/login.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section>
    <svg class="vector" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#F0F0F0" fill-opacity="1" d="M0,192L48,208C96,224,192,256,288,272C384,288,480,288,576,240C672,192,768,96,864,58.7C960,21,1056,43,1152,85.3C1248,128,1344,192,1392,224L1440,256L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
    </svg>

    <div class="login">
        <div class="login-left">
            <h1>Login</h1>
            <img src="/img/login-graphic.svg" alt="" />
        </div>
        <div class="login-right">
            <form class="form-login d-flex flex-column align-items-center" action="<?= base_url('/user/login') ?>" method="POST">
                <?php if (isset($registered)) : ?>
                    <div class="alert alert-success alert-dismissible fade show mx-3 w-100" role="alert">
                        <?= $registered ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger alert-dismissible fade show mx-3 w-100" role="alert">
                        <?= $error ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="form-email mb-5">
                    <input type="email" placeholder="Email Addres" name="email" />
                </div>
                <div class="form-pass mb-3">
                    <input type="password" placeholder="Password" name="password" />
                </div>
                <div class="forgot align-self-end">
                    <p>Forgot Password?</p>
                </div>
                <div class="btn-login">
                    <button type="submit">Login</button>
                </div>
                <div class="regis">
                    <p>Do not have an account? <a href="<?= base_url('/user/register') ?>">Register</a></p>
                </div>
            </form>
        </div>
    </div>
    <div class="footer">
        <p><span></span></p>

        <div class="footer-text">
            <p>&copy;2021 Course Computer Science All rights reserved</p>
            <div class="logo-footer">
                <a>
                    <img src="/img/instagram-icon.svg" alt="instagramlogo" />
                </a>
                <a>
                    <img src="/img/email-icon.svg" alt="email-logo" />
                </a>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>