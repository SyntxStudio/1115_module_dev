<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 23.11.2015
 * Time: 20:26
 * Purpose: Metoda Api RESTfull servera
 * @property  form_validation
 */
require APPPATH. 'modules/api/libraries/REST_Controller.php';

/**
 * @property  Api_model
 */
class Api extends REST_Controller
{
    /**
     *  Methods:
     *  demo_get  (results by id, all results)
     *  demo_put  (insert new record)
     *  demo_post (update existing record)
     */

    /**
     * deklarisanje promenljivih
     * validation rules -> put
     * validation rules -> post
    */
    private $_valrule_put = 'demo_put';
    private $_valrule_post = 'demo_post';
    /**
     *
     */

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model');
        $this->lang->load('api', 'english');
    }

    public function demo_get()
    {
        // selektuje se vrednost iz get poziva po $id
        $id = $this->uri->segment(3, NULL);
        // povlacenje vrednosti iz table demo
        // selekcija samo odredjenih polja
        // uslov na id pri povlacenju
        $demo = $this->Api_model->get($id);

        // provera da li postoji demo pod tim id
        if (isset($demo)) {
            $this->response(array('status' => 'success', 'message' => $demo));
        } else {
            // ako ne postoji salje se greska sa obavestenjem
            $this->response(array('status' => 'failure', 'message' => $this->lang->line('error_find_records')), 404);
        }
    }

    public function demo_put()
    {
        // lokalno ucitavanje biblioteka
        $this->load->library('form_validation');
        $this->load->helper('api_data');
        // povlacenje podatak iz put metode
        $data = $this->put();
        // provera da li postoji takvo polje u tabeli
        $data = is_in_array($data, $this->Api_model->arr_table_fields());
        // validiranje podataka sa set_data() ako ne poticu iz POST metode
        $this->form_validation->set_data($data);
        // ako je uspesno validiranje
        if($this->form_validation->run($this->_valrule_put) != FALSE){
        // ako je uspesan upis, model vraca zadnji id
        $data_id = $this->Api_model->save($data);
            if($data_id){
                // ako je upis u bazu uspeo vraca id upisa
                $this->response(array(
                        'status' => 'success',
                        'message' => $data_id
                    ),200);
            } else {
                //ako upis nije uspeo
                $this->response(array(
                        'status' => 'failure',
                        'message' => $this->lang->line('error_data_save')
                    ),500);
            }
        } else {
            // ako nije prosla validacija prikazuje greske
            $this->response(array(
                'status' => 'failure',
                'message' => $this->form_validation->error_array()
            ),400);
        }
    }

    public function demo_post()
    {
        // povlacimo id iz URI-a
        $id = $this->uri->segment(3, NULL);
        // prvo prikazujemo model
        $demo = $this->Api_model->get($id);
        // ako ima upisa
        if(is_numeric($id) && count($demo)) {
            $this->load->library('form_validation');
            $this->load->helper('api_data');
            // povlacenje podatak iz put metode
            // provera da li postoji takvo polje u tabeli
            $data = is_in_array($this->post(), $this->Api_model->arr_table_fields());
            // validiranje podataka sa set_data() ako ne poticu iz POST metode
            $this->form_validation->set_data($data);
            // ako je uspesno validiranje
            if ($this->form_validation->run($this->_valrule_post) != FALSE) {
                // ako je uspesan upis, model vraca zadnji id
                if (is_numeric($this->Api_model->save($data, $id))) {
                    // ako je upis u bazu uspeo vraca id upisa
                    $this->response(array(
                        'status' => 'success',
                        'message' => $this->lang->line('success_data_save')
                    ), 200);
                } else {
                    //ako upis nije uspeo
                    $this->response(array(
                        'status' => 'failure',
                        'message' => $this->lang->line('error_data_save')
                    ), 500);
                }

            } else {
                // ako nije prosla validacija prikazuje greske
                $this->response(array(
                    'status' => 'failure',
                    'message' => $this->form_validation->error_array()
                ),400);
            }
        } else {
            // ako ne postoji salje se greska sa obavestenjem
            $this->response(array('status' => 'failure', 'message' => $this->lang->line('error_find_records')), 404);
        }
    }
}