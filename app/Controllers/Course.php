<?php

namespace App\Controllers;

class Course extends BaseController
{
    public function index()
    {
        $data = [
            'courses' => $this->courseModel->select(['id', 'title', 'description', 'thumbnail'])->findAll(),
        ];

        dd($data);
    }
}
