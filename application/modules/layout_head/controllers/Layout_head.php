<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 22.11.2015
 * Time: 19:50
 * Purpose: Class for menaging head part of page
 * style Bootstrap3
 */

class Layout_head extends MY_Controller{

    /**
     * Public variables and constants
     */
    private $_head_data = array(
        'meta_utf'      => '<meta charset="utf-8">',
        'meta_ua'       => '<meta http-equiv="X-UA-Compatible" content="IE=edge">',
        'meta_bs3'      => '<meta name="viewport" content="width=device-width, initial-scale=1">',
        'title'         => '<title>Neki titl</title>',
        'jquery.js'     => '<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>',
        'bootstrap.js'  => '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>',
        'bootstrap.css' => '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />',
        'custom.css'    => '',
    );


    public function __construct(){
        parent::__construct();
    }

    public function index($data = NULL)
    {
        $this->data['head_data'] = ($data != NULL)? $data : $this->_head_data;

        $this->load->view('layout_head_view', $this->data);
    }

}