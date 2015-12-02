<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 24.10.2015
 * Time: 7:25
 * Purpose: Glavna strana u admin panelu
 */

class Admin extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('auth/ion_auth');
        //$this->load->helper(array('url','language'));


        //$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'auth'), $this->config->item('error_end_delimiter', 'auth'));

        //$this->lang->load('auth', 'Serbian');
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        }
        $this->data['module'] = Modules::run('public/home/index');
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function modal()
    {
        $this->data['login_modal_path'] = 'admin/modal';
        $this->lang->load('auth', 'Serbian');
        $this->data['title'] = "Login";
        //validate form input
        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        // Ako je pokrenuta validacija podataka
        if ($this->form_validation->run() == true)
        {
            // Proveriti  da li se korisnik loguje
            // proveriti dugme "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
            {
                //Ako je login uspesan
                //usmeriti na dashboard stranicu
                $this->session->set_flashdata('message', $this->auth->messages());
                redirect('admin/dashboard', 'refresh');
            }
            else
            {
                // ako nije prosao login
                // ponovo ucitati modal stranicu i prikazati greske
                $this->session->set_flashdata('message', $this->auth->errors());
                redirect($this->data['login_modal_path'], 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        }
        else
        {
            // Korisnik se ne loguje
            // Prikazati greske ako ih ima
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['identity'] = array(
                'name' => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'placeholder'=>"username/password",
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['password'] = array(
                'name' => 'password',
                'id'   => 'password',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder'=>"password",
            );
            $this->data['title'] = 'Dokurca logovan';
            $this->load->view('admin/_layout_modal', $this->data);
        }
    }

    public function login()
    {
        $this->data['module'] = Modules::run('auth/auth/login');
        $this->load->view('admin/_layout_main', $this->data);
    }

}