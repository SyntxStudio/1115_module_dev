<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 22.11.2015
 * Time: 19:50
 * Purpose: dummy controller
 */

class Menuitems extends MY_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $this->load->model('Menuitems_model');
        $this->Menuitems_model->_config_active_parent_link = TRUE;
        $this->data['menuitems'] = $this->Menuitems_model->get_menu();
        $this->load->view('menuitems_view', $this->data);
    }

}