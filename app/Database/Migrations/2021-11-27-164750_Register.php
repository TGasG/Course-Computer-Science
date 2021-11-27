<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Register extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'studentId' => [
                'type' => 'INT'
            ],
            'courseId' => [
                'type' => 'INT'
            ],
            'createdAt DATETIME NOT NULL DEFAULT(NOW())',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('studentId', 'User', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('courseId', 'Course', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Register');
    }

    public function down()
    {
        $this->forge->dropTable('Course');
    }
}
