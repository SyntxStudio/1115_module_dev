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

class Migration_Create_forecast_tables extends CI_Migration {

	public function up()
	{
		// Drop table 'forecast_settings' if it exists
		$this->dbforge->drop_table('forecast_settings', TRUE);

		// Drop table 'forecast_cities' if it exists
		$this->dbforge->drop_table('forecast_cities', TRUE);

		// Drop table 'forecast_data' if it exists
		$this->dbforge->drop_table('forecast_data', TRUE);

		// Table structure for table 'forecast_settings'
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
			'group' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
			),
			'type' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
			),
			'item' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'value' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('forecast_settings');

		// Table structure for table 'forecast_cities'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '6',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'city_id' => array(
				'type' => 'INT',
				'constraint' => '8',
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '60',
			),
			'country' => array(
				'type' => 'VARCHAR',
				'constraint' => '3',
			),
			'lon' => array(
				'type' => 'INT',
				'constraint' => '3',
			),
			'lat' => array(
				'type' => 'INT',
				'constraint' => '3',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('forecast_cities');

		// Table structure for table 'forecast_data'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '3',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'date_add' => array(
				'type' => 'VARCHAR',
				'constraint' => '30',
			),
			'location_id' => array(
				'type' => 'VARCHAR',
				'constraint' => '30',
			),
			'data' => array(
				'type' => 'TEXT',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('forecast_data');
	}

	public function down()
	{
		$this->dbforge->drop_table('forecast_settings', TRUE);
		$this->dbforge->drop_table('forecast_cities', TRUE);
		$this->dbforge->drop_table('forecast_data', TRUE);
	}
}
