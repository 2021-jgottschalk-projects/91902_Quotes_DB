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

<p>&nbsp;</p>

<div class="about">
    <h2>
        <?php echo $author_name ?> - About
    </h2>
    
    <p><b>Born:</b> <?php echo $find_rs['Born']; ?> </p>
        
    
    <?php
    // get country
    include("show_country.php");
    
    
    // get career
    include("show_career.php");
        
    
    // if logged in, show edit / delete options...
    if (isset($_SESSION['admin'])) {
        
        ?>
    <div class="edit-tools">

    
    <!-- add quote in link -->      
    <a href="index.php?page=../admin/editauthor&ID=<?php echo $find_rs['Author_ID']; ?>" title="Edit author"><i class="fa fa-edit fa-2x"></i></a>

    &nbsp; &nbsp;

    <a href="index.php?page=../admin/deleteauthor_confirm&ID=<?php echo $find_rs['Author_ID']; ?>" title="Delete Author"><i class="fa fa-trash fa-2x"></i></a>
    </div>
    
    <?php
        
    }   // end logged in if showing editing tools
    
    ?>
    


    
</div>

<p>&nbsp;</p>

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
    
    
</p>

    <?php
    include("show_subjects.php");
    ?>
    
</div>
<br />

<?php }

while($find_rs = mysqli_fetch_assoc($find_query))

?>

