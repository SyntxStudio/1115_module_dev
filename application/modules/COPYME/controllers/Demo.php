<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 22.11.2015
 * Time: 19:50
 * Purpose: dummy controller
 */

class Demo extends MY_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('demo_view');
    }

}