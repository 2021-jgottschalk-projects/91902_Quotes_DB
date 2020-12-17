<?php 

if(isset($_REQUEST['login'])) {
    
    // get username from form
    $username = $_REQUEST['username'];
    
    $options = ['cost' => 9,];
    
    // Get username and hashed password from database
	$login_sql="SELECT * FROM `users` WHERE `username` = '$username'";
	$login_query=mysqli_query($dbconnect,$login_sql);
    $login_rs = mysqli_fetch_assoc($login_query);
    
    
    // Hash password and compare with password in database
    
    if (password_verify($_REQUEST['password'], $login_rs['password'])) {
        
    echo 'Password is valid!';
    $_SESSION['admin']=$login_rs['username'];
    } 
    
    else {
    echo 'Invalid password.';
    unset($_SESSION);
    header("Location: index.php?page=../admin/login&error=login");
}
    
}


if (isset($_SESSION['admin'])) {
	header('Location: index.php?page=../admin/success');
}


?>