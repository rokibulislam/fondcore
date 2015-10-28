


<?php

/**
 * Plugin Name: Fondecore Management
 * Plugin URI: http://www.frndzit.com
 * Description: Fondecore Management Plugin.
 * Version: 1.0.0
 * Author: Tj Thouhid
 * Author URI: http://www.facebook.com/tjthouhid
 * Text Domain: Optional. Plugin's text domain for localization. Example: mytextdomain
 * Domain Path: Optional. Plugin's relative directory path to .mo files. Example: /locale/
 * Network: Optional. Whether the plugin can only be activated network wide. Example: true
 * License: GPL2
 */


global $jal_db_version;
$jal_db_version = '1.0';

function fondcore_activate() {

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    global $wpdb;
    global $jal_db_version;


    $dbtable_name = $wpdb->prefix .  'fondo_aso_cdat';
    $dbtable_name2 = $wpdb->prefix . 'fondo_aso_code';
    $dbtable_name3 = $wpdb->prefix . 'fondo_aso_cupo';
    $dbtable_name4 = $wpdb->prefix . 'fondo_aso_depo';
    $dbtable_name5 = $wpdb->prefix . 'fondo_aso_extr';
    $dbtable_name6 = $wpdb->prefix . 'fondo_aso_mail';
    $dbtable_name7 = $wpdb->prefix . 'fondo_aso_otro';
    $dbtable_name8 = $wpdb->prefix . 'fondo_aso_prestamo';
    $dbtable_name9 = $wpdb->prefix . 'fondo_aso_total';
    $dbtable_name10 = $wpdb->prefix . 'fondo_liveuser_users';
    $dbtable_name11 = $wpdb->prefix . 'fondo_liveuser_groupusers';
    $dbtable_name12 = $wpdb->prefix . 'fondo_lineacredito';
    $dbtable_name13 = $wpdb->prefix . 'fondo_secciones';
    $dbtable_name14 = $wpdb->prefix . 'fondo_subsecciones';
    
    /*
     * We'll set the default character set and collation for this table.
     * If we don't do this, some characters could end up being converted 
     * to just ?'s when saved in our table.
     */
    $charset_collate = '';

    if ( ! empty( $wpdb->charset ) ) {
      $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
    }

    if ( ! empty( $wpdb->collate ) ) {
      $charset_collate .= " COLLATE {$wpdb->collate}";
    }

    $sql="CREATE TABLE IF NOT EXISTS `$dbtable_name` (
          `cedula` varchar(100) NOT NULL,
          `num_cdat` double NOT NULL,
          `fecha_consti` date DEFAULT NULL,
          `fecha_venci` date DEFAULT NULL,
          `tiempo_pactado` double DEFAULT NULL,
          `tasa_pactada` double DEFAULT NULL,
          `saldo_cdat` double DEFAULT NULL
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1; ";
    dbDelta( $sql );


    $sql2="CREATE TABLE IF NOT EXISTS `$dbtable_name2` (
            `cedula` varchar(20) NOT NULL,
            `cedula_codeudor` varchar(20) NOT NULL,
            `tipo_asociado` varchar(10) NOT NULL,
            `nombre` varchar(200) NOT NULL,
            `num_prestamo` varchar(20) NOT NULL,
            `valor_solicitado` double NOT NULL,
            `saldo_prestamo` double NOT NULL,
            `categoria_mora` varchar(10) NOT NULL,
            `num_codeudores` int(11) NOT NULL,
            `porcenta_compromiso` double NOT NULL,
            `valor_compromiso` double NOT NULL,
            KEY `cedula` (`cedula`,`cedula_codeudor`)
          ) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
    dbDelta( $sql2 );

    $sql3="CREATE TABLE IF NOT EXISTS `$dbtable_name3` (
      `cedula` varchar(20) NOT NULL,
      `linea_credito` varchar(100) NOT NULL,
      `valor_cupo` double NOT NULL,
      `cuota_cupo` double NOT NULL,
      `num_cuotas` int(11) NOT NULL,
      KEY `cedula` (`cedula`)
     ) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
     
     dbDelta($sql3);

    
    $sql4="CREATE TABLE IF NOT EXISTS `$dbtable_name4` (
            `cedula` varchar(20) NOT NULL,
            `nombre_cuenta` varchar(200) NOT NULL,
            `valor_cuenta` double DEFAULT '0',
            `saldo_cuenta` double DEFAULT '0',
            `porcenta_cuenta` double DEFAULT '0'
          ) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
    dbDelta($sql4);

    $sql5="CREATE TABLE IF NOT EXISTS `$dbtable_name5` (
          `cedula` varchar(20) NOT NULL,
          `num_prestamo` varchar(20) NOT NULL,
          `linea_credito` varchar(100) DEFAULT NULL,
          `fecha_vencimiento` date NOT NULL,
          `valor_cuota` double NOT NULL,
          KEY `cedula` (`cedula`),
          KEY `cedula_2` (`cedula`)
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
    dbDelta($sql5);

    
    $sql6="CREATE TABLE IF NOT EXISTS `$dbtable_name6` (
            `cedula` varchar(20) NOT NULL,
            `email` varchar(150) NOT NULL,
            KEY `cedula` (`cedula`)
          ) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
    
    dbDelta($sql6);


     $sql7="CREATE TABLE IF NOT EXISTS `$dbtable_name7` (
        `cedula` varchar(20) NOT NULL,
        `nombre_cuenta` varchar(100) NOT NULL,
        `fecha_inicial` date DEFAULT NULL,
        `fecha_final` date DEFAULT NULL,
        `valor_cuenta` double NOT NULL,
        `saldo_cuenta` double DEFAULT NULL
      ) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
     
     dbDelta($sql7);


     $sql8="CREATE TABLE IF NOT EXISTS `$dbtable_name8` (
            `cedula` varchar(20) NOT NULL,
            `num_prestamo` varchar(20) NOT NULL,
            `linea_credito` varchar(100) NOT NULL,
            `valor_cuota` double NOT NULL,
            `valor_desembolso` double NOT NULL,
            `saldo_prestamo` double NOT NULL,
            `porcenta_pagado` double NOT NULL,
            `num_cuotas` int(11) NOT NULL,
            `fecha_desembolso` date NOT NULL,
            `fecha_vencimiento` date NOT NULL,
            `codeudor1` varchar(100) DEFAULT NULL,
            `codeudor2` varchar(100) DEFAULT NULL,
            `codeudor3` varchar(100) DEFAULT NULL,
            `coduedor4` varchar(100) DEFAULT NULL,
            `codeudor5` varchar(100) DEFAULT NULL,
            KEY `cedula` (`cedula`),
            KEY `num_prestamo` (`num_prestamo`)
          ) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
     
     dbDelta($sql8);


     $sql9="CREATE TABLE IF NOT EXISTS `$dbtable_name9` (
            `cedula` varchar(20) NOT NULL,
            `dig_verificacion` int(11) NOT NULL,
            `cod_nomina` varchar(50) DEFAULT NULL,
            `nombre` varchar(200) NOT NULL,
            `empresa` varchar(100) NOT NULL,
            `ciudad` varchar(100) NOT NULL,
            `regional` varchar(100) DEFAULT NULL,
            `oficina` varchar(100) DEFAULT NULL,
            `fecha_afiliacion` date NOT NULL,
            `total_saldos_aportes` double NOT NULL DEFAULT '0',
            `total_saldos_prestamos` double NOT NULL DEFAULT '0',
            `total_cuotas_aportes` double NOT NULL DEFAULT '0',
            `total_cuotas_prestamos` double NOT NULL DEFAULT '0',
            `total_cuotas_otros` double NOT NULL DEFAULT '0',
            `sueldo` double NOT NULL DEFAULT '0',
            `total_cuota_descuento` double NOT NULL DEFAULT '0',
            `porcenta_endeuda` double NOT NULL DEFAULT '0',
            `cupo_total` double NOT NULL DEFAULT '0',
            `cupo_real` double NOT NULL DEFAULT '0',
            `total_codeudas` double NOT NULL DEFAULT '0',
            KEY `cedula` (`cedula`)
          ) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
     
     dbDelta($sql9);





    $sql10="CREATE TABLE IF NOT EXISTS `$dbtable_name10` (
          `authuserid` int(11) NOT NULL AUTO_INCREMENT,
          `nombre` varchar(150) DEFAULT '',
          `apellido` varchar(100) DEFAULT NULL,
          `apellido2` varchar(100) DEFAULT NULL,
          `handle` varchar(32) NOT NULL DEFAULT '',
          `passwd` varchar(32) NOT NULL DEFAULT '',
          `owner_user_id` int(11) DEFAULT '0',
          `owner_group_id` int(11) DEFAULT '0',
          `lastlogin` datetime DEFAULT '1970-01-01 00:00:00',
          `isactive` tinyint(1) NOT NULL DEFAULT '1',
          `perm_type` smallint(6) NOT NULL DEFAULT '0',
          `cedula` varchar(20) DEFAULT NULL,
          `email` varchar(100) DEFAULT NULL,
          `generate` int(11) DEFAULT '0',
          `valid` varchar(200) DEFAULT NULL,
          PRIMARY KEY (`authuserid`),
          UNIQUE KEY `ak_unq_handle` (`handle`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
     
    dbDelta($sql10);


    $sql11="CREATE TABLE IF NOT EXISTS `$dbtable_name11` (
      `group_user_id` int(11) NOT NULL AUTO_INCREMENT,
      `perm_user_id` int(11) NOT NULL DEFAULT '0',
      `group_id` int(11) NOT NULL DEFAULT '0',
      PRIMARY KEY (`group_user_id`),
      UNIQUE KEY `unq_group_user` (`group_id`,`perm_user_id`),
      KEY `perm_user_id` (`perm_user_id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
     
    dbDelta($sql11);

    $sql12="CREATE TABLE IF NOT EXISTS `$dbtable_name12` (
      `idCredito` int(11) NOT NULL,
      `nombre` varchar(100) DEFAULT NULL,
      `tasa1` double DEFAULT NULL,
      `tasa13` double DEFAULT NULL,
      `tasa25` double DEFAULT NULL,
      `tasa37` double DEFAULT NULL,
      `tasa49` double DEFAULT NULL,
      `tasa61` double DEFAULT NULL
    ) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;";

    dbDelta($sql12);

    $sql13="CREATE TABLE IF NOT EXISTS `$dbtable_name13` (
          `idseccion` int(11) NOT NULL,
          `titulo` varchar(150) NOT NULL,
          `orden` int(11) DEFAULT NULL,
          `contenido` text,
          `link` varchar(100) DEFAULT NULL,
          `menu1` int(11) DEFAULT NULL,
          `menu2` int(11) DEFAULT NULL,
          `vercontent` int(11) DEFAULT '1',
          `visible` int(11) DEFAULT '1'
        ) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;";

    dbDelta($sql13);
    


    $sqll4="CREATE TABLE IF NOT EXISTS `$dbtable_name14` (
          `idsubseccion` int(11) NOT NULL,
          `titulo` varchar(150) NOT NULL,
          `orden` int(11) DEFAULT NULL,
          `contenido` text,
          `link` varchar(100) DEFAULT NULL,
          `idseccion` int(11) NOT NULL,
          `isactive` int(11) DEFAULT '1',
          `mostrar` int(11) DEFAULT '1',
          `vercontent` int(11) DEFAULT '1'
        ) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;";

    dbDelta($sql14);



    add_option( 'jal_db_version', $jal_db_version );
}
register_activation_hook( __FILE__, 'fondcore_activate' );


// End Of Db Create


add_action('admin_menu', 'theme_options_panel');
function theme_options_panel(){
  add_menu_page('Fondecore Manage', 'Fondecore', 'administrator','fondecore_options', 'fondecore_setting',get_template_directory_uri().'/fondecore/images/icon.png' ,6);
  add_submenu_page( 'fondecore_options', 'Usuarios', 'Usuarios', 'manage_options', 'usuarios', 'manage_users');
  //add_submenu_page( 'fondecore_options', 'FAQ page title', 'FAQ menu label', 'manage_options', 'theme-op-faq', 'wps_theme_func_faq');
  add_submenu_page( 'fondecore_options', 'Secciones', 'Secciones', 'manage_options', 'secciones', 'manage_Secciones');
  add_submenu_page( 'fondecore_options', 'subsecciones', 'subsecciones', 'manage_options', 'subsecciones', 'manage_subsecciones');
  
  add_submenu_page( 'fondecore_options', 'datos', 'datos', 'manage_options', 'datos', 'manage_Datos');
  add_submenu_page( 'fondecore_options', 'lineas', 'lineas', 'manage_options', 'lineas', 'manage_lineas');

}

function manage_lineas(){
     global $wpdb;
     
     if(isset($_GET['add_lineas'])){
     
      $nombre=$_POST['nombre'];
      $tasa1=$_POST['tasa1'];
      $tasa13=$_POST['tasa13'];
      $tasa25=$_POST['tasa25'];
      $tasa37=$_POST['tasa37'];
      $tasa49=$_POST['tasa49'];
      $tasa61=$_POST['tasa61'];
      $table_name = $wpdb->prefix . 'fondo_lineacredito';
      $sql2="INSERT INTO $table_name (`idCredito`,`nombre`,`tasa1`,`tasa13`,`tasa25`,
      `tasa37`,`tasa49`,`tasa61`) VALUES
      (Null, '$nombre', '$tasa1','$tasa13','$tasa25','$tasa37','$tasa49','$tasa61')";
      $wpdb->get_results( $sql2 );
      //header("Location:".admin_url()."admin.php?page=fit_slider_menu&slides=".$slide_id);
      ?>
      <script type="text/javascript">
      var url="<?php echo admin_url().'admin.php?page=lineas&result=add';?>";
      window.location=url;
      </script>
<?php 
      
    }else if(isset($_GET['update_lineas'])){
      
      $idCredito=$_GET['update_lineas'];
      $nombre=$_POST['nombre'];
      $tasa1=$_POST['tasa1'];
      $tasa13=$_POST['tasa13'];
      $tasa25=$_POST['tasa25'];
      $tasa37=$_POST['tasa37'];
      $tasa49=$_POST['tasa49'];
      $tasa61=$_POST['tasa61'];

      if(isset($_POST['visible'])){
        $visible=$_POST['visible'];
      }

      if(isset($_POST['activo'])){
        $activo=$_POST['activo'];
      }
      $table_name = $wpdb->prefix . 'fondo_lineacredito';

      
      $sql3="UPDATE $table_name SET  nombre='$nombre',tasa1='$tasa1',tasa13='$tasa13',
      tasa25='$tasa25',tasa37='$tasa37',tasa49='$tasa49',tasa61='$tasa61' WHERE idCredito='$idCredito'";
      $wpdb->get_results( $sql3);

      //header("Location:".admin_url()."admin.php?page=fit_slider_menu&slides=".$slide_id);
      ?>
      <script type="text/javascript">
      var url="<?php echo admin_url().'admin.php?page=lineas&result=edit';?>";
      window.location=url;
      </script>

   <?php }
   else if(isset($_GET['delete_lineas'])){
           $idCredito=$_GET['delete_lineas'];
           $table_name = $wpdb->prefix . 'fondo_lineacredito';
           $sql4="DELETE FROM $table_name WHERE idCredito='$idCredito'";
           $wpdb->get_results( $sql4);?>

      <script type="text/javascript">
      var url="<?php echo admin_url().'admin.php?page=lineas&result=delete';?>";
      window.location=url;
      </script>
  <?php }
  require_once('template/manage_lineas.php');

}


function manage_Datos(){

  // require_once(ABSPATH . 'wp-admin' . '/includes/image.php');
  // require_once(ABSPATH . 'wp-admin' . '/includes/file.php');
  // require_once(ABSPATH . 'wp-admin' . '/includes/media.php');

  global $wpdb;
       if(isset($_GET['add_datos'])){

          $tipo=$_POST['tipo'];
          $date=$_POST['date'];

           $target_dir = wp_upload_dir();
          echo $target_dir['path'];
          //.'/fondecore/uploads/';exit;
         $target_file = $target_dir['path'].'/' . basename($_FILES["file"]["name"]);
          if (file_exists($target_file)) {
             echo "Sorry, file already exists.";
          }
          if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
              echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
          } else {
              echo "Sorry, there was an error uploading your file.";
          }

         switch($tipo){
            case 1:
              scriptAsoc($target_file);
              break;
            case 2:
              scriptTotal($target_file);
              break;
            case 3:
              scriptDepo($target_file);
              break;  
            case 4:
              scriptPres($target_file);
              break;
            case 5:
              scriptExtr($target_file);
              break;
            case 6:
              scriptCode($target_file);
              break;
            case 7:
              scriptOtro($target_file);
              break;
            case 8:
              scriptCupo($target_file);
              break;
            case 9:
              scriptMail($target_file);
              break;
            case 10:
              scriptCdat($target_file);
              break;  
        }

      //header("Location:".admin_url()."admin.php?page=fit_slider_menu&slides=".$slide_id);
      ?>
      <script type="text/javascript">
      var url="<?php echo admin_url().'admin.php?page=datos&result=add';?>";
      window.location=url;
      </script>
<?php 
      
    }else if(isset($_GET['update_datos'])){


      //header("Location:".admin_url()."admin.php?page=fit_slider_menu&slides=".$slide_id);
      ?>
      <script type="text/javascript">
      var url="<?php echo admin_url().'admin.php?page=datos&result=edit';?>";
      window.location=url;
      </script>

   <?php }
   else if(isset($_GET['delete_datos'])){
          /* $idsubseccion=$_GET['delete_subsecciones'];
           $table_name = $wpdb->prefix . 'subsecciones';
           $sql4="DELETE FROM $table_name WHERE idsubseccion='$idsubseccion'";
           $wpdb->get_results( $sql4);*/
    ?>

      <script type="text/javascript">
        var url="<?php echo admin_url().'admin.php?page=datos&result=delete';?>";
        window.location=url;
      </script>
  <?php }
  require_once('template/manage_datos.php');
}

function manage_subsecciones(){
   global $wpdb;
     
     if(isset($_GET['add_subsecciones'])){
     
      $idseccion=$_POST['seccion'];
      $title=$_POST['title'];
      $link=$_POST['link'];
      $order=$_POST['order'];
      $vercontent=$_POST['vercontent'];
      $contenido=$_POST['sectextarea'];

      if(isset($_POST['visible'])){
        $visible=$_POST['visible'];
      }

      if(isset($_POST['activo'])){
        $activo=$_POST['activo'];
      }


      $table_name = $wpdb->prefix . 'fondo_subsecciones';
      $sql2="INSERT INTO $table_name (`idsubseccion`,`titulo`,`orden`,`contenido`,`link`,
      `idseccion`,`isactive`,`mostrar`,`vercontent`) VALUES
      (NULL, '$title', '$order','$contenido','$link','$idseccion','$visible','$activo','$vercontent')";

      echo $sql2;
      exit();

      $wpdb->get_results( $sql2 );
      //header("Location:".admin_url()."admin.php?page=fit_slider_menu&slides=".$slide_id);
      ?>
      <script type="text/javascript">
      var url="<?php echo admin_url().'admin.php?page=subsecciones&result=add';?>";
      window.location=url;
      </script>
<?php 
      
    }else if(isset($_GET['update_subsecciones'])){
      $idsubseccion=$_GET['update_subsecciones'];
      $idseccion=$_POST['seccion'];
      $title=$_POST['title'];
      $link=$_POST['link'];
      $order=$_POST['order'];
      $vercontent=$_POST['vercontent'];
      $contenido=$_POST['sectextarea'];

      if(isset($_POST['visible'])){
        $visible=$_POST['visible'];
      }

      if(isset($_POST['activo'])){
        $activo=$_POST['activo'];
      }
      $table_name = $wpdb->prefix . 'fondo_subsecciones';

      
      $sql3="UPDATE $table_name SET  titulo='$title',orden='$order',vercontent='$vercontent',
      link='$link',contenido='$contenido',isactive=$visible,mostrar=$activo,idseccion='$idseccion' WHERE idsubseccion='$idsubseccion'";

      $wpdb->get_results( $sql3);

      //header("Location:".admin_url()."admin.php?page=fit_slider_menu&slides=".$slide_id);
      ?>
      <script type="text/javascript">
      var url="<?php echo admin_url().'admin.php?page=subsecciones&result=edit';?>";
      window.location=url;
      </script>

   <?php }
   else if(isset($_GET['delete_subsecciones'])){
           $idsubseccion=$_GET['delete_subsecciones'];
           $table_name = $wpdb->prefix . 'fondo_subsecciones';
           $sql4="DELETE FROM $table_name WHERE idsubseccion='$idsubseccion'";
           $wpdb->get_results( $sql4);?>

      <script type="text/javascript">
      var url="<?php echo admin_url().'admin.php?page=subsecciones&result=delete';?>";
      window.location=url;
      </script>
  <?php }
  require_once('template/manage_subSecciones.php');

}

function manage_Secciones(){
  global $wpdb;
     
     if(isset($_GET['add_secciones'])){
     
      $title=$_POST['title'];
      $link=$_POST['link'];
      $order=$_POST['order'];
      $show=$_POST['show'];
      if(isset($_POST['visible'])){
        $visible=$_POST['visible'];
      }
      if(isset($_POST['menu1'])){
        $menu1=$_POST['menu1'];
      }
      if(isset($_POST['menu2'])){
        $menu2=$_POST['menu2'];
      }

      $sectextarea=$_POST['sectextarea'];
      $table_name = $wpdb->prefix . 'fondo_secciones';
      $sql2="INSERT INTO $table_name (`idseccion`, `titulo`, `orden`, `vercontent`, `link`, `menu1`, `menu2`,`contenido`, `visible`) VALUES
      (Null, '$title', '$order', '$show','$link','$menu1','$menu2', '$sectextarea','$visible')";
      $wpdb->get_results( $sql2 );
      //header("Location:".admin_url()."admin.php?page=fit_slider_menu&slides=".$slide_id);
      ?>
      <script type="text/javascript">
      var url="<?php echo admin_url().'admin.php?page=secciones&result=add';?>";
      window.location=url;
      </script>
<?php 
      
    }else if(isset($_GET['update_secciones'])){
        
      $idseccion=$_GET['update_secciones'];
      $title=$_POST['title'];
      $link=$_POST['link'];
      $order=$_POST['order'];
      $show=$_POST['show'];
      if(isset($_POST['visible'])){
        $visible=$_POST['visible'];
      }
      if(isset($_POST['menu1'])){
        $menu1=$_POST['menu1'];
      }
      if(isset($_POST['menu2'])){
        $menu2=$_POST['menu2'];
      }
      $sectextarea=$_POST['sectextarea'];
      $table_name = $wpdb->prefix . 'fondo_secciones';

      
      $sql3="UPDATE $table_name SET  titulo='$title',orden='$order',vercontent='$show',
      link='$link',menu1='$menu1',menu2='$menu2',contenido='$sectextarea',visible='$sectextarea' WHERE idseccion='$idseccion'";

      $wpdb->get_results( $sql3);
      //header("Location:".admin_url()."admin.php?page=fit_slider_menu&slides=".$slide_id);
      ?>
      <script type="text/javascript">
      var url="<?php echo admin_url().'admin.php?page=secciones&result=edit';?>";
      window.location=url;
      </script>

   <?php }
   else if(isset($_GET['delete_secciones'])){
           $idseccion=$_GET['delete_secciones'];
           $table_name = $wpdb->prefix . 'fondo_secciones';
           $sql4="DELETE FROM $table_name WHERE idseccion='$idseccion'"; 
           $wpdb->get_results( $sql4);?>

      <script type="text/javascript">
      var url="<?php echo admin_url().'admin.php?page=secciones&result=delete';?>";
      window.location=url;
      </script>
  <?php }
  require_once('template/manage_Secciones.php');
}

function wps_theme_func(){
                echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
                <h2>Theme</h2></div>';
}
function wps_theme_func_settings(){
                echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
                <h2>Settings</h2></div>';
}
function wps_theme_func_faq(){
                echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
                <h2>FAQ</h2></div>';
}


function setup_theme_admin_menus() {
	//add_menu_page( 'Fondecore', 'Fondecore', '','fondecore', 'fondecore_setting', '', 6 );
	//add_menu_page( 'Fondecore', 'Fondecore menu', 'manage_options', 'myplugin/myplugin-admin.php', '', plugins_url( 'myplugin/images/icon.png' ), 6 );

    // add_submenu_page('themes.php', 
    //     'Front Page Elements', 'Front Page', 'manage_options', 
    //     'front-page-elements', 'theme_front_page_settings'); 
}

function fondecore_setting(){

}
function manage_users(){
  global $wpdb;

   if(isset($_GET['add_user'])){
     
      $nombre=$_POST['nombre'];
      $apellido=$_POST['apellido'];
      $apellido2=$_POST['apellido2'];
      $handle=$_POST['handle'];
      $email=$_POST['email'];
      $passwd=$_POST['passwd'];
      $isactive=$_POST['isactive'];
    
      $table_name = $wpdb->prefix . 'fondo_liveuser_users';
      $sql2="INSERT INTO $table_name (`authuserid`, `nombre`, `apellido`, `apellido2`, `handle`, `passwd`, `owner_user_id`, `owner_group_id`, `lastlogin`, `isactive`, `perm_type`, `cedula`, `email`, `generate`, `valid`) VALUES
      (Null, '$nombre', '$apellido', '$apellido2', '$handle', '$passwd', 0, 0, '', '$isactive', 0, '$handle', '$email', 0, NULL)";
     
      

      $wpdb->get_results( $sql2 );
      
      //header("Location:".admin_url()."admin.php?page=fit_slider_menu&slides=".$slide_id);
      ?>
      <script type="text/javascript">
      var url="<?php echo admin_url().'admin.php?page=usuarios&result=add';?>";
      window.location=url;
      </script>
<?php 
      
    }else if(isset($_GET['update_user'])){
        
      $authorid=$_GET['update_user'];
      $nombre=$_POST['nombre'];
      $apellido=$_POST['apellido'];
      $apellido2=$_POST['apellido2'];
      $handle=$_POST['handle'];
      $email=$_POST['email'];
      $passwd=$_POST['passwd'];
      $isactive=$_POST['isactive'];
      $table_name = $wpdb->prefix . 'fondo_liveuser_users';

      
      $sql3="UPDATE $table_name SET  nombre='$nombre',apellido='$apellido',apellido2='$apellido2',
      handle='$handle',passwd='$passwd',email='$email',isactive='$isactive' WHERE authuserid='$authorid'";
      // echo $sql3;
      // exit();
      $wpdb->get_results( $sql3);
      //header("Location:".admin_url()."admin.php?page=fit_slider_menu&slides=".$slide_id);
      ?>
      <script type="text/javascript">
      var url="<?php echo admin_url().'admin.php?page=usuarios&result=edit';?>";
      window.location=url;
      </script>

   <?php }
   else if(isset($_GET['delete_user'])){
           $authorid=$_GET['delete_user'];
           $table_name = $wpdb->prefix . 'fondo_liveuser_users';
           $sql4="DELETE FROM $table_name WHERE authuserid='$authorid'"; 
           $wpdb->get_results( $sql4);?>

      <script type="text/javascript">
      var url="<?php echo admin_url().'admin.php?page=usuarios&result=delete';?>";
      window.location=url;
      </script>
  <?php }
	require_once('template/manage_users.php');

}



function scriptAsoc($file){
    
    global $wpdb;
  
  $mensaje="Se realizo la carga satisfactoria del archivo ASO";
  
  if(file_exists($file)){
    $fp = fopen($file,r);
    while($row = fgetcsv($fp,0,";")){
      $nr=count($row);
      $row=str_replace("","",$row);
      if ($nr == 3){
      $cedula = trim($row[0]);

        $table_name = $wpdb->prefix . 'fondo_liveuser_users';
        $sql="SELECT * FROM $table_name WHERE handle='$cedula'";
        $user = $wpdb->get_results( $sql );
        
        $row[1]=str_ireplace("7","/",$row[1]);
        $nombres = explode('/',$row[1],3);
        
        $data = array(
          'nombre' => trim($nombres[2]),
          'apellido' => trim($nombres[0]),
          'apellido2' => trim($nombres[1]),
        );

        
        if(count($user) == 0){
         
          $data['handle'] = $cedula;
          $data['cedula'] = $cedula;
          $data['passwd'] = $cedula;
          $data['is_active'] = 1;
          $data['perm_type'] = 1;

          $wpdb->insert($table_name,$data);
           $insert_id= $wpdb->insert_id;
         // $insert = $luadmin->addUser($data);

         /* if ($insert === false){
            $error = $luadmin->getErrors();
          }else{
            $group = array(
              'perm_user_id' => $insert,
              'group_id' => 2,
            );
            $added = $luadmin->perm->addUserToGroup($group);
          }*/

          $group_table=$wpdb->prefix . 'fondo_liveuser_groupusers';

          $group=array('perm_user_id' =>$insert_id,'group_id'=>2);

          $wpdb->insert($group_table,$data);

        }else{
          
           
         //  $permuser = $user[0]['perm_user_id'];
           $wpdb->update($table_name, $data,array( 'authuserid' =>$user[0]['authuserid']));
         //  $update = $luadmin->updateUser($data,$permuser);
          //print_r($update);
        }
      }else{
        $mensaje="Datos importados con algunos errores";
        $bad_data[] = $row;
        //break;
      }
    }
    fclose($fp);
    unlink($file);
  }else{
    $mensaje="El archivo no existe o no subio correctamente";
  }
}


function scriptTotal($file){
  
    global $wpdb;
  if(file_exists($file)){
    $fp = fopen($file,r);
    while($row = fgetcsv($fp,0,";")){
      $datos[]=str_replace("´","",$row);
      $nr= count($row);
    }
    fclose($fp);
    unlink($file);
  }
  
  if($nr < 21){
    $mensaje="El numero de columnas no corresponde al formato TOTAL";
  }
  else{ 
    if($datos){
     // $usr  = new Users($dsn);
       $table_name = $wpdb->prefix . 'fondo_aso_total';
      $sql = "DELETE FROM $table_name WHERE 1>0";
      $wpdb->get_results( $sql );
    //  $usr->execute($sql);
      foreach($datos as $dt)
      {
        $datfecha= explode("/",$dt[8]);
        $fecha=$datfecha[2]."-".$datfecha[1]."-".$datfecha[0];
        
        $sqlin= "INSERT INTO $table_name ( cedula, dig_verificacion, cod_nomina, nombre, empresa,ciudad, regional, oficina, fecha_afiliacion,total_saldos_aportes, total_saldos_prestamos, total_cuotas_aportes, total_cuotas_prestamos, total_cuotas_otros, sueldo, total_cuota_descuento, porcenta_endeuda, cupo_total, cupo_real, total_codeudas) ";
        $sqlin.= "VALUES('".$dt[0]."','".$dt[1]."','".$dt[2]."','".$dt[3]."','".$dt[4]."','".$dt[5]."','".$dt[6]."','".$dt[7]."','".$fecha."','".$dt[9]."','".$dt[10]."','".$dt[11]."','".$dt[12]."','".$dt[13.]."','".$dt[14]."','".$dt[15]."','".$dt[16]."','".$dt[17]."','".$dt[18]."','".$dt[19]."')"; 
        $wpdb->get_results($sqlin);//
       // $usr->execute($sqlin);
        //print_r($sqlin);
      } 
      $mensaje="Se realizo la carga satisfactoria del archivo TOTAL";
    }
    else
      $mensaje="Error en el formato del archivo TOTAL";
  }   
//  print_r($datos);
  
}

function scriptDepo($file){
    
  
    global $wpdb;
  
  if(file_exists($file))
  {
    $fp = fopen($file,r);
    while($row = fgetcsv($fp,0,";"))
    {
      
      $datos[]=str_replace("´","",$row);
      $nr= count($row);
      
    }
    fclose($fp);
    
    unlink($file);
  }
  
  if($nr < 6){
    $mensaje="El numero de columnas no corresponde al formato DEPO";
  }
  else
  { 
    if($datos)
    {
      /*$usr  = new Users($dsn);
      $sql = "DELETE FROM aso_depo WHERE 1>0";
      $usr->execute($sql);*/
      $table_name = $wpdb->prefix . 'fondo_aso_depo';
      $sql = "DELETE FROM $table_name WHERE 1>0";
      $wpdb->get_results( $sql );
      foreach($datos as $dt)
      {
        $datfecha= explode("/",$dt[6]);
        $fecha=$datfecha[2]."-".$datfecha[1]."-".$datfecha[0];
        
        $sqlin= "INSERT INTO $table_name ( cedula, nombre_cuenta, valor_cuenta, saldo_cuenta, porcenta_cuenta) ";
        $sqlin.= "VALUES('".$dt[0]."','".$dt[1]."','".$dt[2]."','".$dt[3]."','".$dt[4]."')"; 
        
      //  $usr->execute($sqlin);
        $wpdb->get_results($sqlin);
        //print_r($sqlin);
      } 
      $mensaje="Se realizo la carga satisfactoria del archivo DEPO";
    }
    else
      $mensaje="Error en el formato del archivo DEPO";
  }   
//  print_r($datos);
  
}

function scriptPres($file){
    
  
    global $wpdb;
  
  if(file_exists($file))
  {
    $fp = fopen($file,r);
    while($row = fgetcsv($fp,0,";"))
    {
      
      $datos[]=str_replace("´","",$row);
      $nr= count($row);
    }
    fclose($fp);
  }
  
  if($nr < 15){
    $mensaje="El numero de columnas no corresponde al formato CODE";
  }
  else
  {
  if($datos)
  {
   /* $usr  = new Users($dsn);
    $sql = "DELETE FROM aso_prestamo WHERE 1>0";
    $usr->execute($sql);*/
    $table_name = $wpdb->prefix . 'fondo_aso_prestamo';
    $sql = "DELETE FROM $table_name WHERE 1>0";
    $wpdb->get_results( $sql );
    foreach($datos as $dt)
    {
      $datfecha= explode("/",$dt[8]);
      $fecha=$datfecha[2]."-".$datfecha[1]."-".$datfecha[0];
      
      $datfecha= explode("/",$dt[9]);
      $fecha2=$datfecha[2]."-".$datfecha[1]."-".$datfecha[0];
      
      $sqlin= "INSERT INTO $table_name ( cedula, num_prestamo, linea_credito, valor_cuota, valor_desembolso, saldo_prestamo, porcenta_pagado, num_cuotas, fecha_desembolso, fecha_vencimiento, codeudor1, codeudor2, codeudor3, coduedor4, codeudor5) ";
      $sqlin.= "VALUES('".$dt[0]."','".$dt[1]."','".$dt[2]."','".$dt[3]."','".$dt[4]."','".$dt[5]."','".$dt[6]."','".$dt[7]."','".$fecha."','".$fecha2."','".$dt[10]."','".$dt[11]."','".$dt[12]."','".$dt[13.]."','".$dt[14]."')"; 
      $wpdb->get_results($sqlin);
     // $usr->execute($sqlin);
      //print_r($sqlin);
    }
  $mensaje="Se realizo la carga satisfactoria del archivo PRES";
  }
  else
    $mensaje="Error en el formato del archivo PRES";  
  } 
//  print_r($datos);
}
function scriptExtr($file){
  
    global $wpdb;
  if(file_exists($file))
  {
    $fp = fopen($file,r);
    while($row = fgetcsv($fp,0,";"))
    {
      
      $datos[]=str_replace("´","",$row);
      $nr=count($row);
    }
    fclose($fp);
    unlink($file);
  }
  
  if($nr < 5){
    $mensaje="El numero de columnas no corresponde al formato EXTR";
  }
  else
  {
  if($datos)
  {
  
   /* $usr  = new Users($dsn);
    $sql = "DELETE FROM aso_extr WHERE 1>0";
    $usr->execute($sql);*/
    $table_name = $wpdb->prefix . 'fondo_aso_extr';
    $sql = "DELETE FROM $table_name WHERE 1>0";
    $wpdb->get_results( $sql );
    foreach($datos as $dt)
    {
      $datfecha= explode("/",$dt[3]);
      $fecha=$datfecha[2]."-".$datfecha[1]."-".$datfecha[0];
      
      
      $sqlin= "INSERT INTO $table_name ( cedula, num_prestamo, linea_credito, fecha_vencimiento, valor_cuota) ";
      $sqlin.= "VALUES('".$dt[0]."','".$dt[1]."','".$dt[2]."','".$fecha."','".$dt[4]."')"; 
      $wpdb->get_results($sqlin);
     // $usr->execute($sqlin);
      //print_r($sqlin);
    }
    
  $mensaje="Se realizo la carga satisfactoria del archivo EXTR";
  }
  else
    $mensaje="Error en el formato del archivo EXTR";
//  print_r($datos);
  }
}

function scriptCode($file){
    
    global $wpdb;
  
  
  if(file_exists($file))
  {
    $fp = fopen($file,r);
    while($row = fgetcsv($fp,0,";"))
    {
      
      $datos[]=str_replace("´","",$row);
      $nr=count($row);
    }
    fclose($fp);
    unlink($file);
  }
  
  
  if($nr < 11){
    $mensaje="El numero de columnas no corresponde al formato CODE";
  }
  else
  { 
  
  if($datos)
  {
    /*$usr  = new Users($dsn);
    $sql = "DELETE FROM aso_code WHERE 1>0";
    $usr->execute($sql);*/
   /* $table_name = $wpdb->prefix . 'aso_code';
    $sql = "DELETE FROM $table_name WHERE 1>0";
    $wpdb->get_results( $sql );*/
     $table_name = $wpdb->prefix . 'fondo_aso_code';
    $sql = "DELETE FROM $table_name WHERE 1>0";
    $wpdb->get_results( $sql );
    foreach($datos as $dt)
    {
      $sqlin= "INSERT INTO $table_name ( cedula, cedula_codeudor, tipo_asociado, nombre, num_prestamo, valor_solicitado, saldo_prestamo, categoria_mora, num_codeudores, porcenta_compromiso, valor_compromiso) ";
      $sqlin.= "VALUES('".$dt[0]."','".$dt[1]."','".$dt[2]."','".$dt[3]."','".$dt[4]."','".$dt[5]."','".$dt[6]."','".$dt[7]."','".$dt[8]."','".$dt[9]."','".$dt[10]."')"; 
      $wpdb->get_results($sqlin);
      //$usr->execute($sqlin);
      //print_r($sqlin);
    } 
    $mensaje="Se realizo la carga satisfactoria del archivo CODE";
  }
  else
    $mensaje="Error en el formato del archivo CODE";
  } 
}

function scriptOtro($file){
    
  
    global $wpdb;
  
  if(file_exists($file))
  {
    $fp = fopen($file,r);
    while($row = fgetcsv($fp,0,";"))
    {
      
      $datos[]=str_replace("´","",$row);
      $nr =count($row);
      
    }
    fclose($fp);
    unlink($file);
  }
  
  if($nr < 4){
    $mensaje="El numero de columnas no corresponde al formato CODE";
  }
  else
  {
  if($datos)
  {
    /*$usr  = new Users($dsn);
    $sql = "DELETE FROM aso_otro WHERE 1>0";
    $usr->execute($sql);*/
    $table_name = $wpdb->prefix . 'fondo_aso_otro';
    $sql = "DELETE FROM $table_name WHERE 1>0";
    $wpdb->get_results( $sql );
    foreach($datos as $dt)
    {
      
        $datfecha= explode("/",$dt[2]);
        $fecha=$datfecha[2]."-".$datfecha[1]."-".$datfecha[0];
        $datfecha2= explode("/",$dt[3]);
        $fecha2=$datfecha2[2]."-".$datfecha2[1]."-".$datfecha2[0];
      
      $sqlin= "INSERT INTO $table_name ( cedula, nombre_cuenta, fecha_inicial, fecha_final, valor_cuenta, saldo_cuenta) ";
      $sqlin.= "VALUES('".(int)($dt[0])."','".$dt[1]."','".$fecha."','".$fecha2."','".$dt[4]."','".$dt[5]."')"; 
      $wpdb->get_results($sqlin);
      //$usr->execute($sqlin);
      //print_r($sqlin);
    } 
    $mensaje="Se realizo la carga satisfactoria del archivo OTRO";
  }
  else
    $mensaje="Error en el formato del archivo OTRO";
//  print_r($datos);
  }
}

function scriptCupo($file){
    
    global $wpdb;
  
  
  if(file_exists($file))
  {
    $fp = fopen($file,r);
    while($row = fgetcsv($fp,0,";"))
    {
      
      $datos[]=str_replace("´","",$row);
      $nr = count($row);
    }
    fclose($fp);
    unlink($file);
  }
  
  if($nr < 5){
    $mensaje="El numero de columnas no corresponde al formato CUPO";
  }
  else
  {
  
  if($datos)
  {
   /* $usr  = new Users($dsn);
    $sql = "DELETE FROM aso_cupo WHERE 1>0";
    $usr->execute($sql);*/
      $table_name = $wpdb->prefix . 'fondo_aso_cupo';
      $sql = "DELETE FROM $table_name WHERE 1>0";
      $wpdb->get_results( $sql );
    foreach($datos as $dt)
    {
      $sqlin= "INSERT INTO $table_name ( cedula, linea_credito, valor_cupo, cuota_cupo, num_cuotas) ";
      $sqlin.= "VALUES('".$dt[0]."','".$dt[1]."','".$dt[2]."','".$dt[3]."','".$dt[4]."')"; 
      
      $a= $wpdb->get_results($sqlin);
      //print_r($sqlin);
    } 
    $mensaje="Se realizo la carga satisfactoria del archvio CUPO";
  }
  else
    $mensaje="Error en el formato del archivo CUPO";
//  print_r($datos);
  }
}

function scriptMail($file){
      global $wpdb;
  if(file_exists($file))
  {
    $fp = fopen($file,r);
    while($row = fgetcsv($fp,0,";"))
    {
      
      $datos[]=str_replace("´","",$row);
      $nr = count($row);
    }
    fclose($fp);
    unlink($file);
  }
  
  if($nr < 2){
    $mensaje="El numero de columnas no corresponde al formato CODE";
  }
  else
  {
  if($datos)
  {
   // $usr  = new Users($dsn);
      $table_name = $wpdb->prefix . 'fondo_aso_mail';
      $sql = "DELETE FROM $table_name WHERE 1>0";
      $wpdb->get_results( $sql );
   // $usr->execute($sql);
    foreach($datos as $dt)
    {
      $sqlin= "INSERT INTO $table_name ( cedula, email) ";
      $sqlin.= "VALUES('".$dt[0]."','".$dt[1]."')"; 
      $wpdb->get_results($sqlin);
      //$usr->execute($sqlin);
      //print_r($sqlin);
    } 
    $mensaje="Se realizo la carga satisfactoria del archvio MAIL";
  }
  else
    $mensaje="Error en el formato del archivo MAIL";
//  print_r($datos);
  }
}

function scriptCdat($file){
   global $wpdb;
  if(file_exists($file))
  {
    $fp = fopen($file,r);
    while($row = fgetcsv($fp,0,";"))
    {
      
      $datos[]=str_replace("´","",$row);
      $nr= count($row);
    }
    fclose($fp);
    unlink($file);
  }
  
  if($nr < 6){
    $mensaje="El numero de columnas no corresponde al formato CDAT";
  }
  else
  { 
    if($datos)
    {
     // $usr  = new Users($dsn);
      
      $table_name = $wpdb->prefix . 'fondo_aso_cdat';
      $sql = "DELETE FROM aso_cdat WHERE 1>0";
      $wpdb->get_results( $sql );
    //  $usr->execute($sql);
      foreach($datos as $dt)
      {
        $datfecha= explode("/",$dt[2]);
        $fecha=$datfecha[2]."-".$datfecha[1]."-".$datfecha[0];
        $datfecha2= explode("/",$dt[3]);
        $fecha2=$datfecha2[2]."-".$datfecha2[1]."-".$datfecha2[0];
        
        $sqlin= "INSERT INTO $table_name ( cedula, num_cdat, fecha_consti, fecha_venci, tiempo_pactado, tasa_pactada, saldo_cdat) ";
        $sqlin.= "VALUES('".(int)($dt[0])."','".$dt[1]."','".$fecha."','".$fecha."','".$dt[4]."','".$dt[5]."','".$dt[6]."')"; 
        $wpdb->get_results($sqlin);
       // $usr->execute($sqlin);
        //print_r($sqlin);
      } 
      $mensaje="Se realizo la carga satisfactoria del archivo CDAT";
    }
    else
      $mensaje="Error en el formato del archivo CDAT";
  }   
//  print_r($datos);

}

function fondo_login($atts, $content = null) {
    extract(shortcode_atts(array(
        "id" => ''
    ), $atts));
    global $wpdb;
    include_once("template/login.php");
}
add_shortcode('fondo_login', 'fondo_login');

function fondo_user($atts, $content = null) {
    extract(shortcode_atts(array(
        "id" => ''
    ), $atts));
    global $wpdb;
    include_once("template/fondo_user.php");
}
add_shortcode('fondo_user', 'fondo_user');


add_action('admin_post_submit-login-form', '_handle_form_action'); // If the user is logged in
add_action('admin_post_nopriv_submit-login-form', '_handle_form_action'); // If the user in not logged in
function _handle_form_action(){
  global $wpdb;
 

   $cedula=$_POST['user_name'];
   $pass=$_POST['pass'];

   $table_name = $wpdb->prefix . 'fondo_liveuser_users';
   $sql="SELECT * FROM $table_name WHERE handle='$cedula' and passwd='$pass'";
   $user = $wpdb->get_results( $sql );
   if(count($user)>0){
    $nombre=$user[0]->nombre;
    $apellido=$user[0]->apellido;
    $apellido2=$user[0]->apellido2;
    $handle=$user[0]->handle;
    $email=$user[0]->email;
    //echo site_url();
     setcookie('front_cedula', $cedula,0,'/');
     setcookie('front_handle', $handle,0,'/');
     setcookie('front_nombre', $nombre,0,'/');
     setcookie('front_apellido', $apellido,0,'/');
     setcookie('front_apellido2', $apellido2,0,'/');
     setcookie('front_email', $email,0,'/');

     
               
    wp_redirect(site_url().'?page_id=5212' );
   }else{
    setcookie('front_error', "Wrong Usuario/Contraseña",0,'/');
    wp_redirect(site_url().'?page_id=5212' );
   }

}

add_action('admin_post_submit-logout-form', '_handle_form_action2'); // If the user is logged in
add_action('admin_post_nopriv_submit-logout-form', '_handle_form_action2'); // If the user in not logged in
function _handle_form_action2(){


  setcookie('front_cedula', "",time()-3600,'/');
  setcookie('front_handle', "",time()-3600,'/');
  setcookie('front_nombre', "",time()-3600,'/');
  setcookie('front_apellido', "",time()-3600,'/');
  setcookie('front_apellido2', "",time()-3600,'/');
  setcookie('front_email', "",time()-3600,'/');
  unset ($_COOKIE['front_cedula']);
  unset ($_COOKIE['front_handle']);
  unset ($_COOKIE['front_nombre']);
  unset ($_COOKIE['front_apellido']);
  unset ($_COOKIE['front_apellido2']);
  unset ($_COOKIE['front_email']);
  wp_redirect(site_url());

}







?>

<style>
	.gdlr-lms-pagination > a, .gdlr-lms-pagination span { background: #72a3cf; color: #fff;
    padding: 10px; display: inline-block; margin-top: 20px; margin-left: 3px; text-decoration: none; }
.gdlr-lms-pagination span{ border: 1px solid #72a3cf; background: transparent; color: #72a3cf; padding: 9px; }
.gdlr-lms-pagination { text-align: right; }

.page-numbers{background: #72a3cf; color: #fff;
    padding: 10px; display: inline-block; margin-top: 20px; margin-left: 3px; text-decoration: none;}
</style>