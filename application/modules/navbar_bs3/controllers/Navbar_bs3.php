<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 22.11.2015
 * Time: 19:50
 * Purpose: dummy controller
 */

class Navbar_bs3 extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->data['brand'] = 'BRAND';
    }

    public function index()
    {
        $this->data['menuitems'] = Modules::run('menuitems/menuitems/index');

        $this->load->view('navbar_view', $this->data);
    }

    public function navbar_top()
    {
        $this->data['menuitems'] = Modules::run('menuitems/menuitems/index');
        $this->load->view('demo_view', $this->data);
    }

}