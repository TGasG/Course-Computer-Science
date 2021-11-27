<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Course extends Seeder
{
    public function run()
    {
        $courses = [
            [
                'title' => 'Belajar HTTP',
                'author' => rand(1, 5),
                'description' => 'Hi guys, pada materi ini kita akan belajar tentang HTTP. HTTP merupakan materi dasar jika kita ingin masuk ke dunia Web. Sebelum belajar Web, saya sangat sarankan teman-teman mengerti tentang HTTP.',
                'video' => '92Rjzrq4oIg',
            ],
            [
                'title' => 'Tutorial Java Stream',
                'author' => rand(1, 5),
                'description' => 'Di video kali ini, kita akan belajar tentang Java Stream, salah satu fitur kekinian di Java yang sangat banyak digunakan. Fitur Java Stream ini merupakan improvement dari Java Collection dan sudah banyak diadopsi oleh programmer Java.',
                'video' => '9SXRoeu6QBg',
            ],
            [
                'title' => 'Tutorial Javascript',
                'author' => rand(1, 5),
                'description' => 'Pada course kali ini, kita akan bahas tuntas dan lengkap selama 8 jam tentang JavaScript Dasar. Disini kita akan belajar dasar-dasar pemrograman JavaScript secara lengkap dan dalam.',
                'video' => 'SDROba_M42g',
            ],
            [
                'title' => 'Tutorial MySQL Database',
                'author' => rand(1, 5),
                'description' => 'Di video kali ini, saya akan bahas tentang belajar database MySQL, salah satu database relational yang paling populer di dunia. Di video ini kita akan banyak belajar tentang perintah SQL di MySQL dari pembuatan database, table dan manipulasi data di MySQL. Tak lupa kita juga akan belajar tentang relational, foreign key, join table, dan lain-lain.',
                'video' => 'xYBclb-sYQ4',
            ],
            [
                'title' => 'Tutorial Java OOP',
                'author' => rand(1, 5),
                'description' => 'Hi guys, ini adalah materi lanjutan dari JAVA DASAR. Di video kali ini kita akan bahas tentang Pemrograman Berorientasi Object dengan Java.',
                'video' => 'f3ZhNnvtV-w',
            ],
            [
                'title' => 'Tutorial Java Dasar',
                'author' => rand(1, 5),
                'description' => 'Di materi ini kita akan belajar dasar-dasar bahasa pemrograman Java. Materinya akan membahas secara rinci dasar-dasar pemrograman Java yang perlu dikuasai sebelum kita belajar pemrograman berorientasi objek di Java.',
                'video' => 'jiUxHm9l1KY',
            ],
            [
                'title' => '6 Cara Menghasilkan UANG dari CODING',
                'author' => rand(1, 5),
                'description' => 'Di video kali ini saya akan membagikan 6 cara menghasilkan uang dari coding. Informasi ini saya bagikan sebagai wawasan khususnya untuk temen-temen yang sudah merasa memiliki kemampuan coding namun belum pernah menghasilkan uang secar profesional.',
                'video' => 'A-Z2FlhDLQk',
            ],
            [
                'title' => 'VS Code in 100 Seconds',
                'author' => rand(1, 5),
                'description' => 'Visual Studio Code is an open-source lightweight code editor maintained by Microsoft. Get the full VS Code Magic Tricks course to write better code faster https://fireship.io/courses/vscode-tricks/',
                'video' => 'KMxo3T_MTvY',
            ],
            [
                'title' => 'Swift in 100 Seconds',
                'author' => rand(1, 5),
                'description' => 'Swift is a modern programming language developed by Apple. It is commonly used to code apps for iOS and MacOS, but is open-source and can be used outside of Apple’s walled garden.',
                'video' => 'nAchMctX4YA',
            ],
            [
                'title' => 'C in 100 Seconds',
                'author' => rand(1, 5),
                'description' => 'The C Programming Language is quite possibly the most influential language of all time. It powers OS kernels like Linux, Windows, and Mac and many other low-level systems.  Its syntax has inspired many other languages, including Cpp, Csharp, Java, JavaScript, Go, Perl, and more.',
                'video' => 'U3aXWizDbQ4',
            ],
            [
                'title' => 'Build a Mindblowing 3D Portfolio Website // Three.js Beginner’s Tutorial',
                'author' => rand(1, 5),
                'description' => 'Learn the basics of Three.js - a tool for building amazing 3D graphics with JavaScript. In this tutorial, we create an animated 3D scrolling animation for a portfolio website https://github.com/fireship-io/threejs-scroll-animation-demo',
                'video' => 'Q7AOvWpIVHU',
            ],
        ];

        foreach ($courses as $course) {
            $this->db->table('course')->insert($course);
        }
    }
}
