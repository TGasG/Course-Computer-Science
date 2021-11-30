<?php

namespace App\Controllers;

use App\Models\CourseModel;

class Home extends BaseController
{

    protected $courseModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
    }

    public function index()
    {
        $courses = $this->courseModel->select(['id', 'title', 'description', 'thumbnail'])->orderBy('createdAt')->findAll(3);

        // Berikan placeholder untuk course yang tidak memiliki thumbnail
        $courses = array_map(function ($course) {
            if ($course['thumbnail'] === null) $course['thumbnail'] = 'thumbnail-placeholder.png';
            return $course;
        }, $courses);

        $data = [
            'user' => $this->session->get('user'),
            'courses' => $courses,
        ];

        return view('home', $data);
    }
}
