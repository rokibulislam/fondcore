<?php
$table_name = $wpdb->prefix . 'fondo_liveuser_users';
$sql="SELECT * FROM $table_name where 1 order by authuserid ASC";
$myrows = $wpdb->get_results( $sql );
$adjacents = 5;
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

		

		$( "#add_user" ).on( "click", function() {
			  var url_g="<?php echo admin_url().'admin.php?page=usuarios&add_user=ok';?>";
			  $("#g_form").attr("action",url_g);
			  $("#title").val("");
			  // $("#img").val("");
			  $("#sbmt_btn").val("Save");
			  $("#dialog-form").attr('title', 'Crear Usuario');
		      dialog.dialog( "open" );
		});

		$( ".edit_user" ).on( "click", function() {



			var url_g="<?php echo admin_url().'admin.php?page=usuarios&update_user='; ?>";
			
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
		$(".delete_user").click(function(event) {
			var r=confirm("are You sure");
			if(r==false){
				return false;
			}
		});

	});
</script>

<div class="user_show_table">
	<button class="btn" id="add_user">Crear Usuario</button>

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
				<th>Handle</th>
				<th>Nombre</th>
				<th>Primer Apellido</th>
				<th>Segundo Apellido</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
		 	<?php  // foreach ( $myrows as $myrow ) { ?>
		<?php	

		for($i=($record_per_page*($current_page - 1)); $i<$record_num && $i<($record_per_page * $current_page); $i++){ 
	$myrow = $myrows[$i];?>

			<tr>
				<td><?php echo $myrow->handle; ?></td>
				<td><?php echo $myrow->nombre; ?></td>
				<td><?php echo $myrow->apellido; ?></td>
				<td><?php echo $myrow->apellido2; ?></td>
				<td><a href="javascript:void(0);"  class="edit_user" user-id="<?php echo $myrow->authuserid; ?>"><img class="my_icon" src="<?php echo get_template_directory_uri();?>/fondecore/template/img/edit_ico.png"></a></td>
				<td><a class="delete_user" href="<?php echo admin_url().'admin.php?page=usuarios&delete_user='.$myrow->authuserid; ?>"><img class="my_icon" src="<?php echo get_template_directory_uri();?>/fondecore/template/img/delete_ico.png"></a></td>
				
			</tr>
			<?php } ?>
		</tbody>
		
	</table>
	
</div>



<?php

$pagination_args = array(
     'base' => @add_query_arg('paged','%#%'),
     'format' => '?page=%#%',
     'total' => $max_num_page,
     'current' => $current_page,
     'show_all' => False,
     'prev_next'    => True,
     'prev_text'    => __('« Previous'),
     'next_text'    => __('Next »'),
     'type' => 'plain',
     'add_args'     => False
    );

echo paginate_links($pagination_args);
	if( $max_num_page > 1 ){

//	$left_rec = $record_num - ($_GET['paged'] * $record_per_page);

	$page_var = $_GET;
	echo '<div class="gdlr-lms-pagination">';

	if($current_page > 1){
	$page_var['paged'] = intval($current_page) - 1;
	echo '<a class="prev page-numbers" href="' . esc_url(add_query_arg($page_var)) . '" >';
	echo __('&lsaquo; Previous', 'gdlr-lms') . '</a>';
	}
	if(isset($_GET['paged'])){
		$show_page=$_GET['paged'];
	}else{
		 $show_page = 1;
	}
	/*if($current_page>$adjacents){
		$pmin=$current_page;
	}else{
		$pmin=1;
	}*/
	//$pmin=($current_page>$adjacents)?($current_page - $adjacents):1;
    $pmax=($current_page<($max_num_page - $adjacents))?($current_page + $adjacents):$max_num_page; 

//	for($i=$current_page; $i<=$max_num_page; $i++){
	for($i=$current_page; $i<$pmax; $i++){
	$page_var['paged'] = $i;
	if( $i == $current_page ){
	echo '<span class="page-numbers current" href="' . esc_url(add_query_arg($page_var)) . '" >' . $i . '</span>';
	}else{
	echo '<a class="page-numbers" href="' . esc_url(add_query_arg($page_var)) . '" >' . $i . '</a>';
	}
	}


	if($current_page < $max_num_page -1){
	$page_var['paged'] = intval($current_page) + 1;
	echo '<a class="next page-numbers" href="' . esc_url(add_query_arg($page_var)) . '" >';
	echo __('Next &rsaquo;', 'gdlr-lms') . '</a>';

	}

	$page_var['paged'] = $max_num_page;
	echo '<a class="next page-numbers" href="' . esc_url(add_query_arg($page_var)) . '" >';
	echo __('Last &rsaquo;', 'gdlr-lms') . '</a>';
	echo '</div>';


	 }

?>



<div id="dialog-form" class="add_slide" title="Slide">
  <p class="validateTips">All form fields are required.</p>
 
  <form id="g_form" action="<?php echo admin_url(); ?>admin.php?page=fit_slider_menu&add_slide=<?php echo $slides;?>" method="post">
    <fieldset>
      <label for="title">Nombre:</label>
      <input type="text" name="nombre" id="nombre" value="" placeholder="Type Nombre" class="text ui-widget-content ui-corner-all" required>
      <br>
      <label for="title">Primer Apellido:</label>
      <input type="text" name="apellido" id="apellido" value="" placeholder="Type Nombre" class="text ui-widget-content ui-corner-all" required>
      <br>
      <label for="title">Segundo Apellido :</label>
      <input type="text" name="apellido2" id="apellido2" value="" placeholder="Type Nombre" class="text ui-widget-content ui-corner-all" required>
      <br>
      <label for="title">Cedula:</label>
      <input type="text" name="handle" id="handle" value="" placeholder="Type Nombre" class="text ui-widget-content ui-corner-all" required>
      <br>
      <label for="title">E-mail:</label>
      <input type="email" name="email" id="email" value="" placeholder="Type Nombre" class="text ui-widget-content ui-corner-all" required>
      <br>
      <label for="title">Password:</label>
      <input type="password" name="passwd" id="passwd" value="" placeholder="Type Nombre" class="text ui-widget-content ui-corner-all" required>
      <br>
      <label for="title">Activo?</label>
      <select name="isactive" id="isactive">
      	<option label="No" value="0">No</option>
      	<option label="Si" value="1">Si</option>
      </select>
      <br>
      <div class="clear_fix"></div>

 
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" id="sbmt_btn" class="btn" tabindex="-1" style="" value="Save">
    </fieldset>
  </form>
</div>