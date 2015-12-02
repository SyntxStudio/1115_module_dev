<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 25.11.2015
 * Time: 13:19
 * Purpose: Klasa za rad sa api bazom
 */

class Api_model extends CI_Model{

    protected $_table = 'demo';
    protected $_primary_key = 'demo_id';
    protected $_primary_filter = 'intval';
    protected $_return_type = 'array';
    public $_select_fields = array('demo_id','email','phone');
    protected $_order_by = '';
    protected $_rules = '';

    public function __construct(){
        parent::__construct();
    }

    public function get($id = NULL)
    {
        // Ako je selektovanje samo odredjenih polja
        if ($this->_select_fields != NULL){
            // ako ima upisa
            $str = implode(',', $this->_select_fields);
            $this->db->select($str);
        }

        // u slucaju da postoji id
        if($id != NULL){
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->where($this->_primary_key,$id);
        }
        // sortiranje po zadatom uslovu, ako ga ima
        if($this->_order_by != NULL){
            $this->db->order_by($this->_order_by);
        }
        // vraca rezultat
        return $this->db->get($this->_table)->result_array();
    }

    public function save($data, $id = NULL)
    {
        // provera da li postoji polje password
        if(array_key_exists('password', $data)){
            $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
        }

        if ($id != NULL){
            // sa prosledjenim id-jem menja se postojeci upis (update)
            $this->db->where($this->_primary_key, $id);
            $this->db->update($this->_table,$data);
            return $id;
        } else {
            // ako je id null podrazumeva nov upis (insert)
            $this->db->insert($this->_table, $data);
            return $insert_id = $this->db->insert_id();
        }
    }
    
    public function arr_table_fields()
    {
        $arr = $this->db->list_fields($this->_table);
        return $arr;
    }


}