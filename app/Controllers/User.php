<?php

namespace App\Controllers;

class User extends BaseController
{
    public function index()
    {
        $user = $this->user;;

        if ($user === null) {
            $_SESSION['error'] = 'Please login first';
            return redirect()->to(base_url('/user/login'));
        }

        $data = [
            'user' => $user,
        ];

        if ($user['role'] === 'mentor') {
            $data['courses'] = $this->courseModel->where('author', $user['id'])->findAll();
        } else {
            $data['registered'] = $this
                ->registerModel
                ->select(['register.id as registerId', 'c.title', 'c.description', 'c.thumbnail', 'c.video', 'u.name as author', 'register.createdAt as registerAt'])
                ->join('course c', 'course c on register.courseId = c.id')
                ->join('user u', 'c.author = u.id')
                ->where('register.studentId', $user['id'])
                ->findAll();
        }

        return view('/user/profile', $data);
    }

    public function register()
    {
        // Redirect jika google sudah terautentikasi
        if ($this->user !== null) return redirect()->to(base_url('/'));

        $data = [
            'validation' => \Config\Services::validation()
        ];

        return view('user/register', $data);
    }

    public function registerHandler()
    {
        // Persiapkan validasi register
        $register_validation = $this->validate([
            'name' => [
                'rules' => 'required|alpha_space|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'alpha_space' => '{field} hanya dapat menggunakan karakter huruf dan spasi.',
                    'min_length' => '{field} harus berisi minimal 3 karakter.',
                    'max_length' => '{field} maksimal berisi 100 karakter.',
                ],
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[user.email]|max_length[255]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'valid_email' => '{field} harus berisi email yang valid.',
                    'is_unique' => '{field} sudah pernah terdaftar.',
                    'max_length' => '{field} maksimal berisi 255 karakter.',
                ],
            ],
            'phone' => [
                'rules' => 'required|is_unique[user.phone]|max_length[14]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'is_unique' => '{field} sudah pernah terdaftar.',
                    'max_length' => '{field} maksimal berisi 14 karakter.',
                ],
            ],
            'password' => [
                'rules' => 'required|min_length[8]|max_length[255]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'min_length' => '{field} harus berisi minimal 8 karakter.',
                    'max_length' => '{field} maksimal berisi 255 karakter.',
                ],
            ],
            'repeat_password' => [
                'rules' => 'required|matches[password]|min_length[8]|max_length[255]',
                'errors' => [
                    'required' => 'Confirm Password harus diisi.',
                    'matches' => 'Confirm Password tidak sama dengan Password',
                    'min_length' => 'Confirm Password harus berisi minimal 8 karakter.',
                    'max_length' => 'Confirm Password maksimal berisi 255 karakter.',
                ]
            ],
            'role' => [
                'rules' => 'required|regex_match[/(student|mentor)/]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'regex_match' => '{field} harus bernilai student atau mentor',
                ]
            ]
        ]);

        // Validasi input
        if (!$register_validation) return redirect()->to(base_url('/user/register'))->withInput();

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
        $_SESSION['registered'] = 'Kamu sudah terdaftar silahkan login';
        $this->session->markAsFlashdata('registered');

        // Redirect to login
        return redirect()->to(base_url('/user/login'));
    }

    public function login()
    {
        // Redirect jika google sudah terautentikasi
        if ($this->user !== null) return redirect()->to(base_url('/'));

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
            $_SESSION['error'] = 'Email ' . $this->request->getVar('email') . ' tidak terdaftar';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/user/login'))->withInput();
        }

        // Jika password salah
        $result = password_verify($this->request->getVar('password'), $user['password']);
        if (!$result) {
            $_SESSION['error'] = 'Password salah';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/user/login'))->withInput();
        }

        // Berika placeholder untuk user yang tidak memiliki profile picture
        $user['picture'] = $user['picture'] === null ? '/img/profile-placeholder.png' : $user['picture'];

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
