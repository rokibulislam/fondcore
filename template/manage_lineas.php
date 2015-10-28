<?php
	$table_name = $wpdb->prefix . 'lineacredito';
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

		

		$( "#add_lineas" ).on( "click", function() {
			  var url_g="<?php echo admin_url().'admin.php?page=lineas&add_lineas=ok';?>";
			  $("#g_form").attr("action",url_g);
			  $("#title").val("");
			  // $("#img").val("");
			  $("#sbmt_btn").val("Save");
			  $("#dialog-form").attr('title', 'Crear lineas');
		      dialog.dialog( "open" );
		    });

		$( ".edit_lineas" ).on( "click", function() {



			var url_g="<?php echo admin_url().'admin.php?page=lineas&update_lineas='; ?>";
			
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
		$(".delete_lineas").click(function(event) {
			var r=confirm("are You sure");
			if(r==false){
				return false;
			}
		});

	});
</script>

<div class="user_show_table">
	<button class="btn" id="add_lineas">Crear lineas</button>

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
				<th>nombre</th>
				<th>tasa</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $myrows as $myrow ) { ?>
			<tr>
				<td><?php echo $myrow->nombre; ?></td>
				<td><?php echo $myrow->tasa1; ?></td>
				<td><a href="<?php echo admin_url().'admin.php?page=lineas&edit_lineas='.$myrow->idCredito; ?>"  class="edit_lineas" ><img class="my_icon" src="<?php echo get_template_directory_uri();?>/fondecore/template/img/edit_ico.png"></a></td>
				<td><a class="delete_lineas" href="<?php echo admin_url().'admin.php?page=lineas&delete_lineas='.$myrow->idCredito; ?>"><img class="my_icon" src="<?php echo get_template_directory_uri();?>/fondecore/template/img/delete_ico.png"></a></td>
				
			</tr>
			<?php } ?>
		</tbody>
		
	</table>
	
</div>





<?php if(isset($_GET['edit_lineas'])){ 
	$ses_id=$_GET['edit_lineas'];
 	$table_name = $wpdb->prefix . 'lineacredito';
 	$sql="SELECT * FROM $table_name where idCredito='$ses_id'";
	$mylineas = $wpdb->get_results( $sql );
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
		        var url="<?php echo admin_url().'admin.php?page=lineas';?>";
		        window.location=url;
		      }
		    });
		 var url_g="<?php echo admin_url().'admin.php?page=lineas&update_lineas='.$ses_id;?>";
		 $("#g_form").attr("action",url_g);
		 $("#sbmt_btn").val("Update");
		 $("#dialog-form").attr('title', 'Edit lineas');
		dialog2.dialog( "open" );

		});

	</script>


	<div id="dialog-form2" class="add_slide" title="Slide">
	  <p class="validateTips">All form fields are required.</p>
	 
	  <form id="g_form" action="<?php echo admin_url(); ?>admin.php?page=fit_slider_menu&add_slide=<?php echo $slides;?>" method="post">
		
		  <fieldset>
		
		      <label for="title">Nombre::</label>
		      <input type="text" name="nombre" id="nombre" value="<?php if(isset($mylineas[0]->nombre)) echo $mylineas[0]->nombre; ?>" placeholder="Type Nombre" class="text ui-widget-content ui-corner-all" required>
		      <br>
		      <label for="title">Tasa de Interes 1 a 12</label>
		      <input type="text" name="tasa1" id="tasa1" size="40" class="cajaforms" value="<?php if(isset($mylineas[0]->tasa1)) echo $mylineas[0]->tasa1; ?>">
		      <br>
		      <label for="title">Tasa de Interes 13 a 24</label>
		      <input type="text" name="tasa13" id="tasa13" size="40" class="cajaforms" value="<?php if(isset($mylineas[0]->tasa13)) echo $mylineas[0]->tasa13; ?>">
		      <br>
		      <label for="title">Tasa de Interes 25 a 36</label>
			    <input type="text" name="tasa25" id="tasa25" size="40" class="cajaforms" value="<?php if(isset($mylineas[0]->tasa25)) echo $mylineas[0]->tasa25; ?>">
			  <br>
		      <label for="title">Tasa de Interes 37 a 48</label>
		      <input type="text" name="tasa37" id="tasa37" size="40" class="cajaforms" value="<?php if(isset($mylineas[0]->tasa37)) echo $mylineas[0]->tasa37; ?>">
		      <br>
		      <label for="title"> Tasa de Interes 49 a 60 </label>
		 	  <input type="text" name="tasa49" id="tasa49" size="40" class="cajaforms" value="<?php if(isset($mylineas[0]->tasa49)) echo $mylineas[0]->tasa49; ?>">
		      <br>
		      <label for="">Tasa de Interes 61 a 72</label>
		      <input type="text" name="tasa61" id="tasa61" size="40" class="cajaforms" value="<?php if(isset($mylineas[0]->tasa61)) echo $mylineas[0]->tasa61; ?>">
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
 
  <form id="g_form" action="<?php echo admin_url(); ?>admin.php?page=fit_slider_menu&add_slide=<?php echo $slides;?>" method="post">
    <fieldset>
	
      <label for="title">Nombre::</label>
      <input type="text" name="nombre" id="nombre" value="" placeholder="Type Nombre" class="text ui-widget-content ui-corner-all" required>
      <br>
      <label for="title">Tasa de Interes 1 a 12</label>
      <input type="text" name="tasa1" id="tasa1" size="40" class="cajaforms" value="">
      <br>
      <label for="title">Tasa de Interes 13 a 24</label>
      <input type="text" name="tasa13" id="tasa13" size="40" class="cajaforms" value="">
      <br>
      <label for="title">Tasa de Interes 25 a 36</label>
	    <input type="text" name="tasa25" id="tasa25" size="40" class="cajaforms" value="">
	  <br>
      <label for="title">Tasa de Interes 37 a 48</label>
      <input type="text" name="tasa37" id="tasa37" size="40" class="cajaforms" value="">
      <br>
      <label for="title"> Tasa de Interes 49 a 60 </label>
 	  <input type="text" name="tasa49" id="tasa49" size="40" class="cajaforms" value="">
      <br>
      <label for="">Tasa de Interes 61 a 72</label>
      <input type="text" name="tasa61" id="tasa61" size="40" class="cajaforms" value="">
      <br>
      <div class="clear_fix"></div>
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" id="sbmt_btn" class="btn" tabindex="-1" style="" value="Save">
    </fieldset>
  </form>
</div>
<?php } ?>

               