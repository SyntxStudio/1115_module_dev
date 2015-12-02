<?php
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 26.11.2015
 * Time: 8:00
 * Skup funkcija za rad sa podacima baze
 */

/** ----------------------------------------------------------------------
 * Created by: Petar
 * Date: 26.11.2015
 * Time: 8:05
 * Desc: Funkcija uporedjuje dva niza i
 * prvi raw niz cisti od polja kojih nema u drugom nizu
 * Funkcija se moze koristiti pri novom unosu podataka
 * da bi se ocistila nepostojeca polja i izbegla greska
 * raw_data field => value, $expected_data array
 * -----------------------------------------------------------------------
 * @param $raw_data
 * @param $expected_data
 * @return array|bool
 */
function is_in_array($raw_data, $expected_data){
    if(!is_array($raw_data) || !is_array($expected_data)) {
        return false;
    } else {
        $new_data = array();
        foreach($raw_data as $key => $value){
            // pretrazuje po kljucevima
            if ($value != '' && in_array($key,array_values($expected_data))){
                $new_data[$key] = $value;
            }
        }
        return $new_data;
    }
}