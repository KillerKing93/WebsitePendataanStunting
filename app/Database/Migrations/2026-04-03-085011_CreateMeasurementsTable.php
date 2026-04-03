<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMeasurementsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'child_id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'measurement_date' => ['type' => 'DATE'],
            'weight'           => ['type' => 'DECIMAL', 'constraint' => '5,2'],
            'height'           => ['type' => 'DECIMAL', 'constraint' => '5,2'],
            'stunting_status'  => ['type' => 'ENUM', 'constraint' => ['Normal', 'Berisiko', 'Stunting'], 'default' => 'Normal'],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('child_id', 'children', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('measurements', true);
    }

    public function down()
    {
        $this->forge->dropTable('measurements', true);
    }
}
