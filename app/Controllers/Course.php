<?php

namespace App\Controllers;

class Course extends BaseController
{
    public function courseView($id)
    {
        if ($this->user === null) return redirect()->to(base_url('/user/login'));
        $id = (int)$id;

        $course = $this->courseModel->select(['title', 'author', 'description', 'video',])->find($id);
        if ($course === null) return view('/errors/html/error_404');

        $data = [
            'user' => $this->user,
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
                    'alpha_space' => '{field} hanya dapat menggunakan karakter berupa huruf, angka, dan punctuation characters.',
                    'is_unique' => '{field} sudah ada',
                    'min_length' => '{field} harus berisi minimal 3 karakter.',
                    'max_length' => '{field} maksimal berisi 100 karakter.',
                ],
            ],
            'description' => [
                'rules' => 'alpha_numeric_punct',
                'errors' => [
                    'alpha_space' => '{field} hanya dapat menggunakan karakter berupa huruf, angka, dan punctuation characters.',
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

        // Ambil file
        $thumbnail_file = $this->request->getFile('thumbnail');

        // Generate random name
        $thumbnail_name = $thumbnail_file->getRandomName();

        // Masukkan ke folder /upload/thumbnails
        $thumbnail_file->move('upload/thumbnails', $thumbnail_name);

        // Simpan course baru
        $this->courseModel->insert([
            'title' => $this->request->getVar('title'),
            'author' => $user['id'],
            'description' => $this->request->getVar('description'),
            'thumbnail' => "/upload/thumbnails/$thumbnail_name",
            'video' => $video_id,
        ]);

        return redirect()->to(base_url('/'));
    }
}
