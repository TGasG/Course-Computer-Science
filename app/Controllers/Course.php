<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;

class Course extends BaseController
{

    protected BaseConnection $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'courses' => $this->db->table('course')->select((['id', 'title', 'description', 'thumbnail']))->get()->getResultArray(),
        ];

        dd($data);
    }
}
