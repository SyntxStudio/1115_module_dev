<?php defined('BASEPATH') OR exit('No direct script access allowed');

/** ----------------------------------------------------------------------
 * Created by: Petar
 * Date: 28.11.2015
 * Time: 19:01
 * Desc: Migracija tabele modela 'menu'
 * Migraciaj kreira tabelu meni sa odgovarajucim poljima
 *
 * ENGLISH: Menu model class migration
 * creates table 'menu' with neccessery fields
-----------------------------------------------------------------------*/

class Migration_Create_menu extends CI_Migration {

	public function up()
	{
		// Drop table 'groups' if it exists
		$this->dbforge->drop_table('menu', TRUE);

		// Table structure for table 'groups'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '3',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'label' => array(
				'type' => 'VARCHAR',
				'constraint' => '30',
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'link' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'parent' => array(
				'type' => 'INT',
				'constraint' => '3',
			),
			'order' => array(
				'type' => 'INT',
				'constraint' => '3',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('menu');
	}

	public function down()
	{
		$this->dbforge->drop_table('menu', TRUE);
	}
}
