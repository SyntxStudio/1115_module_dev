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
    public $_primary_key = 'id';

    /**
     * Default Filter for index key type
     */
    protected $_primary_filter = 'intval';

    /**
     * parent foreign key field name
     */
    protected $_parent_key = 'parent';

    /**
     * rest of table field names
     */
    protected $_label_name = 'label';
    protected $_order_name = 'order';
    protected $_link_name = 'link';
    protected $_description_name = 'description';

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
    public $_validation_rules = array(
        'label' => array(
            'field' => 'label',
            'label' => 'Label',
            'rules' => 'trim|required|max_length[30]'
        ),
        'description' => array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim|max_length[100]'
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
        ),
        'order' => array(
            'field' => 'order',
            'label' => 'order',
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
     * Creates new menuitem class
     */
    public function get_new()
    {
        $menuitem = new stdClass();
        $menuitem->label = '';
        $menuitem->description = '';
        $menuitem->link = '';
        $menuitem->parent = 0;
        $menuitem->order = 0;
        return $menuitem;
    }

    /**
     * Fetch menuitem by id, or all for id NULL
     * @param null $id
     * @param bool $single
     * @return
     */
    public function get_menuitem($id = NULL, $single = FALSE)
    {
        if ($id != NULL) {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->where($this->_primary_key, $id);
            $method = 'row';
        } elseif($single) {
            $method = 'row';
        } else {
            $method = 'result';
        }
        $this->db->order_by($this->_parent_key);
        $this->db->order_by($this->_order_name);
        return $this->db->get($this->_table)->$method();
    }

    /**
     * Method retrive single object from array of object by id
     * @param $data
     * @param $id
     * @return
     */
    public function menuitem_from_arr($data, $id)
    {
        $key = $this->_primary_key;
        foreach ($data as $item) {
            if($item->$key == $id){
                $result = $item;
            };
        }
        return $result;
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
                    $html .= "<a href='".$menu['items'][$itemId]['link']."'>".$menu['items'][$itemId][$this->_label_name]."</a></li>";
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
                    $html .= $menu['items'][$itemId][$this->_label_name];
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
     * @param int $parent
     * @param $menu
     * @param bool $submenu
     * @return string
     * @internal param $array
     * @internal param bool $child
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
                    $html .= '<li id="list_'. $menu['items'][$itemId][$this->_primary_key] .'">';
                    $html .= '<div class="items-group">';
                    $html .= $menu['items'][$itemId][$this->_label_name];
                    $html .= '<span class="link-edit"><a href="'.site_url('menuitems/edit/'.$menu['items'][$itemId][$this->_primary_key]).'"><img src="/assets/images/icons/Edit.svg" alt="edit"/></a></span>';
                    $html .= '<span class="link-delete"><a href="'.site_url('menuitems/delete/'.$menu['items'][$itemId][$this->_primary_key]).'"><img src="/assets/images/icons/Delete.svg" alt="delete"/></a></span>';
                    $html .= '</div>';
                    $html .= "</li>";
                }
                // case parent with childrens
                if(isset($menu['parents'][$itemId]))
                {
                    $html .= '<li id="list_'. $menu['items'][$itemId][$this->_primary_key] .'">';
                    $html .= '<div class="items-group">';
                    $html .= $menu['items'][$itemId][$this->_label_name];
                    $html .= '<span class="link-edit"><a href="'.site_url('menuitems/edit/'.$menu['items'][$itemId][$this->_primary_key]).'"><img src="/assets/images/icons/Edit.svg" alt="edit"/></a></span>';
                    $html .= '<span class="link-delete"><a href="'.site_url('menuitems/delete/'.$menu['items'][$itemId][$this->_primary_key]).'"><img src="/assets/images/icons/Delete.svg" alt="delete"/></a></span>';
                    $html .= '</div>';
                    $html .= $this->build_ajax_menu($itemId, $menu, TRUE);
                    $html .= "</li>";
                }
            }
            $html .= "</ol>";
        }
        return $html;
    }

    /**
     * Method saves order selected by AJAX call in menuitem/order_by_ajax
     */
    public function save_order($items)
    {
        if (count($items)) {
            foreach ($items as $order => $item) {
                if ($item['item_id'] != '') {
                    $data = array($this->_parent_key => (int) $item['parent_id'], $this->_order_name => $order);
                    $this->db->set($data)->where($this->_primary_key, $item['item_id']);
                    $this->db->update($this->_table);
                }
            }
        }
    }

    /**
     * Model for printing $parent options, not important
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

        $this->db->order_by($this->_parent_key);
        $this->db->order_by($this->_order_name);
        $result = $this->db->get($this->_table)->result_array();

        // Create a multidimensional array to conatin a list of items and parents
        $menu = array(
            'items' => array(),
            'parents' => array()
        );

        // Builds the array lists with data from the menu table
        foreach ($result as $items) {
            // Creates entry into items array with current menu item id ie. $menu['items'][1]
            $menu['items'][$items[$this->_primary_key]] = $items;
            // Creates entry into parents array. Parents array contains a list of all items with children
            $menu['parents'][$items[$this->_parent_key]][] = $items[$this->_primary_key];
        }
        return $menu;
    }


    /**
     * Method for inserting jQuery script into page
     * IMPORTANT: BOOTSTRAP ONLY!!!
     * Purpose: Script activates on hover dropdown and activates link in parent field
     */
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

    /**
     * Save method include insert method with blank id atribut
     * and update on provided id atribut
     * @param $data
     * @param null $id
     * @return int|null
     */
    public function save($data, $id = NULL)
    {
        // Insert
        if ($id == NULL){
            // set default value for order field to 0 in edit condition
            $data[$this->_order_name]=0;
            !isset($data[$this->_primary_key]) || $data[$this->_primary_key] == NULL;
            $this->db->insert($this->_table,$data);
            $id = $this->db->insert_id();
        }
        // Update
        else{
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->set($data);
            $this->db->where($this->_primary_key, $id);
            $this->db->update($this->_table);
        }
        return $id;

    }

    /** ----------------------------------------------------------------------
     * Created by: Petar
     * Date: 1.11.2015
     * Time: 22:44
     * Desc: Method deletes specified field by id
     *  if field is parent of other fields, those fields are then set to master
     * -----------------------------------------------------------------------
     * @param $id
     * @param bool $delete_children
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
        $item = $this->db->select($this->_parent_key)->where($this->_primary_key,$id)->get($this->_table)->row_array();
        // delete selected item
        if (count($item)){
            $this->db->where($this->_primary_key, $id);
            $this->db->limit(1);
            $this->db->delete($this->_table);
            // options to kill all ancestors or set them to upper parent
            if ($delete_children){
                // get id of all siblings with master parent with this id
                $result = $this->db->get($this->_table)->result_array();
                $arr_delete = $this->fetch_siblings($result, $id);
                // then delete all within array of id's
                $this->db->where_in($this->_primary_key, $arr_delete);
                $this->db->delete($this->_table);

            } else {
                // or reset any siblings to grandparent or 0
                // set to upper level
                $this->db->where($this->_parent_key,$id);
                $this->db->set(array($this->_parent_key=>$item[$this->_parent_key]));
                $this->db->update($this->_table);
            }
            return TRUE;
        }
    }

    /**
     * Method search entire array for siblings through n-level by provided $id
     * @param $array
     * @param $parent_id
     * @return array
     */
    private function fetch_siblings($array, $parent_id)
    {
        $result = array();
        foreach ($array as $item) {
            // ako ima zapisa po uslovu id parenta krenuti upis u privremeni niz
            if($item[$this->_parent_key] == $parent_id){
                $result[] = $item[$this->_primary_key];
                // ako ima zapisa u $siblingu ponovo provozati i dodati arr_delete
                $siblings = $this->fetch_siblings($array, $item[$this->_primary_key]);
                if(count($siblings)){
                    foreach($siblings as $sibling){
                        $result[] = $sibling;
                    }
                }
            }
        }
        return $result;
    }

    /**
     * Method set value for each field from post
     * @param $fields
     * @return array
     */
    public function array_from_post($fields){
        $data = array();
        foreach ($fields as $field) {
            $data[$field] = $this->input->post($field);
        }
        return $data;
    }
}