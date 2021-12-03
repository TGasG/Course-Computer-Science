<?php

namespace App\Controllers;

class Course extends BaseController
{
    public function index()
    {
        $user = $this->user;

        // Jika user adalah mentor
        if ($user !== null && $user['role'] === 'mentor') {
            $_SESSION['error'] = 'Anda adalah mentor.';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/'));
        }

        $courses = $this->courseModel->select(['id', 'title', 'description', 'thumbnail'])->orderBy('createdAt', 'DESC')->findAll();
        $courses = array_map(function ($course) {
            $course['thumbnail'] = $course['thumbnail'] ?? '/img/thumbnail-placeholder.png';
            return $course;
        }, $courses);

        $data = [
            'user' => $user,
            'courses' => $courses,
        ];

        if ($user !== null) {
            $registeredCourses = $this->registerModel->where('studentId', $user['id'])->findColumn('courseId') ?? [];

            $data['courses'] = array_map(function ($course) use ($registeredCourses) {
                $course['isRegistered'] = !(array_search($course['id'], $registeredCourses) === false);
                return $course;
            }, $data['courses']);
        }

        return view('course/index', $data);
    }

    public function courseView($id)
    {
        $user = $this->user;

        if ($this->user === null) return redirect()->to(base_url('/user/login'));
        $id = (int)$id;

        $course = $this->courseModel->select(['title', 'author', 'description', 'video',])->find($id);
        if ($course === null) return view('/errors/html/error_404');

        // Jika mentor bukan pemilik video
        if ($user !== null && $user['role'] === 'mentor' && $user['id'] !== $course['author']) {
            $_SESSION['error'] = 'Anda bukan pemilik course ini.';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/'));
        }

        $data = [
            'user' => $user,
            'course' => $course,
        ];

        return view('course/course', $data);
    }

    public function add()
    {
        $user = $this->user;

        // Redirect jika user belum login
        if ($user === null) return redirect()->to(base_url('/user/login'));

        // Redirect jika user bukan mentor
        if ($user['role'] !== 'mentor') {
            $_SESSION['error'] = 'Hanya mentor yang dapat menambahkan course.';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/'));
        }

        $data = [
            'user' => $user,
            'validation' => \Config\Services::validation(),
        ];

        return view('course/add', $data);
    }

    public function addCourse()
    {
        $user = $this->user;

        // Redirect jika user belum login
        if ($user === null) return redirect()->to(base_url('/user/login'));

        // Redirect jika user bukan mentor
        if ($user['role'] !== 'mentor') {
            $_SESSION['error'] = 'Hanya mentor yang dapat menambahkan course.';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/'));
        }

        // Siapkan validasi
        $add_course_validation = $this->validate([
            'title' => [
                'rules' => 'required|alpha_numeric_punct|is_unique[course.title]|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'alpha_numeric_punct' => '{field} hanya dapat menggunakan karakter berupa huruf, angka, dan punctuation characters.',
                    'is_unique' => '{field} sudah ada',
                    'min_length' => '{field} harus berisi minimal 3 karakter.',
                    'max_length' => '{field} maksimal berisi 100 karakter.',
                ],
            ],
            'thumbnail' => [
                'rules' => 'max_size[thumbnail,10240]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran maksimal {field} 10mb',
                    'is_image' => '{field} yang anda pilih bukan gambar',
                    'mime_in' => '{field} yang anda pilih bukan gambar',
                ],
            ],
            'video' => [
                'rules' => 'required|regex_match[/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'regex_match' => 'Bukan URL youtube yang valid',
                ],
            ]
        ]);

        // Validasi input
        if (!$add_course_validation) return redirect()->to(base_url('/course/add'))->withInput();

        // Dapatkan ID video dari link
        $result = preg_match("/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/", $this->request->getVar('video'), $matches);
        if (!$result) {
            $_SESSION['error'] = 'Terjadi Kesalahan.';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/'));
        }
        $video_id = $matches[1];

        // Siapkan template insert
        $model_template = [
            'title' => $this->request->getVar('title'),
            'author' => $user['id'],
            'description' => $this->request->getVar('description'),
            'video' => $video_id,
        ];

        // Ambil file
        $thumbnail_file = $this->request->getFile('thumbnail');

        // Jika user memasukkan thumbnail
        if ($thumbnail_file->getError() !== 4) {
            // Generate random name
            $thumbnail_name = $thumbnail_file->getRandomName();

            // Masukkan ke folder /upload/thumbnails
            $thumbnail_file->move('upload/thumbnails', $thumbnail_name);

            $model_template['thumbnail'] = "/upload/thumbnails/$thumbnail_name";
        }

        // Simpan course baru
        $this->courseModel->save($model_template);

        return redirect()->to(base_url('/'));
    }

    public function deleteCourse($id)
    {
        $user = $this->user;

        // Jika user tidak terauntentikasi
        if ($user === null) return redirect()->to(base_url('/user/login'));

        $course = $this->courseModel->find($id);

        // Jika course tidak ditemukan
        if ($course === null) {
            $_SESSION['error'] = 'Course tidak ditemukan.';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/'));
        }

        // Jika user bukan pemilik course
        if ($course['author'] !== $user['id']) {
            $_SESSION['error'] = 'Anda tidak memiliki izin untuk mendelete course ini.';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/'));
        }

        if ($course['thumbnail'] !== null) unlink(substr($course['thumbnail'], 1));

        $this->courseModel->delete($course['id']);

        $_SESSION['delete_success'] = 'Course berhasil di delete.';
        $this->session->markAsFlashdata('delete_success');
        return redirect()->to(base_url('/'));
    }

    public function updateView($id)
    {
        $user = $this->user;

        // Jika user tidak terautentikasi
        if ($user === null) return redirect()->to(base_url('/user/login'));

        $course = $this->courseModel->find($id);
        if ($course === null) return view('/errors/html/error_404');

        // Jika user bukan pemilik course
        if ($course['author'] !== $user['id']) {
            $_SESSION['error'] = 'Anda tidak memiliki izin untuk menupdate course ini.';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/'));
        }

        // Jika thumbnail kosong
        if ($course['thumbnail'] === null) $course['thumbnail'] = '/img/add-course.svg';

        $data = [
            'user' => $user,
            'course' => $course,
            'validation' => \Config\Services::validation(),
        ];

        return view('course/edit', $data);
    }

    public function updateCourse($id)
    {
        $user = $this->user;

        // Jika user tidak terautentikasi
        if ($user === null) return redirect()->to(base_url('/user/login'));

        // Jika course tidak ditemukan
        $course = $this->courseModel->find($id);
        if ($course === null) {
            $_SESSION['error'] = 'Course tidak ditemukan.';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url("/"));
        }

        // Jika user bukan pemilik course
        if ($course['author'] !== $user['id']) {
            $_SESSION['error'] = 'Anda tidak memiliki izin untuk menupdate course ini.';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/'));
        }

        // Jika title tidak diubah berikan is_unique validation
        // Jika tidak diubah jangan berikan is_unique
        $title_validation =
            $this->request->getVar('title') === $course['title']
                ? 'required|alpha_numeric_punct|min_length[3]|max_length[255]'
                : 'required|alpha_numeric_punct|is_unique[course.title]|min_length[3]|max_length[255]';

        // Siapkan validasi input
        $update_course_validation = $this->validate([
            'title' => [
                'rules' => $title_validation,
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'alpha_numeric_punct' => '{field} hanya dapat menggunakan karakter berupa huruf, angka, dan punctuation characters.',
                    'is_unique' => '{field} sudah ada',
                    'min_length' => '{field} harus berisi minimal 3 karakter.',
                    'max_length' => '{field} maksimal berisi 100 karakter.',
                ],
            ],
            'description' => [
                'rules' => 'alpha_numeric_punct',
                'errors' => [
                    'alpha_numeric_punct' => '{field} hanya dapat menggunakan karakter berupa huruf, angka, dan punctuation characters.',
                ],
            ],
            'thumbnail' => [
                'rules' => 'max_size[thumbnail,10240]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran maksimal {field} 10mb',
                    'is_image' => '{field} yang anda pilih bukan gambar',
                    'mime_in' => '{field} yang anda pilih bukan gambar',
                ],
            ],
            'video' => [
                'rules' => 'required|regex_match[/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'regex_match' => 'Bukan URL youtube yang valid',
                ],
            ]
        ]);

        if (!$update_course_validation) return redirect()->to(base_url("/course/edit/$id"))->withInput();

        // Dapatkan ID video dari link
        $result = preg_match("/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/", $this->request->getVar('video'), $matches);
        if (!$result) {
            $_SESSION['error'] = 'Terjadi Kesalahan.';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/'));
        }
        $video_id = $matches[1];

        // Siapkan template update
        $model_template = [
            'id' => $id,
            'title' => $this->request->getVar('title'),
            'author' => $user['id'],
            'description' => $this->request->getVar('description'),
            'video' => $video_id,
        ];

        // Ambil file
        $thumbnail_file = $this->request->getFile('thumbnail');

        // Jika user menupdate gambar
        if ($thumbnail_file->getError() !== 4) {
            // Generate random name
            $thumbnail_name = $thumbnail_file->getRandomName();

            // Masukkan ke folder /upload/thumbnails
            $thumbnail_file->move('upload/thumbnails', $thumbnail_name);

            // Hapus gambar lama
            if ($course['thumbnail'] !== null) unlink(substr($course['thumbnail'], 1));

            // Tambahkan thumbnail
            $model_template['thumbnail'] = "/upload/thumbnails/$thumbnail_name";
        }

        // Simpan course baru
        $this->courseModel->save($model_template);

        return redirect()->to(base_url('/'));
    }
}
