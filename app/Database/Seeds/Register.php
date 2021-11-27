<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Register extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 11; $i++) {
            for ($y = 0; $y < 3; $y++) {
                $this->db->table('register')->insert([
                    'studentId' => rand(6, 105),
                    'courseId' => $i + 1,
                ]);
            }
        }
    }
}
