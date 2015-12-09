<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 22.11.2015
 * Time: 19:50
 * Purpose: dummy controller
 */

class Forecast extends MY_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        // podesavanje parametara za odredjeni grad i povlacenje iz baze
        // trenutno radim na api.met.no
        $server = 'api.met.no';
        $serv_request_uri = 'weatherapi';
        $location_data_type = 'locationforecast/1.9';
        $city_name = 'Novi Sad';
        $city_lat = '';
        $city_lon = '';

        $fetch_URI_string = '';

        $this->load->view('demo_view');
    }

}