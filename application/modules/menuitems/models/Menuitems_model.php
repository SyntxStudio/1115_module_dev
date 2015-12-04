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

class Menuitems_model extends CI_Model
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
     * Variable for compare uri and active string
     * If value in field table link equals same uri string then
     * manu item class is active
     * please select from controller which URI segment matces field link
     * default 1
     */
    public $_config_uri_string = '';

    /**
     * Choose predefined template configuration
     * available options: in sets $_template_config array
     * default: bootstrap3
     */
    public $_config_template_version = 'bootstrap3';

    /**
     * onclick link active (tweak for bootstrap3)
     * DESC: Optional js script function for parent link:
     * menu dropdown - on hover, with active parent link
     *
     * NOTE: Use only as option for Bootstrap3!!
     *
     * REASON: bs3 by default discard master link a href,
     * instead uses click as dropdown
     * OPTIONS: TRUE / FALSE;
     */
    public $_config_active_parent_link = FALSE;

    /**
     * Format of htmlelements
     * array of available format for:
     * ordinary html class,
     * boostrap 3 class,...
     */
    public $_template_config = array(
        'default' => array(
            'ul_class' => '<ul>',
            'ul_class_dropdown' => '<ul class="dropdown">',
            'li' => '<li>',
            'li_class_active' => '<li class="active">',
            'li_class_dropdown' => '<li>',
            'li_class_dropdown_active' => '<li class="active">',
        ),
        'bootstrap3' => array(
            'ul_class' => '<ul class="nav navbar-nav">',
            'ul_class_dropdown' => '<ul class="dropdown-menu">',
            'li' => '<li>',
            'li_class_active' => '<li class="active">',
            'li_class_dropdown' => '<li class="dropdown">',
            'li_class_dropdown_active' => '<li class="dropdown active">',
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
    public function get_menu($parent = 0)
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
    private function build_menu($parent = 0, $menu, $submenu =FALSE)
    {
        // set template version
        $template = $this->_template_config[$this->_config_template_version];

        $html = "";
        if (isset($menu['parents'][$parent]))
        {
            // check for sript bootstrap tweak parent link active
            $html .= ($this->_config_active_parent_link)? $this->js_dropdown_onclick() : "";

            // if method is pulled first time it's single parent class ul, else it's dropdown
            $html .= ($submenu) ? $template['ul_class_dropdown'] : $template['ul_class'];
            $i = 1;
            foreach ($menu['parents'][$parent] as $itemId)
            {
                // set active segment by menu link and uri
                $link = (isset($menu['items'][$i]['link']))?$menu['items'][$i]['link']:FALSE;
                $active = $this->uri->uri_string() == $link ? TRUE : FALSE;
                // case parent without any children
                if(!isset($menu['parents'][$itemId]))
                {
                    $html .= ($active && !$submenu) ? $template['li_class_active'] : '<li>';
                    $html .= "<a href='".$menu['items'][$itemId]['link']."'>".$menu['items'][$itemId]['label']."</a></li>";
                }
                // case parent with childrens
                if(isset($menu['parents'][$itemId]))
                {
                    $html .= $template['li_class_dropdown'];
                    $html .= '<a href="' . $menu['items'][$itemId]['link'] . '"';
                    // TODO napraviti uslov ako je bootstrap ili ostalo
                    $html .= ' class="dropdown-toggle" data-toggle="dropdown"';
                    $html .= ' role="button" aria-haspopup="true" aria-expanded="false"';
                    // TODO gornja dva reda
                    $html .= '>';
                    $html .= $menu['items'][$itemId]['label'];
                    // TODO takodje napraviti uslov ako je bootstrap
                    $html .= '<span class="caret"></span>';
                    // TODO dovde
                    $html .= '</a>';
                    $html .= $this->build_menu($itemId, $menu, TRUE);
                    $html .= "</li>";
                }
                $i ++;
            }
            $html .= "</ul>";
        }
        return $html;
    }

    public function get_ajax_menu()
    {
        $menu = $this->fetch_menu_array();
        $output = $this->build_ajax_menu(0, $menu);
        return $output;
    }

    /**
     * Method return menu in htlm string for jQuery nested sortable functions
     * @param $menu
     * @param bool $submenu
     * @internal param $array
     * @internal param bool $child
     * @return string
     */
    public function build_ajax_menu($parent = 0, $menu, $submenu = FALSE)
    {
        $html = '';
        if (isset($menu['parents'][$parent]))
        {
            // if method is pulled first time it's single parent class ul, else it's dropdown
            $html .= ($submenu) ? '<ol>' : '<ol class="sortable">';
            foreach ($menu['parents'][$parent] as $itemId)
            {
                // case parent without any children
                if(!isset($menu['parents'][$itemId]))
                {
                    $html .= '<li id="list_'. $menu['items'][$itemId]['id'] .'">';
                    $html .= '<div>' .$menu['items'][$itemId]['label']. '</div>';
                    $html .= "</li>";
                }
                // case parent with childrens
                if(isset($menu['parents'][$itemId]))
                {
                    $html .= '<li id="list_'. $menu['items'][$itemId]['id'] .'">';
                    $html .= '<div>' .$menu['items'][$itemId]['label']. '</div>';
                    $html .= $this->build_ajax_menu($itemId, $menu, TRUE);
                    $html .= "</li>";
                }
            }
            $html .= "</ol>";
        }
        return $html;
    }


    /**
     * Method pulls selected or all fields
     * and order them in jQuery sortable format
     * @param null $fields
     * @return array
     */
    public function get_nested ($fields = NULL)
    {
        // if provided set only selected fields
        if ($fields !== NULL){
            $this->db->select($fields);
        }
        $this->db->order_by('order');
        $items = $this->db->get($this->_table)->result_array();
        // parents first
        $array = array();
        foreach ($items as $item) {
            if (!$item['parent']) {
                $array[$item['id']] = $item;
            }
        }
        // zatim childovi
        foreach ($items as $item) {
            if ($item['parent']) {
                $array[$item['parent']]['children'][] = $item;
            }
        }
        //return $array;
        $result = $this->get_ol($array);
        echo $result;
    }

    /**
     * Probna funkcija da bi provalio raspored
     * i kreiranje elemenata za nested Sortable
     */
    function get_ol($array, $child = FALSE)
    {
        $str = '';
        if (count($array)) {
            $str .= $child == FALSE ? '<ol class="sortable">' : '<ol>';

            foreach ($array as $item) {
                $str .= '<li id="list_' . $item['id'] .'">';
                $str .= '<div>' . $item['label'] .'</div>';

                // Do we have any children?
                if (isset($item['children']) && count($item['children'])) {
                    $str .= $this->get_ol($item['children'], TRUE);
                }

                $str .= '</li>' . PHP_EOL;
            }

            $str .= '</ol>' . PHP_EOL;
        }

        return $str;
    }

    /**
     * Method saves order selected by AJAX call in menuitem/order_by_ajax
     */
    public function save_order($items)
    {
        if (count($items)) {
            foreach ($items as $order => $item) {
                if ($item['item_id'] != '') {
                    $data = array('parent' => (int) $item['parent_id'], 'order' => $order);
                    $this->db->set($data)->where($this->_primary_key, $item['item_id']);
                    $this->db->update($this->_table);
                }
            }
        }
    }

    /**
     * Model for printing $parent options
     */
    public function available_parents()
    {
        $str = 'Available <$parent> options:<br/>';
        $menu = $this->fetch_menu_array();
        foreach ($menu['parents'] as $key=>$value) {
            $str .= $key . '<br/>';
        }
        return $str;
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

    private function js_dropdown_onclick(){
        $str = "";
        $str .= "<script>
            jQuery(function($) {
                if($(window).width()>769){
                    $('.navbar .dropdown').hover(function() {
                        $(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();
                    }, function() {
                        $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp();
                    });
                    $('.navbar .dropdown > a').click(function(){
                    location.href = this.href;
                    });
                }
            });
            </script>";
        return $str;
    }

    //TODO create CRUD
    /**
     * Save method include insert method with blank id atribut
     * and update on provided id atribut
     * @param null $id
     */
    public function save($id = NULL)
    {

    }

    /** ----------------------------------------------------------------------
     * Created by: Petar
     * Date: 1.11.2015
     * Time: 22:44
     * Desc: Method deletes specified field by id
     *  if field is parent of other fields, those fields are then set to master
     * -----------------------------------------------------------------------
     * @param $id
     * @return bool|void
     */

    public function delete($id = NULL, $delete_children = FALSE)
    {
        //filter $id for specific type
        $filter = $this->_primary_filter;
        $id = $filter($id);

        // first delete selected field
        if (!$id){
            return FALSE;
        }
        // then fetch items parent number (default for 0)
        $item = $this->db->select('parent')->where($this->_primary_key,$id)->get($this->_table)->row_array();
        // delete selected item
        if (count($item)){
            $this->db->where($this->_primary_key, $id);
            $this->db->limit(1);
            $this->db->delete($this->_table);
            // options to kill all ancestors or set them to upper parent
            if ($delete_children){
                // TODO get id of all siblings with master parent with this id
                $this->db->where('parent', $id);
                // then delete all within array of id's
            } else {
                // or reset any siblings to grandparent or 0
                // set to upper level
                $this->db->where('parent',$id);
                $this->db->set(array('parent'=>$item['parent']));
                $this->db->update($this->_table);
            }
            return TRUE;
        }
    }
}