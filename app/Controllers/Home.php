<?php

namespace App\Controllers;

use CodeIgniter\Database\BaseConnection;

class Home extends BaseController
{

    protected BaseConnection $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'user' => $this->session->get('user'),
            'courses' => $this->db->table('course')->select((['id', 'title', 'description', 'thumbnail']))->limit(3)->orderBy('createdAt')->get()->getResultArray(),
        ];

        return view('home', $data);
    }
}
