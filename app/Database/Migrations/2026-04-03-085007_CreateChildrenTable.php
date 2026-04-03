<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChildrenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'posyandu_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nik'         => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'birth_date'  => ['type' => 'DATE'],
            'gender'      => ['type' => 'ENUM', 'constraint' => ['L', 'P']],
            'parent_name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'address'     => ['type' => 'TEXT', 'null' => true],
            'latitude'    => ['type' => 'DECIMAL', 'constraint' => '10,8', 'null' => true],
            'longitude'   => ['type' => 'DECIMAL', 'constraint' => '11,8', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('posyandu_id', 'posyandu', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('children', true);
    }

    public function down()
    {
        $this->forge->dropTable('children', true);
    }
}
