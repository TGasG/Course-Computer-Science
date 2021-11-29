<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

use function PHPUnit\Framework\returnSelf;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if ($this->session->get('user') === null) {
            $_SESSION['error'] = 'Please login first';
            return redirect()->to(base_url('/user/login'));
        }

        $data = [
            'user' => $this->user
        ];

        return view('/user/profile', $data);
    }

    public function register()
    {
        // Redirect jika google sudah terautentikasi
        if ($this->session->get('user') !== null) return redirect()->to(base_url('/'));

        $data = [
            'validation' => \Config\Services::validation()
        ];

        return view('user/register', $data);
    }

    public function registerHandler()
    {
        // Validasi input
        if (!$this->validate([
            'name' => 'required|alpha_space|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[user.email]',
            'phone' => 'required|is_unique[user.phone]',
            'password' => 'required|min_length[8]',
            'repeat_password' => 'required|matches[password]|min_length[8]',
            'role' => 'required|regex_match[/(student|mentor)/]'
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to(base_url('/user/register'))->withInput()->with('validation', $validation);
        }

        // Hash Password
        $hashPassword = password_hash($this->request->getVar('password'), PASSWORD_ARGON2I);

        // Insert data
        $this->userModel->insert([
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phone'),
            'password' => $hashPassword,
            'role' => $this->request->getVar('role'),
        ]);

        // Set flashdata for login
        $_SESSION['registered'] = 'You\'re now registered you can login';
        $this->session->markAsFlashdata('registered');

        // Redirect to login
        return redirect()->to(base_url('/user/login'));
    }

    public function login()
    {
        // Redirect jika google sudah terautentikasi
        if ($this->session->get('user') !== null) return redirect()->to(base_url('/'));

        // Dapatkan flash message
        $data = [
            'registered' => $this->session->getFlashdata('registered'),
            'error' => $this->session->getFlashdata('error'),
        ];

        return view('user/login', $data);
    }

    public function loginHandler()
    {
        $user = $this->userModel->where('email', $this->request->getVar('email'))->first();

        // Jika user belom terdaftar
        if (!isset($user)) {
            $_SESSION['error'] = 'Email ' . $this->request->getVar('email') . ' not registered';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/user/login'))->withInput();
        }

        // Jika password salah
        $result = password_verify($this->request->getVar('password'), $user['password']);
        if (!$result) {
            $_SESSION['error'] = 'Password incorrect';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/user/login'))->withInput();
        }

        // Jangan biarkan password ikut terbawa ke session
        unset($user['password']);

        $this->session->set('user', $user);
        return redirect()->to(base_url('/'));
    }

    public function logout()
    {
        $this->session->remove('user');
        return redirect()->to(base_url('/'));
    }
}
