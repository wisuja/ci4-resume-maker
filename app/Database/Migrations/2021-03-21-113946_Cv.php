<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cv extends Migration
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
			'user_id'       => [
				'type'       => 'int',
				'constraint' => '5',
			],
			'url_cv'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'url_recommendation'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('cv');
	}

	public function down()
	{
		$this->forge->dropTable('cv');
	}
}