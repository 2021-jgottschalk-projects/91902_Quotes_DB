<?php

    // delete quotes!
    $deletequote_sql = "DELETE FROM quotes WHERE `Author_ID`=".$_REQUEST['ID'];
    $deletequote_query = mysqli_query($dbconnect, $deletequote_sql);
        
    // delete author
 
    $delete_author_sql = "DELETE FROM `author` WHERE `author`.`Author_ID` =".$_REQUEST['ID'];
    $delete_author_query = mysqli_query($dbconnect, $delete_author_sql);
?>

<h1>Delete Success</h1>

<p>The author and associated quotes have been deleted</p>