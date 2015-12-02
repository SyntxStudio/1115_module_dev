<?php defined('BASEPATH') OR exit('No direct script access allowed');
/** --------------------------------------------------------------------/
 * Created by: Petar
 * Date: 28.11.2015
 * Time: 19:01
 * Desc: Klasa modela menija
 * Klasa je bazirana na multidimenzinalnom dinamickom grananju menija
 * Sadrzi funkciju za gradnju menija u niz ili pri odabiru atributa
 * pojedinacnom grananju samo jednog parenta
 *
 * ENGLISH: Menu class base don multi-level dynamic menu building
 * Ouputs in multi-dimensinal array.
 * If used with function attributes, returns array of first level,
 * with one selected branch of children objects
-----------------------------------------------------------------------*/

class Menu_model extends CI_Model
{

    /* -----------------------------------------------------------
     * VARIABLES
     *-------------------------------------------------------------*/
    /**
     * Linked table name
     */
    protected $_table = 'menu';

    /**
     * Primary key for menu table
     */
    protected $_primary_key = 'id';

    /**
     * Default Filter for index key type
     */
    protected $_primary_filter = 'intval';

    /**
     * result() method return type
     * 'object' for object of objects = result()
     * 'array' for array of objects = result_array()
     */
    protected $_return_type = 'array';

    /**
     * If used, SELECT statement return only this fields
     * example:
     * $str = implode(',', $this->_select_fields);
     * $this->db->select($str);
     */
    public $_select_fields = array('menu_id','label','link', 'parent');

    /**
     * Default order of return result
     */
    protected $_order_by = array('parent','order','label');

    /**
     * Active link
     */
    public $_active_link = '';
    /**
     * Validation rules for form creation of menu
     */
    protected $_validation_rules = array(
        'label' => array(
            'field' => 'label',
            'label' => 'Label',
            'rules' => 'trim|required|max_length[30]'
        ),
        'description' => array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim|required|max_length[100]'
        ),
        'link' => array(
            'field' => 'link',
            'label' => 'link',
            'rules' => 'trim|required|max_length[100]'
        ),
        'parent' => array(
            'field' => 'parent',
            'label' => 'Parent id',
            'rules' => 'trim|intval'
        )
    );

    /**
     * Format of htmlelements
     * array of available format for:
     * ordinary html class,
     * boostrap 3 class,...
     */
    public $_config_uri_string = '';
    public $_config_template_version = 'bootstrap3';
    public $_template_config = array(
        'default' => array(
            'ul_class' => '<ul>',
            'ul_class_dropdown' => '<ul>',
            'li' => '<li>',
            'li_class_active' => '<li class="active">',
            'li_class_dropdown' => '<li>',
            'li_class_dropdown_active' => '<li class="active">',
            'caret' => ''
        ),
        'bootstrap3' => array(
            'ul_class' => '<ul class="nav">',
            'ul_class_dropdown' => '<ul class="dropdown-menu">',
            'li' => '<li>',
            'li_class_active' => '<li class="active">',
            'li_class_dropdown' => '<li class="dropdown">',
            'li_class_dropdown_active' => '<li class="dropdown active">',
            'caret' => '<b class="caret">'
        )
    );



    public function __construct(){
        parent::__construct();
    }


    /**
     * Multi-level dynamic ordering of menu items
     * @param $parent
     * @return string
     */
    public function get_menu($parent=0)
    {
        $menu = $this->fetch_menu_array();
        $output = $this->build_menu($parent, $menu);
        return $output;
    }

    /**
     * format menu as html output
     * note!
     * Menu builder function, parentId 0 is the root
     * @param int $parent
     * @param $menu
     * @param bool $submenu
     * @return string
     */
    private function build_menu($parent =0, $menu, $submenu =FALSE)
    {
        // set template version
        $template = $this->_template_config[$this->_config_template_version];

        $html = "";
        if (isset($menu['parents'][$parent]))
        {
            // if method is pulled first time it's single parent class ul, else it's dropdown
            $html .= ($submenu) ? $template['ul_class_dropdown'] : $template['ul_class'];
            $i = 1;
            foreach ($menu['parents'][$parent] as $itemId)
            {

                // set active segment by menu link and uri
                $link = substr($menu['items'][$i]['link'],1);
                $active = $this->uri->uri_string() == $link ? TRUE : FALSE;
                // case parent without any children
                if(!isset($menu['parents'][$itemId]))
                {
                    // TODO zameniti sa config linijama
                    $html .= ($active && !$submenu) ? '<li class="active">' : '<li>';
                    $html .= "<a href='".$menu['items'][$itemId]['link']."'>".$menu['items'][$itemId]['label']."</a></li>";
                }
                // case parent with childrens
                if(isset($menu['parents'][$itemId]))
                {
                    $html .= "<li>";
                    $html .= "<a href='".$menu['items'][$itemId]['link']."'>".$menu['items'][$itemId]['label']."</a>";
                    $html .= $this->build_menu($itemId, $menu, TRUE);
                    $html .= "</li>";
                }
                $i ++;
            }
            $html .= "</ul>";
        }
        return $html;

    }

    /**
     * Method returns reordered array of menu items
     * and array of parents in single array
     * example:
     * array (size=2)
     *     'items' =>
                array (size=8)
                    1 =>
                        array (size=5)
                            'id' => string '1' (length=1)
                            'label' => string 'home' (length=4)
                            'parent' => string '0' (length=1)
                    2 =>
                        array (size=5)
                            'id' => string '2' (length=1)
                            'label' => string 'todo' (length=4)
                            'parent' => string '0' (length=1)
     *      'parents' =>
                array (size=3)
                    0 =>
                        array (size=4)
                            0 => string '1' (length=1)
                            1 => string '2' (length=1)
                        array (size=2)
                            0 => string '5' (length=1)
                            1 => string '6' (length=1)
     */
    private function fetch_menu_array()
    {
        //menjati funkcije redom

        // Select all entries from the menu table
        // $result=mysql_query("SELECT id, label, link, parent FROM menu ORDER BY parent, sort, label");

        $this->db->select('id,label,description,link,parent');
        $this->db->order_by('parent');
        $this->db->order_by('order');
        $this->db->order_by('label');
        $result = $this->db->get($this->_table)->result_array();

        // Create a multidimensional array to conatin a list of items and parents
        $menu = array(
            'items' => array(),
            'parents' => array()
        );

        // Builds the array lists with data from the menu table
        foreach ($result as $items) {
            // Creates entry into items array with current menu item id ie. $menu['items'][1]
            $menu['items'][$items['id']] = $items;
            // Creates entry into parents array. Parents array contains a list of all items with children
            $menu['parents'][$items['parent']][] = $items['id'];
        }
        return $menu;
    }

    //TODO create CRUD
    
}