<?php

if(!isset($_REQUEST['authorID']))
{
    header('Location: index.php');
}

$author_to_find = $_REQUEST['authorID'];

$find_sql = "SELECT * FROM quotes
JOIN author ON (`author`.`Author_ID`=`quotes`.`Author_ID`)
WHERE `quotes`.`Author_ID`= $author_to_find";

$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

$author_name = $find_rs['First']." ".$find_rs['Middle']." ".$find_rs['Last'];

?>

<h2><?php echo $author_name; ?> Quotes</h2>

<?php

// Loop through results and dislay them...

do { ?>

<div class="results">
<p>
    
    
    <?php
    // remove non-standard characters from quotes
    $quote = preg_replace('/[^A-Za-z0-9.,\s\'\-]/', ' ', $find_rs['Quote']);
    echo $quote."<br />";
    ?>
    
    
    <i>  
        <a href="index.php?page=author&authorID=<?php echo $find_rs['Author_ID']; ?>">
        <?php echo $find_rs['First']; ?> 
         <?php echo $find_rs['Middle']; ?> 
        <?php echo $find_rs['Last']; ?>
        </a>
    </i>
</p>
<p>
    <?php
    $subject_1 = $find_rs['Subject1_ID'];
    $subject_2 = $find_rs['Subject2_ID'];
    $subject_3 = $find_rs['Subject3_ID'];
    
    $all_subjects = array($subject_1, $subject_2, $subject_3);
    // loop through items and look up their values...
    foreach ($all_subjects as $subject) {
    
    $sub_sql = "SELECT * FROM `subject` WHERE `Subject_ID` = $subject";
    $sub_query = mysqli_query($dbconnect, $sub_sql);
    $sub_rs = mysqli_fetch_assoc($sub_query);
        
    echo $sub_rs['Subject']."&nbsp; &nbsp;"; 
        
  
    // break reference with the last element as per the manual
    unset($subject);
        
    }
    
    ?>
    
    
</p>
    
</div>
<br />

<?php }

while($find_rs = mysqli_fetch_assoc($find_query))

?>

