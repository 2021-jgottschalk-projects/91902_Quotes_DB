<h2>Success!</h2>

<p>You have put the following quote into the database...</p>

<?php 
    $quote_ID=$_SESSION['Quote_Success'];

            
    $find_sql="SELECT * FROM `quotes` JOIN author ON (`author`.`Author_ID`=`quotes`.`Author_ID`) WHERE `ID` = $quote_ID";
    $find_query = mysqli_query($dbconnect, $find_sql);
    $find_rs = mysqli_fetch_assoc($find_query);
    

// Loop through results and dislay them...

do { ?>

<div class="results">

    
<?php
    include("show_results.php");
    include("show_subjects.php");
    ?>
    
</div>
<br />

<?php }

while($find_rs = mysqli_fetch_assoc($find_query))

?>
