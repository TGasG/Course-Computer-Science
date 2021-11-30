<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CourseModel;

class Course extends BaseController
{

    protected CourseModel $courseModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
    }

    public function index()
    {
        $data = [
            'courses' => $this->courseModel->select(['id', 'title', 'description', 'thumbnail'])->findAll(),
        ];

        dd($data);
    }
}
