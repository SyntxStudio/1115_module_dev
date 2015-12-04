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
        $this->load->model('Menuitems_model');
    }

    public function index()
    {
        //$this->Menuitems_model->_config_active_parent_link = TRUE;
        $this->data['menuitems'] = $this->Menuitems_model->get_menu();
        $this->load->view('menuitems_view', $this->data);
    }

    public function skelet($parent = 0)
    {
        $this->Menuitems_model->_config_template_version = 'default';
        $this->data['menuitems'] = $this->Menuitems_model->get_menu($parent);
        $this->load->view('menuitems_view', $this->data);
    }

    /**
     * Screen print of available parent attributes
     */
    public function availables()
    {
        $this->data['menuitems'] = $this->Menuitems_model->available_parents();
        echo $this->data['menuitems'];
    }

    public function delete($id = NULL)
    {
        if($id == NULL) {
            echo 'Provide id';
        } else {
            $this->Menuitems_model->delete($id);
        }
    }

    public function order()
    {
        $this->data['sortable'] = TRUE;
        $this->load->view('order',$this->data);
    }

    public function order_by_ajax()
    {
        if (isset($_POST['sortable'])) {
            $this->Menuitems_model->save_order($_POST['sortable']);
        }
        //fetch nested items from model
        $this->data['menuitems'] = $this->Menuitems_model->get_ajax_menu();

        // sortiramo i prikazujemo pomocu jQuery metode u stranici
        $this->load->view('order_ajax', $this->data);
    }
}