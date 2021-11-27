<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class User extends Seeder
{
    public function run()
    {
        $mentors = [
            [
                'name' => 'Kevin Leonard Sugiman',
                'email' => 'leonardk56.kl@gmail.com',
                'password' => password_hash('HelloWorld', PASSWORD_ARGON2I),
                'phone' => '087885855258',
                'role' => 'mentor',
            ],
            [
                'name' => 'Andika Hiro Pratama',
                'email' => 'hiroandika@gmail.com',
                'password' => password_hash('HelloWorld', PASSWORD_ARGON2I),
                'phone' => '081807452395',
                'role' => 'mentor',
            ],
            [
                'name' => 'Fadillah Anzal Nurrohmah Ardiani',
                'email' => 'anzalardiani05@gmail.com',
                'password' => password_hash('HelloWorld', PASSWORD_ARGON2I),
                'phone' => '081210253705',
                'role' => 'mentor',
            ],
            [
                'name' => 'Zidane Anvio Putra',
                'email' => 'putraanvio@gmail.com',
                'password' => password_hash('HelloWorld', PASSWORD_ARGON2I),
                'phone' => '087831223812',
                'role' => 'mentor',
            ],
            [
                'name' => 'Gustian Abrary Shidqi',
                'email' => 'gustian2001@gmail.com',
                'password' => password_hash('HelloWorld', PASSWORD_ARGON2I),
                'phone' => '087875288581',
                'role' => 'mentor',
            ],
        ];

        // Generate Mentors
        foreach ($mentors as $mentor) {
            $this->db->table('user')->insert($mentor);
        }

        $faker = Factory::create('id_ID');

        // Fake students
        for ($i = 0; $i < 100; $i++) {
            $data = [
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => password_hash('HelloWorld', PASSWORD_ARGON2I),
                'phone' => $faker->phoneNumber,
                'role' => 'student',
            ];
            $this->db->table('user')->insert($data);
        }
    }
}
