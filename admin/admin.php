<!DOCTYPE HTML>

<?php

session_start();
include("../config.php");
include("../functions.php");

// Connect to database...
$dbconnect=mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

if(mysqli_connect_errno()) {
	echo "Connection failed:".mysqli_connect_error();
	exit;
}

?>

<html>

<?php include("../content/head.php"); ?>
    
<body>
    
    <div class="wrapper">
        
        <?php 
        include("../content/head_nav.php")
        ?>
        
        <div class="box main">
            
            <?php 
	
            if(!isset($_REQUEST['page'])) {
                $page = "adminlogin";
            }

            else {
                // prevents users from navigating through file system
                	$page=preg_replace('/[^0-9a-zA-Z]-/','',$_REQUEST['page']);
            }
	
	// Offer logon if not logged in...
	if ($page=="logout" or $page=="adminlogin" or $page=="login")
		include("$page.php");
	
	else{
		if(!isset($_SESSION['admin'])) 
		{
			header('Location: admin.php?page=login');
		    die("You have not logged in");
		}
		else
			include("$page.php");
	}
	
	
	?>


	</div> <!-- end main -->
        

        <?php include("../content/footer.php"); ?>
    
    </div>  <!-- / wrapper  -->
    
</body>    
    
</html>
