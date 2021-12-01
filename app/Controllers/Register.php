<?php

namespace App\Controllers;

class Register extends BaseController
{
    public function registerHandler()
    {
        // Dapatkan variable
        $studentId = $this->request->getVar('studentId');
        $courseId = $this->request->getVar('courseId');

        $user = $this->userModel->find($studentId);

        // Jika sudah pernah terdaftar
        $registeredCourse = $this->registerModel->where('studentId', 1)->where('courseId', 1)->first();
        if ($registeredCourse !== null) {
            $_SESSION['error'] = 'Kamu sudah pernah terdaftar';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/'));
        }

        // Jika mentor jangan didaftarkan
        if ($user['role'] === 'mentor') {
            $_SESSION['error'] = 'Mentor tidak dapat mendaftar course';
            $this->session->markAsFlashdata('error');
            return redirect()->to(base_url('/'));
        }

        // Insert pendaftaran
        $this->registerModel->insert([
            'studentId' => $studentId,
            'courseId' => $courseId,
        ]);

        return redirect()->to(base_url('/course/'.$courseId));
    }
}
