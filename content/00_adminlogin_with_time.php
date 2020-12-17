<?php 

if(isset($_REQUEST['login'])) {
    
    $cost = 8;
do {
    $cost++;
    $start = microtime(true);
    password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
    $end = microtime(true);
} while (($end - $start) < $timeTarget);

echo "Appropriate Cost Found: " . $cost;

    
    echo "username; ".$_REQUEST['username']."<br />";
    echo "password; ".$_REQUEST['password']."<br />";
    
    $options = ['cost' => 12,];
    
    $hashed = password_hash($_REQUEST['password'], PASSWORD_BCRYPT, $options);
    
    echo "hashed".$hashed;
	
	$login_sql="SELECT * FROM `users` WHERE `username` = 'admin' AND `password` = 'hello world'";
	
	$login_query=mysqli_query($dbconnect,$login_sql);
	
	if(mysqli_num_rows($login_query)>0) 
	{
		$login_rs=mysqli_fetch_assoc($login_query);
		$_SESSION['admin']=$login_rs['username'];
	}
	
	else {
		unset($_SESSION);
		// header("Location: index.php?page=login&error=login");
	}
	
}

if (isset($_SESSION['admin'])) {
	header('Location: index.php?page=success');
}


?>