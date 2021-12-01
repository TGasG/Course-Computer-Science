<?php

namespace App\Controllers;

class Course extends BaseController
{
    public function courseView($id)
    {
        if ($this->user === null) return redirect()->to(base_url('/user/login'));
        $id = (int) $id;

        $course = $this->courseModel->select(['title', 'author', 'description', 'video',])->find($id);
        if ($course === null) return view('/errors/html/error_404');

        $data = [
            'user' => $this->user,
            'course' => $course,
        ];

        return view('course/course', $data);
    }
}
