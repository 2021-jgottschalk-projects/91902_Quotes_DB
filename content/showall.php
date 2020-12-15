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
    
<?php
    include("show_subjects.php");
    ?>
    
</div>
<br />

<?php }

while($find_rs = mysqli_fetch_assoc($find_query))

?>

