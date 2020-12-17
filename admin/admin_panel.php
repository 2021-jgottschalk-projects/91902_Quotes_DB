<?php

// check user is logged in and display content
if (isset($_SESSION['admin'])) {
	
    
    ?>

<h1>Admin Panel</h1>

<hr />

<h2>Add an Entry</h2>



<hr />


<!-- log out link -->
<a href="index.php?page=../admin/logout">Logout</a>
<p>&nbsp;</p>





<?php
    
} // end 'is set' admin check

else {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");
}

?>


