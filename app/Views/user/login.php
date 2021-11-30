<?= $this->extend('layout') ?>

<?= $this->section('style') ?>
    <link rel="stylesheet" href="/css/user/login.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section>
        <svg class="vector" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#F0F0F0" fill-opacity="1"
                  d="M0,192L48,208C96,224,192,256,288,272C384,288,480,288,576,240C672,192,768,96,864,58.7C960,21,1056,43,1152,85.3C1248,128,1344,192,1392,224L1440,256L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
        </svg>
        <div class="container pt-5">
            <div class="row">
                <div class="col-6">
                    <h1 class="text-center mb-5">Login</h1>
                    <img src="/img/login-graphic.svg" alt="login graphic">
                </div>
                <div class="col-6 form-container">
                    <form action="<?= base_url('/user/login') ?>"
                          method="post">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $error ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($registered)) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= $registered ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label"></label>
                            <input type="email" class="form-control" id="inputEmail" name="email"
                                   placeholder="Email Address">
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword" class="form-label"></label>
                            <input type="password" class="form-control" id="inputPassword" name="password"
                                   placeholder="Password">
                        </div>
                        <div class="mb-5 d-flex flex-column">
                            <a href="<?= base_url('/user/forgot') ?>"
                               class="text-decoration-none align-self-end text-black">Forgot
                                Password?</a>
                        </div>
                        <div class="d-flex flex-column align-items-center text-12">
                            <button class="btn btn-light login mb-5" type="submit">Login</button>
                            <p>Do not have an account? <a href="<?= base_url('/user/register') ?>"
                                                          class="text-decoration-none text-black fw-bold">Register</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?= $this->include('footer') ?>
<?= $this->endSection() ?>