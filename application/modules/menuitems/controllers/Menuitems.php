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

    /**
     * return formated view of menu items
     */
    public function index()
    {
        //$this->Menuitems_model->_config_active_parent_link = TRUE;
        $this->data['menuitems'] = $this->Menuitems_model->get_menu();
        $this->load->view('menuitems_tree', $this->data);
    }

    /**
     * Simple menu tree printout
     */
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

    /**
     * Controller for deleting items
     * Deletes by provided id in uri string. If omited exits function
     *
     * Second argument boolean, default false all sibling adopting grandparent id,
     * after parent deletition.
     * TRUE argument deletes parent and all siblings
     * @param null $id
     */
    public function delete($id = NULL)
    {
        if(!$id == NULL) {
            $this->Menuitems_model->delete($id);
        }
        redirect('menuitems/order');
    }

    /**
     * Controller for item sorting by ajax function
     */
    public function order()
    {
        $this->data['sortable'] = TRUE;
        $this->load->view('order',$this->data);
    }

    /**
     * Controller called by controller ORDER
     */
    public function order_by_ajax()
    {
        // grabs POST callback and save values in table
        if (isset($_POST['sortable'])) {
            $this->Menuitems_model->save_order($_POST['sortable']);
        }
        //fetch nested items from model
        $this->data['menuitems'] = $this->Menuitems_model->get_ajax_menu();

        // loads view on first call and after altering data in table
        $this->load->view('order_ajax', $this->data);
    }

    /**
     * Controller for editing and adding new item in table
     * @param null $id
     */
    public function edit($id = NULL)
    {
        $this->load->library('form_validation');

        // povlacenje svih zapisa iz baze
        $this->data['menuitems'] = $this->Menuitems_model->get_menuitem();

        // if id provided fetch data for this id
        if ($id){
            count($this->data['menuitems']) || $this->data['errors'][] = 'Page not found';
            $this->data['menuitem'] = $this->Menuitems_model->menuitem_from_arr($this->data['menuitems'], $id);
        } else {
            // else it's a new record, so create new class instance
            $this->data['menuitem'] = $this->Menuitems_model->get_new();
        }

        // podesavanje uslova
        $rules = $this->Menuitems_model->_validation_rules;
        $this->form_validation->set_rules($rules);

        // obrada podataka
        if ($this->form_validation->run() == TRUE){
            $data = $this->Menuitems_model->array_from_post(array(
                'label',
                'description',
                'link',
                'parent',
                'order'
            ));
            $this->Menuitems_model->save($data,$id);
            redirect('menuitems/order');
        }

        // for displaying parent option in dropdown select form object
        $this->data['parent_option'] = array(0 => 'root');
        foreach ($this->data['menuitems'] as $option) {
            $this->data['parent_option'][$option->id] = $option->label;
        }

        // ucitavanje stranice
        $this->load->view('menuitems_edit', $this->data);
    }
}