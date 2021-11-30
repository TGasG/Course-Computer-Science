<?= $this->extend('layout') ?>

<?= $this->section('style') ?>
    <link rel="stylesheet" href="/css/user/register.css">
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
                    <h1 class="text-center mb-5">Register</h1>
                    <img src="/img/login-graphic.svg" alt="register graphic">
                </div>
                <div class="col-6 form-container">
                    <form action="<?= base_url('/user/register') ?>"
                          method="post">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                        <div class="mb-3">
                            <label for="inputName" class="form-label"></label>
                            <input type="text"
                                   class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : '' ?>"
                                   id="inputName" name="name" value="<?= old('name'); ?>"
                                   minlength="3"
                                   maxlength="255"
                                   placeholder="Name"
                                   required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('name') ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label"></label>
                            <input type="email"
                                   class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>"
                                   id="inputEmail" name="email"
                                   value="<?= old('email'); ?>" maxlength="255" placeholder="Email Address" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('email') ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputPhone" class="form-label"></label>
                            <input type="number"
                                   class="form-control <?= ($validation->hasError('phone')) ? 'is-invalid' : '' ?>"
                                   id="inputPhone" name="phone"
                                   value="<?= old('phone'); ?>" maxlength="14" placeholder="Phone Number" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('phone') ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword" class="form-label"></label>
                            <input type="password"
                                   class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>"
                                   id="inputPassword" name="password"
                                   placeholder="Password" minlength="8" maxlength="255" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('password') ?>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label for="inputRepeatPassword" class="form-label"></label>
                            <input type="password"
                                   class="form-control <?= ($validation->hasError('repeat_password')) ? 'is-invalid' : '' ?>"
                                   id="inputRepeatPassword" name="repeat_password"
                                   placeholder="Confirm Password" minlength="8" maxlength="255" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('repeat_password') ?>
                            </div>
                        </div>
                        <div class="mb-5">
                            <select name="role"
                                    class="form-select <?= ($validation->hasError('role')) ? 'is-invalid' : '' ?>"
                                    aria-label="Pilih" required>
                                <option <?= old('role') === null ? 'selected' : '' ?> disabled>Pilih</option>
                                <option value="student" <?= old('role') === 'student' ? 'selected' : '' ?>>Student
                                </option>
                                <option value="mentor" <?= old('role') === 'mentor' ? 'selected' : '' ?>>Mentor</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('role') ?>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center text-12">
                            <button class="btn btn-light sign-up mb-5" type="submit">Sign Up</button>
                            <p class="text-center">By signing up, I agree to <strong>Terms & condition</strong> and
                                <strong>Privacy Policy</strong></p>
                            <p>Already have an account? <a class="text-decoration-none text-black fw-bold"
                                                           href="<?= base_url('/user/login') ?>">Login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?= $this->include('footer') ?>
<?= $this->endSection() ?>