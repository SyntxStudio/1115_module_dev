<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - Croatian
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Translation: Petar
*		pro.sport@yahoo.com
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.14.2010
*
* Description:  Serbian language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful'] 	  	 = 'Nalog je uspješno kreiran';
$lang['account_creation_unsuccessful'] 	 	 = 'Nalog nije kreiran';
$lang['account_creation_duplicate_email'] 	 = 'Email je već iskorišćen ili pogrešan';
$lang['account_creation_duplicate_identity'] = 'Korisničko ime je već iskorišćeno ili pogrešno';
$lang['account_creation_missing_default_group'] = 'Podrazumevana grupa nije podešena';
$lang['account_creation_invalid_default_group'] = 'Pogrešan naziv za podrazumevanu grupu';

// Password
$lang['password_change_successful'] 	 	 = 'Lozinka uspešno promenjena';
$lang['password_change_unsuccessful'] 	  	 = 'Lozinka nije promenjena';
$lang['forgot_password_successful'] 	 	 = 'Email za poništavanje lozinke je poslat';
$lang['forgot_password_unsuccessful'] 	 	 = 'lozinka nije poništena';

// Activation
$lang['activate_successful'] 		  	     = 'Račun je aktiviran';
$lang['activate_unsuccessful'] 		 	     = 'Aktiviranje računa nije uspelo';
$lang['deactivate_successful'] 		  	     = 'Račun je deaktiviran';
$lang['deactivate_unsuccessful'] 	  	     = 'De-aktivacija računa nije uspela';
$lang['activation_email_successful'] 	  	 = 'Email za aktivaciju je poslat';
$lang['activation_email_unsuccessful']   	 = 'Slanje mail za aktivaciju nije uspelo';

// Login / Logout
$lang['login_successful'] 		  	         = 'Uspešno ste prijavljeni';
$lang['login_unsuccessful'] 		  	     = 'Prijava nije uspela';
$lang['login_unsuccessful_not_active'] 		 = 'Račun nije aktivan';
$lang['login_timeout']                       = 'Trenutno ste blokirani. Pokušajte kasnije.';
$lang['logout_successful'] 		 	         = 'Uspješno ste odjavljeni';

// Account Changes
$lang['update_successful'] 		 	         = 'Podaci o računu uspešno su ažurirani';
$lang['update_unsuccessful'] 		 	     = 'Podaci o računu nisu ažurirani';
$lang['delete_successful'] 		 	         = 'Korisnik je obrisan';
$lang['delete_unsuccessful'] 		 	     = 'Brisanje korisnika nije uspelo';

// Groups
$lang['group_creation_successful']  = 'Grupa uspešno kreirana';
$lang['group_already_exists']       = 'Naziv grupe je zauzet';
$lang['group_update_successful']    = 'Ažurirani detalji grupe';
$lang['group_delete_successful']    = 'Grupa obrisana';
$lang['group_delete_unsuccessful'] 	= 'Brisanje grupe neuspešno';
$lang['group_delete_notallowed']    = 'Brisanje administratorske grupe nespešno';
$lang['group_name_required'] 		= 'Obavezno polje za naziv grupe';
$lang['group_name_admin_not_alter'] = 'naziv Admin grupe se ne može menjati';

// Activation Email
$lang['email_activation_subject']            = 'Aktivacija naloga';
$lang['email_activate_heading']    = 'Aktivirajte nalog za %s';
$lang['email_activate_subheading'] = 'Kliknite na link za %s.';
$lang['email_activate_link']       = 'Aktivirajte nalog';
// Forgot Password Email
$lang['email_forgotten_password_subject']    = 'Potvrda o zaboravljenoj lozinci';
$lang['email_forgot_password_heading']    = 'Obnovi šifru za %s';
$lang['email_forgot_password_subheading'] = 'Kliknite na link za %s.';
$lang['email_forgot_password_link']       = 'Obnovite šifru';
// New Password Email
$lang['email_new_password_subject']          = 'Nova šifra';
$lang['email_new_password_heading']    = 'Nova šifra za %s';
$lang['email_new_password_subheading'] = 'Vaša nova šifra je: %s';
