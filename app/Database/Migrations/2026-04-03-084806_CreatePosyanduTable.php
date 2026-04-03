<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePosyanduTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'address'   => ['type' => 'TEXT', 'null' => true],
            'latitude'  => ['type' => 'DECIMAL', 'constraint' => '10,8', 'null' => true],
            'longitude' => ['type' => 'DECIMAL', 'constraint' => '11,8', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('posyandu', true);
    }

    public function down()
    {
        $this->forge->dropTable('posyandu', true);
    }
}
