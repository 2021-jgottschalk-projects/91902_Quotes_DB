<form action="index.php?page=adminlogin" method="post">

<p>Username: <input name="username" /></p>
<p>Password: <input name="password" type="password" /></p>

<?php
if(isset($_GET['error'])) {
	echo "<span class=\"error\">Incorrect username / password</span>";
	}
?>

<p><input type="submit" name="login" value="Log In" /></p>

</form>