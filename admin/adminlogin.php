<?php 

if(isset($_REQUEST['login'])) {
	
	$login_sql="SELECT*FROM users WHERE username='".$_POST['username']."' AND password='".sha1($_POST['password'])."'";
	
	$login_query=mysqli_query($dbconnect,$login_sql);
	
	if(mysqli_num_rows($login_query)>0) 
	{
		$login_rs=mysqli_fetch_assoc($login_query);
		$_SESSION['admin']=$login_rs['username'];
	}
	
	else {
		unset($_SESSION);
		header("Location: admin.php?page=login&error=login");
	}
	
}

if (!isset($_SESSION['admin'])) {
	include("login.php");
}
else {
	include("adminpanel.php");
}

?>