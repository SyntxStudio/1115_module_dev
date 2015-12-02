<?php
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 26.11.2015
 * Time: 13:54
 */
/**
 * -------------------------------------------------------------------------
 * Metods for rerouting curent application
 * -------------------------------------------------------------------------
 * If module and controller have samo name
 * uri will be site_url/controller/method
 *
 * Example:
 * $route['module_name'] = 'controller_name';
 * $route['module_name/controller/:any'] = 'controller_name/$1';
 */
$route['translate_uri_dashes'] = TRUE;

/**
 * -------------------------------------------------------------------------
 * Sample REST API Routes
 * -------------------------------------------------------------------------
 */
//$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
//$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
