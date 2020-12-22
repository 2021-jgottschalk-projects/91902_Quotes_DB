<h2>Delete Quote - Confirm</h2>

<?php
$deletequote_sql = "SELECT * FROM `quotes` WHERE `ID` =".$_REQUEST['ID'];
$deletequote_query = mysqli_query($dbconnect, $deletequote_sql);
$deletequote_rs=mysqli_fetch_assoc($deletequote_query);

?>

<p>Do you really want to delete the following quote...<br />
<i><?php echo $deletequote_rs['Quote']; ?></i></p>

<p>
    <a href="index.php?page=../admin/deletequote&ID=<?php echo $_REQUEST['ID']; ?>">Yes, Delete it!</a> |
    <a href="index.php">No, take me home</a>
</p>
