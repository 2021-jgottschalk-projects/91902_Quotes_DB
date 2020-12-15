<?php

if(!isset($_REQUEST['subjectID']))
{
    header('Location: index.php');
}

$subject_to_find = $_REQUEST['subjectID'];

    $sub_sql = "SELECT * FROM `subject` WHERE `Subject_ID` = $subject_to_find";
    $sub_query = mysqli_query($dbconnect, $sub_sql);
    $sub_rs = mysqli_fetch_assoc($sub_query);

?>

<h2>Subject Results (<?php echo $sub_rs['Subject']?>)</h2>

<?php


$find_sql = "SELECT * FROM quotes
JOIN author ON (`author`.`Author_ID`=`quotes`.`Author_ID`)
WHERE `Subject1_ID` = $subject_to_find 
OR `Subject2_ID` = $subject_to_find 
OR `Subject3_ID` = $subject_to_find 
";

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

