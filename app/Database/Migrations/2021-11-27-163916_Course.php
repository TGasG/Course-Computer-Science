<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Course extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => true,
            ],
            'author' => [
                'type' => 'INT',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'thumbnail' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'video' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'createdAt DATETIME NOT NULL DEFAULT(NOW())',
            'updatedAt DATETIME NOT NULL DEFAULT(NOW())',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('author', 'User', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Course');
    }

    public function down()
    {
        $this->forge->dropTable('Course');
    }
}
