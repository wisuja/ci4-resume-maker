<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataCv extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'cv_id'       => [
				'type'       => 'int',
				'constraint' => '5',
			],
			'name'       => [
				'type'       => 'VARCHAR',
				'constraint' => '50',
			],
			'phone'       => [
				'type'       => 'VARCHAR',
				'constraint' => '15',
			],
			'email'       => [
				'type'       => 'VARCHAR',
				'constraint' => '50',
			],
			'address'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'description'       => [
				'type'       => 'text',
				'null'	=> false,
			],
			'skill'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'education'       => [
				'type'       => 'text',
				'null'	=> false,
			],
			'work_experience'       => [
				'type'       => 'text',
				'null'	=> false,
			],
			'link'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'keyword'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('data_cv');
	}

	public function down()
	{
		$this->forge->dropTable('data_cv');
	}
}