<?php

namespace App\Controllers;

class Register extends BaseController
{
    public function registerHandler()
    {
        $user = $this->user;

        // Jika user tidak terautentikasi ke halaman login
        if ($user === null) return redirect()->to(base_url('/user/login'));

        // Jika user bukan student
        if ($user['role'] !== 'student') {
            $_SESSION['error'] = 'Hanya student yang dapat mendaftar course.';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/'));
        }

        // Dapatkan variable
        $courseId = $this->request->getVar('courseId');

        // Jika sudah pernah terdaftar
        $registeredCourse = $this->registerModel->where('studentId', $user['id'])->where('courseId', $courseId)->first();
        if ($registeredCourse !== null) {
            $_SESSION['error'] = 'Kamu sudah pernah terdaftar';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/'));
        }

        // Insert pendaftaran
        $this->registerModel->insert([
            'studentId' => $user['id'],
            'courseId' => $courseId,
        ]);

        return redirect()->to(base_url('/course/' . $courseId));
    }
}
