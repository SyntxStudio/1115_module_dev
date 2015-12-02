<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 21.10.2015
 * Time: 22:07
 * Purpose: Master klasa - nasledjuju je dajle svi kontroleri, admin, public i direktno
 */

class MY_Controller extends MX_Controller{

    // Deklasrisanje promenljivih
    public $data = array();


    public function __construct(){
        parent::__construct();
        $this->data['errors'] = array();
        $this->data['site_name'] = 'site_name';
        $this->data['meta_title'] = 'Some site name';
    }

}