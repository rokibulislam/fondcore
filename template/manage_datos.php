<?php
	$table_name = $wpdb->prefix . 'datos';
	$sql="SELECT * FROM $table_name";
	$myrows = $wpdb->get_results( $sql );
?>
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url("css/font-awesome.min.css",__FILE__ );?>" />
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url("css/jquery-ui.min.css",__FILE__ );?>" />
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url("css/jquery-ui.theme.min.css",__FILE__ );?>" />
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url("css/style.css",__FILE__ );?>" />

<script type="text/javascript" src="<?php echo plugins_url("js/jquery.js",__FILE__ );?>"></script>
<script type="text/javascript" src="<?php echo plugins_url("js/jquery-ui.min.js",__FILE__ );?>"></script>
<script type="text/javascript">
	jQuery(function(){
		$(".close").click(function(event) {
			$(this).parent().fadeOut('slow');
		});
		dialog = $( "#dialog-form" ).dialog({
		      autoOpen: false,
		      height: 600,
		      width: 600,
		      modal: true,
		      // buttons: {
		      //   "Create an account": addUser,
		      //   Cancel: function() {
		      //     dialog.dialog( "close" );
		      //   }
		      // },
		      close: function() {
		        // form[ 0 ].reset();
		        // allFields.removeClass( "ui-state-error" );
		      }
		    });

		

		$( "#add_datos" ).on( "click", function() {
			  var url_g="<?php echo admin_url().'admin.php?page=datos&add_datos=ok';?>";
			  $("#g_form").attr("action",url_g);
			  $("#title").val("");
			  // $("#img").val("");
			  $("#sbmt_btn").val("Save");
			  $("#dialog-form").attr('title', 'Crear datos');
		      dialog.dialog( "open" );
		    });

		$( ".edit_datos" ).on( "click", function() {



			var url_g="<?php echo admin_url().'admin.php?page=datos&update_datos='; ?>";
			
			  var title=$(this).parent().parent().find("td:eq(1)").html();
			 
			  
			  //  console.log("data");
			  // return false;
			 user_id=$(this).attr("user-id");
			 $.ajax({
			  	url: '<?php echo plugins_url();?>/fondecore/template/get_user.php',
			  	data:{
			  		'user_id':user_id
			  	},
			  	type: 'POST',
			  	dataType: 'html',
			  	//data: {param1: 'value1'},
			  })
			  .done(function(d) {
			  	var arr = d.split('-&-');
			  	console.log(arr);
			  	dialog.dialog( "open" );
			  	$('#nombre').val(arr[0]);
			  	$('#apellido').val(arr[1]);
			  	$('#apellido2').val(arr[2]);
			  	$('#handle').val(arr[3]);
			  	$('#email').val(arr[5]);
			  	$('#passwd').val(arr[4]);
			  	//$('#isactive').val();
			  	
			  })
			  .fail(function() {
			  	console.log("error");
			  })
			  .always(function() {
			  	console.log("complete");
			  });
			  
			
			  
			   $("#g_form").attr("action",url_g+user_id);
			  // $("#title").val(title);
			  // $("#sbmt_btn").val("Update");
			  // $("#dialog-form").attr('title', 'Update Usuario');

		   //    dialog.dialog( "open" );
		    });
		$(".delete_datos").click(function(event) {
			var r=confirm("are You sure");
			if(r==false){
				return false;
			}
		});

	});
</script>

<div class="user_show_table">
	<button class="btn" id="add_datos">Crear SubSecciones</button>

	<?php if(isset($_GET['result'])) { ?>
			<?php if($_GET['result']=="add") { ?>
				<div class="alert alert-success">Usuario Successfully Added.<a href="javascript:void(0);" class="close"><i class="fa fa-times"></i></a></div>
			<?php } ?> 
			<?php if($_GET['result']=="edit") { ?>
				<div class="alert alert-success">Usuario Successfully Edited.<a href="javascript:void(0);" class="close"><i class="fa fa-times"></i></a></div>
			<?php } ?> 
			<?php if($_GET['result']=="delete") { ?>
				<div class="alert alert-error">Usuario Successfully Deleted.<a href="javascript:void(0);" class="close"><i class="fa fa-times"></i></a></div>
			<?php } ?> 

	<?php } ?> 
	<table class="flat-table">
		<thead>
			<tr>
				<th>titulo</th>
				<th>orden</th>
				<th>contenido</th>
				<th>link</th>
				<th>visible</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $myrows as $myrow ) { ?>
			<tr>
				<td><?php echo $myrow->titulo; ?></td>
				<td><?php echo $myrow->orden; ?></td>
				<td><?php echo $myrow->contenido; ?></td>
				<td><?php echo $myrow->link; ?></td>
				<td><?php if($myrow->visible==1) { echo "yes"; } else { echo "no";} ?></td>
				<td><a href="<?php echo admin_url().'admin.php?page=datos&edit_datos='.$myrow->idsubseccion; ?>"  class="edit_datos" ><img class="my_icon" src="<?php echo get_template_directory_uri();?>/fondecore/template/img/edit_ico.png"></a></td>
				<td><a class="delete_subsecciones" href="<?php echo admin_url().'admin.php?page=datos&delete_datos='.$myrow->idsubseccion; ?>"><img class="my_icon" src="<?php echo get_template_directory_uri();?>/fondecore/template/img/delete_ico.png"></a></td>
				
			</tr>
			<?php } ?>
		</tbody>
		
	</table>
	
</div>





<?php if(isset($_GET['edit_datos'])){ 
	$ses_id=$_GET['edit_datos'];
 	$table_name = $wpdb->prefix . 'datos';
 	$sql="SELECT * FROM $table_name where idseccion='$ses_id'";
	$mysubsecciones = $wpdb->get_results( $sql );
	var_dump($mysubsecciones);
?>
	<script type="text/javascript">
	jQuery(function(){
	
		dialog2 = $( "#dialog-form2" ).dialog({
		      autoOpen: false,
		      height: 600,
		      width: 600,
		      modal: true,
		      // buttons: {
		      //   "Create an account": addUser,
		      //   Cancel: function() {
		      //     dialog.dialog( "close" );
		      //   }
		      // },
		      close: function() {
		        // form[ 0 ].reset();
		        // allFields.removeClass( "ui-state-error" );
		        var url="<?php echo admin_url().'admin.php?page=datos';?>";
		        window.location=url;
		      }
		    });
		 var url_g="<?php echo admin_url().'admin.php?page=datos&update_datos='.$ses_id;?>";
		 $("#g_form").attr("action",url_g);
		 $("#sbmt_btn").val("Update");
		 $("#dialog-form").attr('title', 'Edit datos');
		dialog2.dialog( "open" );

		});

	</script>


	<div id="dialog-form2" class="add_slide" title="Slide">
	  <p class="validateTips">All form fields are required.</p>
	 
	  <form id="g_form" action="<?php echo admin_url(); ?>admin.php?page=fit_slider_menu&add_slide=<?php echo $slides;?>" method="post">
		<fieldset>
	      <label for="title">Archive:</label>
	      <input type="file" name="file" id="file">
		  <br>	
		  <label for="title">Document type:</label>
			<select id="tipo" name="tipo" class="cajaforms">
				<option value="null">---</option>
				<option label="Asociados Relacionados" value="1">Related Associates</option>
				<option label="Tot. por asoc. , aportes y depositos" value="2">Tot. by Assoc., Contributions and deposits</option>
				<option label="Depositos de asociados" value="3">Associated deposits</option>
				<option label="Prestamos de asociado" value="4">Loans associated</option>
				<option label="Coutas extraordinarias o primas" value="5">Extraordinary or raw Installments</option>
				<option label="Codeudas del asociado" value="6">Associate assumption of debt</option>
				<option label="Otros descuentos" value="7">Other discounts</option>
				<option label="Cupos de credito" value="8">Credit quotas</option>
				<option label="Correo Electronico" value="9">Email</option>
				<option label="CDATS de asociados" value="10">Associated CDATS</option>
			</select>
	      <br>
	      <label for="title">Upload date:</label>
	      <input type="text" name="date" id="date" value=""  class="text ui-widget-content ui-corner-all" required>
	      <br>
	      <div class="clear_fix"></div>
	      <!-- Allow form submission with keyboard without duplicating the dialog button -->
	      <input type="submit" id="sbmt_btn" class="btn" tabindex="-1" style="" value="Save">
	    </fieldset>
	  </form>
	</div>

<?php }else { ?>


<div id="dialog-form" class="add_slide" title="Slide">
  <p class="validateTips">All form fields are required.</p>
 
  <form id="g_form" action="<?php echo admin_url(); ?>admin.php?page=fit_slider_menu&add_slide=<?php echo $slides;?>" method="post" enctype="multipart/form-data">
    <fieldset>
      <label for="title">Archive:</label>
      <input type="file" name="file" id="file">
	  <br>	
	  <label for="title">Document type:</label>
		<select id="tipo" name="tipo" class="cajaforms">
			<option value="null">---</option>
			<option label="Asociados Relacionados" value="1">Related Associates</option>
			<option label="Tot. por asoc. , aportes y depositos" value="2">Tot. by Assoc., Contributions and deposits</option>
			<option label="Depositos de asociados" value="3">Associated deposits</option>
			<option label="Prestamos de asociado" value="4">Loans associated</option>
			<option label="Coutas extraordinarias o primas" value="5">Extraordinary or raw Installments</option>
			<option label="Codeudas del asociado" value="6">Associate assumption of debt</option>
			<option label="Otros descuentos" value="7">Other discounts</option>
			<option label="Cupos de credito" value="8">Credit quotas</option>
			<option label="Correo Electronico" value="9">Email</option>
			<option label="CDATS de asociados" value="10">Associated CDATS</option>
		</select>
      <br>
      <label for="title">Upload date:</label>
      <input type="text" name="date" id="date" value=""  class="text ui-widget-content ui-corner-all" required>
      <br>
      <div class="clear_fix"></div>
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" id="sbmt_btn" class="btn" tabindex="-1" style="" value="Save">
    </fieldset>
  </form>
</div>
<?php } ?>


<script>
	jQuery(document).ready(function($) {
		$( "#date" ).datepicker();
	});
</script>