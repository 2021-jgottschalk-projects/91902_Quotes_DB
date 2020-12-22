<?php

// check user is logged in and display content
if (isset($_SESSION['admin'])) {
	
    
    // get authors from database
    $all_authors_sql = "SELECT * FROM `author` ORDER BY `Last` ASC ";
    $all_authors_query = mysqli_query($dbconnect, $all_authors_sql);
    $all_authors_rs = mysqli_fetch_assoc($all_authors_query);
    
    // initialise author form
    
    $first = "";
    $middle = "";
    $last = "";
    
    $has_errors = "no";
    
    
    // Code below executes when the form is submitted
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get values from form...
    $author_ID = mysqli_real_escape_string($dbconnect, $_POST['author']);
        
    $_SESSION['Add_Quote']=$author_ID;
        
    echo "Author ID".$author_ID;
        
    // Go to entry page
    header('Location: index.php?page=../admin/add_entry');
        
    }   // end of button submitted code
    
    ?>

<h1>Add a Quote</h1>
<p><i>
    To add a quote, first select the author, then press the 'next' button.  If the author is not in the list, please choose the 'New Author' option.
</i></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/admin_panel");?>" enctype="multipart/form-data">
        
        <div class="">
            <b>Quote Author:</b>&nbsp; 
                
        <select name="author">
            
        <!-- first / selected option -->
        
            <?php
        if($author_ID=="") {
            ?>
            <option value="unknown" selected>New Author</option>
            <?php
        } // end no author ID if
        
    
        // get options authors from database...
    
        do {
            
            
            $author_full = $all_authors_rs['Last'].", ".$all_authors_rs['First']." ".$all_authors_rs['Middle'];
            
            ?>
            
            
            <option value="<?php echo $all_authors_rs['Author_ID']; ?>"><?php echo $author_full; ?> </option>
            
            <?php
        }   // end author do loop
    
        while($all_authors_rs=mysqli_fetch_assoc($all_authors_query))
           
        ?>
            
        </select>
            
        &nbsp;
            
        <input class="short" type="submit" name="quote_author" value="Next..." />
            
        </div>  <!-- end select author -->
                
    </form>

<p>&nbsp;</p>


<?php
    
} // end 'is set' admin check

else {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");
}

?>


