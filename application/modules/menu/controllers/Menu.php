<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 22.11.2015
 * Time: 19:50
 * Purpose: dummy controller
 */

class Menu extends MY_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $this->load->model('Menu_model');

        $this->data['menu'] = $this->Menu_model->get_menu();

        $this->load->view('menu_view', $this->data);
    }

}