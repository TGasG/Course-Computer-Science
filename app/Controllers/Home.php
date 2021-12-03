<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $user = $this->user;
        $courses = $this->courseModel->select(['id', 'title', 'description', 'thumbnail'])->orderBy('createdAt', 'DESC')->findAll(3);

        // Berikan placeholder untuk course yang tidak memiliki thumbnail
        $courses = array_map(function ($course) {
            if ($course['thumbnail'] === null) $course['thumbnail'] = '/img/thumbnail-placeholder.png';
            return $course;
        }, $courses);

        $data = [
            'user' => $user,
            'courses' => $courses,
            'error' => $this->session->getFlashdata('error'),
            'delete_success' => $this->session->getFlashdata('delete_success'),
        ];

        // Jika user student
        if ($user !== null && $user['role'] === 'student') {
            $registeredCourses = $this->registerModel->where('studentId', $user['id'])->findColumn('courseId') ?? [];

            $data['courses'] = array_map(function ($course) use ($registeredCourses) {
                $course['isRegistered'] = !(array_search($course['id'], $registeredCourses) === false);
                return $course;
            }, $data['courses']);
        }

        return view('home', $data);
    }
}
