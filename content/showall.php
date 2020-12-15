<h2>All Results</h2>

<?php

$find_sql = "SELECT * FROM quotes
JOIN author ON (`author`.`Author_ID`=`quotes`.`Author_ID`)
";

$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

// Loop through results and dislay them...

do { ?>

<div class="results">
<p>
    <?php echo $find_rs['Quote']; ?><br />
    <i>  <?php echo $find_rs['First']; ?> 
         <?php echo $find_rs['Middle']; ?> 
        <?php echo $find_rs['Last']; ?>
    </i>
</p>
<p>
    <?php
    $subject_1 = $find_rs['Subject1_ID'];
    $subject_2 = $find_rs['Subject2_ID'];
    $subject_3 = $find_rs['Subject3_ID'];
    
    echo "Subject 1: ".$subject_1;
    
    $sub1_sql = "SELECT * FROM `subject` WHERE `Subject_ID` = $subject_1";
    $sub_query = mysqli_query($dbconnect, $sub1_sql);
    $sub_rs = mysqli_fetch_assoc($sub_query);
    
    
    ?>
    
    <p><?php echo $sub_rs['Subject']; ?>
    
    
</p>
    
</div>
<br />

<?php }

while($find_rs = mysqli_fetch_assoc($find_query))

?>

