<?php if(!isset($_COOKIE['front_cedula'])){ ?>
<form action="<?php echo get_admin_url()."admin-post.php";?>" method="post">
	<?php 
	echo "<input type='hidden' name='action' value='submit-login-form' />";
	echo "<input type='hidden' name='hide' value='$ques' />";
	?>
	<label>Usuario</label>
	<input type="text" name="user_name"/>
	<label>Contraseña</label>
	<input type="password" name="pass"/>
	<input type="submit" class="buttonSubmit" name="login_btn" value="Ingresar">
	<?php if(isset($_COOKIE['front_error'])){
		echo $_COOKIE['front_error'];
		setcookie('front_error', "",time()-3600,'/');
		 unset ($_COOKIE['front_error']);
	} ?>
	
</form>

<?php }else{ ?>
	you are Logged in 
	<form action="<?php echo get_admin_url()."admin-post.php";?>" method="post">
		<button type="submit">Logout</button>
		<?php 
		echo "<input type='hidden' name='action' value='submit-logout-form' />";
		echo "<input type='hidden' name='hide' value='$ques' />";
		?>
	</form>
<?php } ?>

