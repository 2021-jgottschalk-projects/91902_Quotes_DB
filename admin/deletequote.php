<?php

    // delete quote!
    $deletequote_sql = "DELETE FROM quotes WHERE `ID`=".$_REQUEST['ID'];
    $deletequote_query = mysqli_query($dbconnect, $deletequote_sql)

?>

<h1>Delete Success</h1>

<p>The quote has been deleted</p>