<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 25.11.2015
 * Time: 17:09
 * Purpose: config klasa koja sadrzi sve uslove za validaciju ulaznog modela
 */

/**
 * Promenljiva koja definise naziv metode kontrolera
 * - promeniti naziv po potrebi
 */
$put_filters = 'demo_put';
$post_filters = 'demo_post';

/**
 * Konfiguracija validacije
 */
$config = array(
    $put_filters => array(
        'email' => array(
            'field' => 'email',
            'label' => 'email',
            'rules' => 'required|trim|valid_email|is_unique[demo.email]'
        ),
        'password' => array(
            'field' => 'password',
            'label' => 'password',
            'rules' => 'required|trim|min_length[8]|max_length[16]|password_hash'
        ),
        'phone' => array(
            'field' => 'phone',
            'label' => 'phone',
            'rules' => 'required|trim|alpha_dash'
        ),
        'ip_adress' => array(
            'field' => 'ip_adress',
            'label' => 'ip_adress',
            'rules' => 'required|trim|min_length[10]|max_length[15]'
        )
    ),
    $post_filters => array(
        'email' => array(
            'field' => 'email',
            'label' => 'email',
            'rules' => 'trim|valid_email|is_unique[demo.email]'
        ),
        'phone' => array(
            'field' => 'phone',
            'label' => 'phone',
            'rules' => 'trim|alpha_dash'
        ),
        'ip_adress' => array(
            'field' => 'ip_adress',
            'label' => 'ip_adress',
            'rules' => 'trim|min_length[10]|max_length[15]'
        )
    )
);