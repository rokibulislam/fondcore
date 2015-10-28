<?php if(isset($_COOKIE['front_cedula'])){ ?>
<!--HI, Mr <?php// echo $_COOKIE['front_nombre']; ?> -->
<?php } 


	if(!isset($_COOKIE['front_cedula'])){
		$msj="Para descargar su estado de cuenta debe iniciar sesi&oacute;n";
		$bd=0;
		}else{

		$table_name = $wpdb->prefix . 'fecha';
		$sql="SELECT fecha FROM $table_name";
		$fecha = $wpdb->get_results( $sql );
		$fechaa=$fecha[0]->fecha;
		
		$cedula=$_COOKIE['front_cedula'];	
		$meses=array('01'=>"Enero",'02'=>"Febrero",'03'=>"Marzo",'04'=>"Abril",'05'=>"Mayo",'06'=>"Junio",'07'=>"Julio",'08'=>"Agosto",
					'09'=>"Septiembre",'10'=>"Octubre",'11'=>"Noviembre",'12'=>"Diciembre");
		/*$dia=date('N');
		$ndia=date('d');
		$mes=date('n');
		$a=date('Y');*/
		$dtf = explode("-",$fechaa);			
/*		$dia=date('N');
		$ndia=date('d');
		$mes=date('n');
		$a=date('Y');*/
		$ndia=$dtf[2];
		$mes=$dtf[1];
		$a=$dtf[0];
		$fecha=$meses[$mes]." ".$ndia." de ".$a;
		
		// $us= new Total($dsn);
		// $datDepo = $us->get($cedula);
		$table_name2 = $wpdb->prefix . 'fondo_aso_total';
		$sql2="SELECT * FROM $table_name2 where cedula= '$cedula'";
		$datDepo = $wpdb->get_results( $sql2 );
		//print_r($datDepo);
		
		//$fechaa=$fecha[0]->fecha;
		
		//if($datDepo){
		if(count($datDepo)>0){
		
			//****Saldos depo*//
			
			// $dts = new Depo($dsn);
			// $dts->setWhere(" cedula ='$cedula'");
			//$datosSaldos = $dts->getAll();
			$table_name3 = $wpdb->prefix . 'fondo_aso_depo';
			$sql3="SELECT * FROM $table_name3 where cedula= '$cedula'";
			$datosSaldos = $wpdb->get_results( $sql3 );

			// echo "<pre>";
			// print_r($datosSaldos);exit;


			
			
		
			//$datos=calculoAnti($datDepo['fecha_afiliacion'],date('Y-m-d'));
			$datos=calculoAnti($datDepo[0]->fecha_afiliacion);
			
			
			$fecha=$meses[$mes]." ".$ndia." de ".$a;
			$datDepo[0]->fecha_afiliacion = formato($datDepo[0]->fecha_afiliacion);

		//	print_r($datDepo['fecha_afiliacion']);
			// Prestamos
			
					
			// $pr = new Prestamo($dsn);
			// $pr->setWhere("cedula=$cedula");
			// $dprs=$pr->getAll();
			$table_name4 = $wpdb->prefix . 'fondo_aso_prestamo';
			$sql4="SELECT * FROM $table_name4 where cedula= '$cedula'";
			$dprs = $wpdb->get_results( $sql4 );
			echo "<pre>";
			print_r($dprs);//exit;

			//foreach($dprs as $tm=>$prs)

			foreach ( $dprs as $tm=>$prs ) {
			{
				// $dprs[$tm]['fecha_vencimiento']=formato($prs['fecha_vencimiento']);
				// $dprs[$tm]['fecha_desembolso']=formato($prs['fecha_desembolso']);

				$dprss[$tm]->fecha_vencimiento=formato($prs->fecha_vencimiento);
				$dprss[$tm]->fecha_desembolso=formato($prs->fecha_desembolso);
			}	
			echo "<pre>";
			print_r($dprs);exit;
			///Cdats
			
			// $cdt = new Cdat($dsn);
			// $cdt->setWhere("cedula = '$cedula'");
			// $cda= $cdt->getAll();
			$table_name5 = $wpdb->prefix . 'fondo_aso_cdat';
			$sql5="SELECT * FROM $table_name5 where cedula= '$cedula'";
			$cdas = $wpdb->get_results( $sql5 );
			
			$totcda = 0;
			
			// foreach($cda as $t=>$cdat)
			foreach($cdas as $cda)
				{
					$cda->fecha_venci=formato($cda->fecha_venci);
					$cda->fecha_venci=formato($cda->fecha_venci);
					$totcda+=$cda->saldo_cdat;
				}
			
			// Codedudas
			// $cd = new Code($dsn);
			// $cd->setWhere("cedula = '$cedula'");
			// $cds= $cd->getAll();

			$table_name6 = $wpdb->prefix . 'fondo_aso_code';
			$sql6="SELECT * FROM $table_name6 where cedula= '$cedula'";
			$cdss = $wpdb->get_results( $sql6 );


			$datDepo[0]->balance =$datDepo[0]->total_saldos_aportes-$datDepo[0]->total_saldos_prestamos;
			$datDepo[0]->total_cdat=$totcda;
			$tots=0;
			$totv =0;
			foreach($cdss as $cds)
			{
				$tots+=$cds->saldo_prestamo;
				$totv+=$cds->valor_compromiso;
				
			}
			$datDepo[0]->tots_codeuda=$tots;
			$datDepo[0]->valor_codeuda=$totv;
			
			
			if($datDepo[0]->balance >=0)
				$datDepo[0]->txbal="A FAVOR";
			else{
				$datDepo[0]->txbal="EN CONTRA";	
				$datDepo[0]->balance=$datDepo[0]->balance*-1;
			}	
			
			//Otros
			
			// $ot = new Otro($dsn);
			// $ot->setWhere("cedula=$cedula");
			// $ots= $ot->getAll();

			$table_name7 = $wpdb->prefix . 'fondo_aso_otro';
			$sql7="SELECT * FROM $table_name7 where cedula= '$cedula'";
			$otss = $wpdb->get_results( $sql7 );


			$tototr=0;
			//print_r($ots);
			foreach($otss as $ots)
			{
				$ots->fecha_inicial=formato($ots->fecha_inicial);
				$ots->fecha_final=formato($ots->fecha_final);
				$tototr+=$ots->saldo_cuenta;
				
			}
			$datDepo[0]->saldo_otros=$tototr;
			// $smarty->assign('datDepo',$datDepo);
		}	
	
	
	$bd=1;	
	$fecha=$fecha;
	$datosSaldos=$datosSaldos;
	$datos=$datos;
	$dprs=$dprs;
	$cdas=$cda;
	$cds=$cds;
	$ots=$ots;
	}	

}



?>

<div class="container">
	<div class="side_bar">

		
	</div>

	<div class="main_content">

		<table width="100%" border="1" cellspacing="4" cellpadding="4">
		  <tr>
		    <td colspan="5" align="center"><strong>Estado de Cuenta con SALDOS a</strong>: {#$fecha#}</td>
		  </tr>
		  <tr>
		    <td><strong>Asociado:</strong></td>
		    <td>{#$datDepo.cedula#}</td>
		    <td>{#$datDepo.nombre#}</td>
		    <td><strong>C&oacute;digo N&oacute;mina:</strong></td>
		    <td>{#$datDepo.cod_nomina#}</td>
		  </tr>
		  <tr>
		    <td colspan="5" align="center"><strong>UBICACI&Oacute;N</strong></td>
		  </tr>
		  <tr>
		  <td colspan="5"><table cellpadding="0" cellspacing="0" width="100%">
		  	<tr>
				<td colspan="2">Entidad:</td>
		   		 <td>{#$datDepo.empresa#}</td>
		   		 <td>Regional:</td>
		   		 <td>{#$datDepo.regional#}</td>
			</tr>
			<tr>
		    <td colspan="2">Ciudad:</td>
		    <td>{#$datDepo.ciudad#}</td>
		    <td>Oficina:</td>
		    <td>{#$datDepo.oficina#}</td>
		  </tr>
		  	</table></td>
		    
		  </tr>
		   
		  <tr>
		    <td colspan="5" align="center"><strong>AFILIACI&Oacute;N</strong></td>
		  </tr>
		  <tr>
		  	<td  colspan="5">
				<table cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td colspan="2">Fecha de afiliaci&oacute;n :</td>
			      <td>{#$datDepo.fecha_afiliacion#}</td>
				    <td>Antig&uuml;edad:</td>
				    <td>{#$datos[0]#} A&ntilde;os {#$datos[1]#} Meses {#$datos[2]#} D&iacute;as </td>
				</tr>
				</table>
			</td>
		    
		  </tr>
		   <tr>
		    <td colspan="5" align="center"><strong>SALDOS A FAVOR</strong></td>
		  </tr>
		  <tr>
		  	<td colspan="5">
				<table width="100%" cellpadding="2" cellspacing="2">
					<tr>
					<td><strong>Cuenta</strong></td>
					<td><strong>%</strong></td>
					<td><strong>Cuota</strong></td>
					<td><strong>Saldo</strong></td>
					<td><strong>Capacidad Endeudamiento</strong></td>
					</tr>
					{#foreach from = $datosSaldos item= saldo #}
					<tr>
					<td>{#$saldo.nombre_cuenta#}</td>
					<td>{#$saldo.porcenta_cuenta#}</td>
					<td><div align="right">{#$saldo.saldo_cuenta|number_format#}</div></td>
					<td><div align="right">{#$saldo.valor_cuenta|number_format#}</div></td>
					<td><div align="right">---</div></td>
					</tr>
					{#/foreach#}
					
					<tr>
					<td colspan="2" align="right"><strong>TOTAL SALDOS A FAVOR: </strong></td>
					<td><div align="right">${#$datDepo.total_cuotas_aportes|number_format#}</div></td>
					<td><div align="right">${#$datDepo.total_saldos_aportes|number_format#}</div></td>
					<td><div align="right">${#$datDepo.cupo_total|number_format#}</div></td>
					</tr>
				</table>
		  	</td>
		  </tr>
		  <tr>
		    <td colspan="5" align="center"><strong>DEPOSITOS CDAT </strong></td>
		  </tr>
		  <tr>
		  <td colspan="5">
		  <table width="100%" cellpadding="2" cellspacing="2">
		  {# if count($cdas) >0 #}
					<tr>
					<td><strong> C.D.A.T </strong></td>
					<td><strong>Vence en </strong></td>
					<td><strong>Tasa</strong></td>
					<td><strong>Meses</strong></td>
					<td><strong>Saldo Actual </strong></td>
					
					</tr>
					{#foreach from=$cdas item=cda#}
					<tr>
					<td>{#$cda.num_cdat#}</td>
					<td>{#$cda.fecha_venci#}</td>
					<td>{#$cda.tasa_pactada#}</td>
					<td>{#$cda.tiempo_pactado#}</td>
					<td><div align="right">{#$cda.saldo_cdat|number_format#}</div></td>
					
					</tr>
					{#/foreach#}
					<tr>
					<td colspan="4" align="right"><strong>TOTAL C.D.A.T: </strong></td>
					<td><div align="right">${#$datDepo.total_cdat|number_format#}</div></td>
					
					
					</tr>
					{#else#}
					<tr>
					<td colspan="5" align="center">
					**** ASOCIADO NO TIENE CDAT ***
					</td>
					</tr>
					{#/if#}
			</table>
		</td>
		</tr>
		  
		   <tr>
		    <td colspan="5" align="center"><strong>PRESTAMOS</strong></td>
		  </tr>
		  <tr>
		  <td colspan="5">
		  <table width="100%" cellpadding="2" cellspacing="2">
		  {# if count($dprs) >0 #}
					<tr>
					<td><strong>LINEA</strong></td>
					<td><strong>Inicio</strong></td>
					<td><strong>Vence</strong></td>
					<td><strong>% Pago</strong></td>
					<td><strong>Cuota</strong></td>
					<td><strong>Saldo actual</strong></td>
					</tr>
					{#foreach from=$dprs item=dpr#}
					<tr>
					<td>{#$dpr.linea_credito#}</td>
					<td>{#$dpr.fecha_desembolso#}</td>
					<td>{#$dpr.fecha_vencimiento#}</td>
					<td>{#$dpr.porcenta_pagado#}</td>
					<td><div align="right">{#$dpr.valor_cuota|number_format#}</div></td>
					<td><div align="right">{#$dpr.saldo_prestamo|number_format#}</div></td>
					</tr>
					{#/foreach#}
					<tr>
					<td colspan="4" align="right"><strong>TOTAL PRESTAMOS: </strong></td>
					<td><div align="right">${#$datDepo.total_cuotas_prestamos|number_format#}</div></td>
					<td><div align="right">${#$datDepo.total_saldos_prestamos|number_format#}</div></td>
					
					
					</tr>
					{#else#}
					<tr>
					<td colspan="5" align="center">
					**** ASOCIADO NO TIENE PRESTAMOS ***
					</td>
					</tr>
					{#/if#}
			</table>
		</td>
		</tr>		
		 <tr>
		    <td colspan="5" align="center"><strong>OTROS DESCUENTOS</strong></td>
		  </tr>	
		  <tr>
			<td colspan="5">
				<table width="100%" cellspacing="2" cellpadding="2">
				{#if count($ots) > 0 #}
				<tr>
					<td><strong>Otras Cuentas </strong></td>
					<td><strong>Desde</strong></td>
					<td><strong>Hasta</strong></td>
					<td><strong>Cuota</strong></td>
					<td><strong>Saldo por pagar </strong></td>
				</tr>	
				{#foreach from=$ots item=ot#}
				<tr>
					<td>{#$ot.nombre_cuenta#} </td>
					<td>{#$ot.fecha_inicial#}</td>
					<td>{#$ot.fecha_final#}</td>
					<td><div align="right">{#$ot.valor_cuenta#}</div></td>
					<td><div align="right">{#$ot.saldo_cuenta#}</div></td>
				</tr>
				{#/foreach#}
				
				<tr>
					<td colspan="3" align="right"><strong>TOTAL OTROS DESCUENTOS: </strong></td>
					<td><div align="right">${#$datDepo.total_cuotas_otros|number_format#}</div></td>
					
					<td><div align="right">${#$datDepo.saldo_otros|number_format#}</div></td>
					</tr>
				{#else#}
				<tr>
					<td align="center">
						**** ASOCIADO NO TIENE OTROS DESCUENTOS ****
					</td>
				</tr>
				{#/if#}	
				</table>
			</td>		
		  </tr>
		  <tr>
		  <td colspan="5">
		  	<table width="100%" cellspacing="2" cellpadding="2">
			<tr>
				<td>
				  <strong>Ingresos</strong> </td>
				<td>
				  <div align="right">${#$datDepo.sueldo|number_format#}		</div></td>
				<td>
				  <strong>Dctos. Fondo:	      </strong></td>
				<td>
					{#$datDepo.porcenta_endeuda#}%		</td>
				
				<td>
				  <strong>Por:</strong> </td>
				<td><div align="right">${#$datDepo.total_cuota_descuento|number_format#}</div></td>
				<td><strong>Empresa:</strong></td>
				<td>0</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="2">
				  <strong>Total Descuentos: </strong></td>
				<td>
					<div align="right">{#$datDepo.porcenta_endeuda#}%		</div></td>
				
				<td>
				  <strong>Balance:</strong> </td>
				<td colspan="3">${#$datDepo.balance|number_format#} {#$datDepo.txbal#}</td>
				</tr>
			</table>
		  </td>
		  </tr>
		  <tr>
		    <td colspan="5" align="center"><strong>CODEUDAS</strong></td>
		  </tr>	
		  <tr>
		  <td colspan="5">
		  	<table width="100%" cellpadding="2" cellspacing="2">
				{#if count($cds) > 0 #}
				<tr>
					<td><strong>Nombre del deudor </strong></td>
					<td><strong>Saldo actual </strong></td>
					<td><strong>%</strong></td>
					
					<td><strong>Valor Compromiso </strong></td>
				</tr>
				{#foreach from=$cds item= codeuda #}
				<tr>
					<td>{#$codeuda.nombre#}</td>
					<td><div align="right">{#$codeuda.saldo_prestamo|number_format#}</div></td>
					<td>{#$codeuda.porcenta_compromiso#}</td>
					
					<td><div align="right">{#$codeuda.valor_compromiso|number_format#}</div></td>
				</tr>
				{#/foreach#}
				<tr>
					<td colspan="1" align="right"><strong>TOTAL CODEUDAS: </strong></td>
					<td><div align="right">${#$datDepo.tots_codeuda|number_format#}</div></td>
					<td><div align="right"></div></td>
					<td><div align="right">${#$datDepo.valor_codeuda|number_format#}</div></td>
					
					
					</tr>
				{#else#}
				<tr>
				<td colspan="5" align="center">
				**** ASOCIADO NO TIENE CODEUDAS ***
				</td>
				</tr>
				
				{#/if#}		
			</table>
		  </td>
		  </tr>
		  <tr>
		  <td colspan="5">&nbsp;</td>
		  </tr>
		  <tr>
		  <td colspan="5" align="center"><a href="extracto.php" target="_blank"><strong>DESCARGAR PDF</strong></a></td>
		  </tr>
		</table>

		
	</div>
	
</div>

<?php 

function calculoAnti($fecha){

$fecha_de_nacimiento = $fecha;
$fecha_actual = date ("Y-m-d");
//$fecha_actual = date ("2006-03-05"); //para pruebas



// separamos en partes las fechas
$array_nacimiento = explode ( "-", $fecha_de_nacimiento );
$array_actual = explode ( "-", $fecha_actual );

$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años
$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses
$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días

//ajuste de posible negativo en $días
if ($dias < 0)
{
	--$meses;

	//ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
	switch ($array_actual[1]) {
		   case 1:     $dias_mes_anterior=31; break;
		   case 2:     $dias_mes_anterior=31; break;
		   case 3: 
				if (bisiesto($array_actual[0]))
				{
					$dias_mes_anterior=29; break;
				} else {
					$dias_mes_anterior=28; break;
				}
		   case 4:     $dias_mes_anterior=31; break;
		   case 5:     $dias_mes_anterior=30; break;
		   case 6:     $dias_mes_anterior=31; break;
		   case 7:     $dias_mes_anterior=30; break;
		   case 8:     $dias_mes_anterior=31; break;
		   case 9:     $dias_mes_anterior=31; break;
		   case 10:     $dias_mes_anterior=30; break;
		   case 11:     $dias_mes_anterior=31; break;
		   case 12:     $dias_mes_anterior=30; break;
	}

	$dias=$dias + $dias_mes_anterior;
}

//ajuste de posible negativo en $meses
if ($meses < 0)
{
	--$anos;
	$meses=$meses + 12;
}

return array($anos,$meses,$dias);



	
}

function formato($fecha)
{
	$time = explode("-",$fecha);
	
	$n_fecha = date("Y/m/d",mktime("00","00","00",$time[1],$time[2],$time[0])); 
	
	return $n_fecha;

}
?>


         if( $page > 0 )
         {
            $last = $page - 2;
            echo "<a href=\"$_PHP_SELF?page=$last\">Last 10 Records</a> |";
            echo "<a href=\"$_PHP_SELF?page=$page\">Next 10 Records</a>";
         }
         
         else if( $page == 0 )
         {
            echo "<a href=\"$_PHP_SELF?page=$page\">Next 10 Records</a>";
			}
			
         else if( $left_rec < $rec_limit )
         {
            $last = $page - 2;
            echo "<a href=\"$_PHP_SELF?page=$last\">Last 10 Records</a>";
         }
         