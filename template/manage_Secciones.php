<?php
	$table_name = $wpdb->prefix . 'fondo_secciones';
	$sql="SELECT * FROM $table_name";
	$myrows = $wpdb->get_results( $sql );
	$record_per_page=1;
	$current_page = empty($_GET['paged'])? 1: intval($_GET['paged']);
	$record_num= count($myrows);
	$max_num_page= ceil($record_num/$record_per_page);
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

		

		$( "#add_Secciones" ).on( "click", function() {
			  var url_g="<?php echo admin_url().'admin.php?page=secciones&add_secciones=ok';?>";
			  $("#g_form").attr("action",url_g);
			  $("#title").val("");
			  // $("#img").val("");
			  $("#sbmt_btn").val("Save");
			  $("#dialog-form").attr('title', 'Crear secciones');
		      dialog.dialog( "open" );
		    });

		$( ".edit_Seccionesee" ).on( "click", function() {



			var url_g="<?php echo admin_url().'admin.php?page=secciones&update_secciones='; ?>";
			
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
		$(".delete_Secciones").click(function(event) {
			var r=confirm("are You sure");
			if(r==false){
				return false;
			}
		});

	});
</script>

<div class="user_show_table">
	<button class="btn" id="add_Secciones">Crear Secciones</button>

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
			<?php // foreach ( $myrows as $myrow ) {  ?>

				<?php	for($i=($record_per_page*($current_page - 1)); $i<$record_num && $i<($record_per_page * $current_page); $i++){ 
	$myrow = $myrows[$i];?>
			<tr>
				<td><?php echo $myrow->titulo; ?></td>
				<td><?php echo $myrow->orden; ?></td>
				<td><?php echo $myrow->contenido; ?></td>
				<td><?php echo $myrow->link; ?></td>
				<td><?php if($myrow->visible==1) { echo "yes"; } else { echo "no";} ?></td>
				<td><a href="<?php echo admin_url().'admin.php?page=secciones&edit_secciones='.$myrow->idseccion; ?>"  class="edit_Secciones" ><img class="my_icon" src="<?php echo get_template_directory_uri();?>/fondecore/template/img/edit_ico.png"></a></td>
				<td><a class="delete_Secciones" href="<?php echo admin_url().'admin.php?page=secciones&delete_secciones='.$myrow->idseccion; ?>"><img class="my_icon" src="<?php echo get_template_directory_uri();?>/fondecore/template/img/delete_ico.png"></a></td>
				
			</tr>
			<?php } ?>
		</tbody>
		
	</table>
	
</div>


<?php
	if( $max_num_page > 1 ){
	$page_var = $_GET;
	echo '<div class="gdlr-lms-pagination">';

	if($current_page > 1){
	$page_var['paged'] = intval($current_page) - 1;
	echo '<a class="prev page-numbers" href="' . esc_url(add_query_arg($page_var)) . '" >';
	echo __('&lsaquo; Previous', 'gdlr-lms') . '</a>';
	}

	for($i=1; $i<=$max_num_page; $i++){
	$page_var['paged'] = $i;
	if( $i == $current_page ){
	echo '<span class="page-numbers current" href="' . esc_url(add_query_arg($page_var)) . '" >' . $i . '</span>';
	}else{
	echo '<a class="page-numbers" href="' . esc_url(add_query_arg($page_var)) . '" >' . $i . '</a>';
	}
	}

	if($current_page < $max_num_page){
	$page_var['paged'] = intval($current_page) + 1;
	echo '<a class="next page-numbers" href="' . esc_url(add_query_arg($page_var)) . '" >';
	echo __('Next &rsaquo;', 'gdlr-lms') . '</a>';
	}

	echo '</div>';
	 }
?>



<?php if(isset($_GET['edit_secciones'])){ 
	$ses_id=$_GET['edit_secciones'];
 	$table_name = $wpdb->prefix . 'fondo_secciones';
 	$sql="SELECT * FROM $table_name where idseccion='$ses_id'";
	$mysecciones = $wpdb->get_results( $sql );
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
		        var url="<?php echo admin_url().'admin.php?page=secciones';?>";
		        window.location=url;
		      }
		    });
		 var url_g="<?php echo admin_url().'admin.php?page=secciones&update_secciones='.$ses_id;?>";
		 $("#g_form").attr("action",url_g);
		 $("#sbmt_btn").val("Update");
		 $("#dialog-form").attr('title', 'Edit secciones');
		dialog2.dialog( "open" );

		});

	</script>


	<div id="dialog-form2" class="add_slide" title="Slide">
	  <p class="validateTips">All form fields are required.</p>
	 
	  <form id="g_form" action="<?php echo admin_url(); ?>admin.php?page=fit_slider_menu&add_slide=<?php echo $slides;?>" method="post">
	    <fieldset>
	      <label for="title">Title:</label>
	      <input type="text" name="title" id="title" value="
	      <?php if(isset($mysecciones[0]->titulo)) echo $mysecciones[0]->titulo; ?>" placeholder="Type Nombre" 
	      class="text ui-widget-content ui-corner-all" required>
	      <br>
	      <label for="title">Link:</label>
	      <input type="text" name="link" id="link" 
	      value="<?php if(isset($mysecciones[0]->link)) echo $mysecciones[0]->link; ?>" placeholder="Type Nombre" class="text ui-widget-content ui-corner-all" required>
	      <br>
	      <label for="title">Order :</label>
	      <input type="text" name="order" id="order" 
	      value="<?php if(isset($mysecciones[0]->orden)) echo $mysecciones[0]->orden; ?>" placeholder="Type Nombre" class="text ui-widget-content ui-corner-all" required>
	      <br>
	      <label for="title">Show</label>
	      <select name="show" id="isactive">
	      	<option label="Contenido" value="1"<?php if(isset($mysecciones[0]->vercontent)==1) echo "selected";  ?>> Contenido </option>
	        <option label="Link" value="0"<?php if(isset($mysecciones[0]->vercontent)==0) echo "selected";  ?>>Link</option>
	        <option label="Link Externo" value="2"<?php if(isset($mysecciones[0]->vercontent)==2) echo "selected";  ?>>External Link</option>
			<option label="Contenido Subsecciones" value="3"<?php if(isset($mysecciones[0]->vercontent)==3) echo "selected";  ?>>sContents Subsections</option>
			<option label="Galerias" value="4"<?php if(isset($mysecciones[0]->vercontent)==4) echo "selected";  ?>>Galerias</option>
	      </select>
	      <br>
	      vercontent
	      <label for="title">Visible:</label>
	      <input type="checkbox" name="visible" id="" <?php if(isset($mysecciones[0]->visible)==1) echo "checked";  ?>>
	      <br>
	      <label for="title">Menu:</label>
	      <input type="checkbox" name="menu1" id="" <?php if(isset($mysecciones[0]->menu1)==1) echo "checked";  ?>>
	      <label for="">Menu 1</label>
	      <input type="checkbox" name="menu2" id="" <?php if(isset($mysecciones[0]->menu2)==1) echo "checked";  ?>>
	      <label for="">Menu 2</label>
	      <br>
	      <?php 
				 if(isset($mysecciones[0]->contenido)){
				 	$content=$mysecciones[0]->contenido;
				 }else{
				 	$content = '';
				 }
				$editor_id = 'sectextarea'; 
				wp_editor($content,$editor_id,$settings = array('textarea_name'=>'sectextarea'));
		  ?> 
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
      <label for="title">Title:</label>
      <input type="text" name="title" id="title" value="" placeholder="Type Nombre" class="text ui-widget-content ui-corner-all" required>
      <br>
      <label for="title">Link:</label>
      <input type="text" name="link" id="link" value="" placeholder="Type Nombre" class="text ui-widget-content ui-corner-all" required>
      <br>
      <label for="title">Order :</label>
      <input type="text" name="order" id="order" value="" placeholder="Type Nombre" class="text ui-widget-content ui-corner-all" required>
      <br>
      <label for="title">Show</label>
      <select name="show" id="isactive">
      	<option label="Contenido" value="1"> Contenido </option>
        <option label="Link" value="0">Link</option>
        <option label="Link Externo" value="2">External Link</option>
		<option label="Contenido Subsecciones" value="3">sContents Subsections</option>
		<option label="Galerias" value="4">Galerias</option>
      </select>
      <br>
      <label for="title">Visible:</label>
      <input type="checkbox" name="visible" id="" value="1">
      <br>
      <label for="title">Menu:</label>
      <input type="checkbox" name="menu1" id="" value="1">
      <label for="">Menu 1</label>
      <input type="checkbox" name="menu2" id="" value="1">
      <label for="">Menu 2</label>
      <br>
      <?php 
      		$content = '';
			$editor_id = 'sectextarea'; 
			wp_editor($content,$editor_id,$settings = array('textarea_name'=>'sectextarea')); 
	  ?> 
      <div class="clear_fix"></div>
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" id="sbmt_btn" class="btn" tabindex="-1" style="" value="Save">
    </fieldset>
  </form>
</div>
<?php } ?>
