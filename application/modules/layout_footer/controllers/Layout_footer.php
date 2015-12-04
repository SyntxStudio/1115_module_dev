<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 22.11.2015
 * Time: 19:50
 * Purpose: Class for menaging head part of page
 * style Bootstrap3
 */

class Layout_footer extends MY_Controller{

    /**
     * Public variables and constants
     */

    public function __construct(){
        parent::__construct();
    }

    public function index($data = NULL)
    {
        $this->data['data'] = 'Reserved rights Petar &copy';

        $this->load->view('layout_footer_view', $this->data);
    }

}