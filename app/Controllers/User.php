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
            'validation' => \Config\Services::validation(),
            'from' => $this->session->getFlashdata('from'),
            'success_account' => $this->session->getFlashdata('success_account'),
            'success_keamanan' => $this->session->getFlashdata('success_keamanan'),
            'error_keamanan' => $this->session->getFlashdata('error_keamanan'),
        ];

        if ($user['role'] === 'mentor') {
            $data['courses'] = $this->courseModel->where('author', $user['id'])->findAll();
        } else {
            $data['registered'] = $this
                ->registerModel
                ->select(['register.id as registerId', 'c.id as courseId', 'c.title', 'c.description', 'c.thumbnail', 'c.video', 'u.name as author', 'register.createdAt as registerAt'])
                ->join('course c', 'course c on register.courseId = c.id')
                ->join('user u', 'c.author = u.id')
                ->where('register.studentId', $user['id'])
                ->orderBy('register.createdAt', 'DESC')
                ->findAll();

            $data['registered'] = array_map(function ($course) {
                $course['thumbnail'] = $course['thumbnail'] ?? '/img/thumbnail-placeholder.png';
                return $course;
            }, $data['registered']);
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

        $this->session->set('userId', $user['id']);
        return redirect()->to(base_url('/'));
    }

    public function logout()
    {
        $this->session->remove('userId');
        return redirect()->to(base_url('/'));
    }

    public function editAkun()
    {
        $user = $this->user;
        if ($user === null) return redirect()->to(base_url('/user/login'));

        // Siapkan validasi email
        $email_validation =
            $user['email'] === $this->request->getVar('email') ?
                'required|valid_email|max_length[255]' :
                'required|valid_email|is_unique[user.email]|max_length[255]';

        // Siapkan validasi phone
        $phone_validation =
            $user['phone'] === $this->request->getVar('phone') ?
                'required|max_length[14]' :
                'required|is_unique[user.phone]|max_length[14]';

        // Persiapkan validasi update akun
        $update_validation = $this->validate([
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
                'rules' => $email_validation,
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'valid_email' => '{field} harus berisi email yang valid.',
                    'is_unique' => '{field} sudah pernah terdaftar.',
                    'max_length' => '{field} maksimal berisi 255 karakter.',
                ],
            ],
            'phone' => [
                'rules' => $phone_validation,
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'is_unique' => '{field} sudah pernah terdaftar.',
                    'max_length' => '{field} maksimal berisi 14 karakter.',
                ],
            ],
        ]);

        // Validasi Update
        if (!$update_validation) {
            $_SESSION['from'] = 'akun';
            $this->session->markAsFlashdata('from');
            return redirect()->to(base_url('/user'))->withInput();
        }

        $this->userModel->save([
            'id' => $user['id'],
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phone'),
        ]);

        // Flash message berhasil
        $_SESSION['from'] = 'akun';
        $this->session->markAsFlashdata('from');
        $_SESSION['success_account'] = 'Akun berhasil diupdate.';
        $this->session->markAsFlashdata('success_account');

        return redirect()->to(base_url('/user'));
    }

    public function editPassword()
    {
        if ($this->user === null) return redirect()->to(base_url('/user/login'));
        $user = $this->userModel->find($this->user['id']);

        // Persiapkan validasi update password
        $update_validation = $this->validate([
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
        ]);

        // Validasi update password
        if (!$update_validation) {
            $_SESSION['from'] = 'keamanan';
            $this->session->markAsFlashdata('from');
            return redirect()->to(base_url('/user'))->withInput();
        }

        // Jika password salah
        $result = password_verify($this->request->getVar('old_password'), $user['password']);
        if (!$result) {
            $_SESSION['from'] = 'keamanan';
            $this->session->markAsFlashdata('from');
            $_SESSION['error_keamanan'] = 'Password salah';
            $this->session->markAsFlashdata('error_keamanan');
            return redirect()->to(base_url('/user'))->withInput();
        }

        // Hash Password
        $hashed_password = password_hash($this->request->getVar('password'), PASSWORD_ARGON2I);

        $this->userModel->save([
            'id' => $user['id'],
            'password' => $hashed_password,
        ]);

        // Flash message berhasil
        $_SESSION['from'] = 'keamanan';
        $this->session->markAsFlashdata('from');
        $_SESSION['success_keamanan'] = 'Password berhasil diupdate.';
        $this->session->markAsFlashdata('success_keamanan');

        return redirect()->to(base_url('/user'));
    }

    public function editPicture()
    {
        // TODO
    }
}
