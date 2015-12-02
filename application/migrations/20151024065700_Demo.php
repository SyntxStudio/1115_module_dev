<?php
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 24.10.2015
 * Time: 5:21
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Demo extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'demo_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => '256',
            ),
            'phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
            ),
            'ip_adress' => array(
                'type' => 'VARCHAR',
                'constraint' => '15',
            )
        ));
        $this->dbforge->add_key('demo_id', TRUE);
        $this->dbforge->create_table('demo');
    }

    public function down()
    {
        $this->dbforge->drop_table('demo');
    }
}