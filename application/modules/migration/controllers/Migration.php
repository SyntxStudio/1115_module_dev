<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Petar
 * Date: 24.10.2015
 * Time: 5:26
 * Purpose: Protected klasa za kontrolu nad migracijama
 * Kontroller se direktno obraca biblioteci system/library/migration
 * i config fajlu application/config/migration
 * Bitno je napomenuti da se broj migracije u nazivu mora poklopiti
 * sa brojem u konfig fajlu.
 * Sam kontroler se mora zastiti sa admin proverom kao i da se samo
 * sme pokrenuti u delop okruzenju
 */

class Migration extends MY_Controller{

    public function __construct(){
        parent::__construct();
        // TODO obavezno ubaciti admin proveru

        // Provera ako je stranica na pub serveru ne ucitava se biblioteka
        if(ENVIRONMENT!='development'){
            redirect('/', 'refresh');
        } else {
            $this->load->library('migration');
        }
    }

    /** -------------------------------------
     | Created by: Petar
     | Date: 24.10.2015
     | Time: 5:45
     | Desc: Metoda index sluzi da se pokrene controller sa
     |       zadatom migracijom
     |       (podesavanje trnutne migracije se vrsi u
     |        application/config/migrations.php)
    -----------------------------------------*/
    public function index()
    {
        if ($this->migration->current() === FALSE)
        {
            show_error($this->migration->error_string());
            echo $this->migration_error_tips();
        }elseif($this->migration->latest() === $this->migration->current()){
            echo '<h2>Obavestenje</h2>';
            echo '<p>Ovo je trenutna migracija, nema potrebe za ponovnim pokretanjem</p>';
        }
        else {
            echo '<h2>Migracija uspela!</h2>';
            echo '<div><a href="/">povratak</a></div>';
        }
    }

    /** ----------------------------------------------------------------------
     * Created by: Petar
     * Date: 25.11.2015
     * Time: 12:53
     * Desc: Metoda omogucava pokretanje migracije po broju
    -----------------------------------------------------------------------*/
    public function goto_migration($version)
    {
        if ($version != $this->migration->current()){
            $this->migration->version($version);
            echo '<h2>Migracija uspela!</h2>';
            echo '<div><a href="/">povratak</a></div>';
        } else {
            echo '<h2>Obavestenje</h2>';
            echo '<p>Ovo je trenutna migracija, nema potrebe za ponovnim pokretanjem</p>';
        }
    }


    /** ----------------------------------------------------------------------
     * Created by: Petar
     * Date: 25.11.2015
     * Time: 12:54
     * Desc: Metoda vraca broj zadnje pokrenute migracije
    -----------------------------------------------------------------------*/
    public function latest()
    {
        echo '<h2>Poslednje pokrenuta migracija: ' . $this->migration->latest() .'</h2>';
    }

    private function migration_error_tips(){
        $err_str = "";
        $err_str .= 'Enviroment mora da se poklapa sa razvojnim okruzenjem.';
        $err_str .= 'Proveriti da li se broj migracije poklapa sa trenutno pozvanom.';
        $err_str .= 'Za detaljnije informacije o gresci proveriti error_log';
        return $err_str;
    }


}