<?php
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 26.11.2015
 * Time: 9:42
 */

/** ----------------------------------------------------------------------
 * Created by: Petar
 * Date: 26.11.2015
 * Time: 9:43
 * Desc: Funkcija za generisanje password kljuca
 * trenutno se korist BLOWFISH PHP5.5 enkripcija
-----------------------------------------------------------------------*/
function hash_password($password)
{
    return password_hash($password,PASSWORD_DEFAULT);
}