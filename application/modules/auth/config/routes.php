<?php
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 26.11.2015
 * Time: 16:19
 */

/**
 * Dodato preusmeravanje za Ion Auth
 * Izvor: http://stackoverflow.com/questions/6352980/using-ion-auth-as-a-separate-module-in-the-hmvc-structure
 */
$route['auth/(:any)'] = "auth/$1";