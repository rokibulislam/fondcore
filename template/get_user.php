<?php 
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/wp-config.php");
 global $wpdb;
 $user_id=$_POST['user_id'];
 $table_name = $wpdb->prefix . 'fondo_liveuser_users';
 $sql="SELECT * FROM $table_name where authuserid='$user_id'";
 $myrows = $wpdb->get_results( $sql );
$mystr="";
foreach ( $myrows as $myrow ) {
			
			$mystr.=$myrow->nombre;
			$mystr.="-&-";
			$mystr.=$myrow->apellido;
			$mystr.="-&-";
			$mystr.=$myrow->apellido2;
			$mystr.="-&-";
			$mystr.=$myrow->handle;
			$mystr.="-&-";
			$mystr.=$myrow->passwd;
			$mystr.="-&-";
			$mystr.=$myrow->email;
			$mystr.="-&-";
			$mystr.=$myrow->isactive;
}

		echo $mystr;
		die();		
?>