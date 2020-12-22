<?php

$ID = $_REQUEST['ID'];
echo "ID: ".$ID.'<br />';

$find_quote_sql = "SELECT * FROM `quotes` WHERE `ID` = $ID";
$find_quote_query = mysqli_query($dbconnect, $find_quote_sql);
$find_quote_rs = mysqli_fetch_assoc($find_quote_query);

$author_ID = $find_quote_rs['Author_ID'];

// Get subject / topic list from database
$all_tags_sql = "SELECT * FROM `subject` ORDER BY `Subject` ASC ";
$all_subjects = autocomplete_list($dbconnect, $all_tags_sql, 'Subject');


// Get quote and notes data
$quote = $find_quote_rs['Quote'];
$notes = $find_quote_rs['Notes'];


// Get subjects to populate tags..
$subject1_ID = $find_quote_rs['Subject1_ID'];
$subject2_ID = $find_quote_rs['Subject2_ID'];
$subject3_ID = $find_quote_rs['Subject3_ID'];

// retrieve subject names from subject table...
$tag_1_rs = get_rs($dbconnect, "SELECT * FROM `subject` WHERE Subject_ID = $subject1_ID");
$tag_1 = $tag_1_rs['Subject'];

$tag_2_rs = get_rs($dbconnect, "SELECT * FROM `subject` WHERE Subject_ID = $subject2_ID");
$tag_2 = $tag_2_rs['Subject'];

$tag_3_rs = get_rs($dbconnect, "SELECT * FROM `subject` WHERE Subject_ID = $subject3_ID");
$tag_3 = $tag_3_rs['Subject'];

// initialise tag ID's
$tag_1_ID = $tag_2_ID = $tag_3_ID = 0;

$has_errors = "no";

// set up error fields / visibility
$quote_error = $tag_1_error =  "no-error";
$quote_field = "form-ok";
$tag_1_field = "tag-ok";

// Code below excutes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // get values from quote secion of form
    $quote = mysqli_real_escape_string($dbconnect, $_POST['quote']);
    $notes = mysqli_real_escape_string($dbconnect, $_POST['notes']);
    $tag_1 = mysqli_real_escape_string($dbconnect, $_POST['Subject_1']);
    $tag_2 = mysqli_real_escape_string($dbconnect, $_POST['Subject_2']);
    $tag_3 = mysqli_real_escape_string($dbconnect, $_POST['Subject_3']);
    
    // *** checking edits so we have a quote and at least one tag ****
    
    // check quote name is not blank
    if ($quote == "Please type your quote here") {
        $has_errors = "yes";
        $quote_error = "error-text";
        $quote_field = "form-error";
        }
    
    // check that first subject has been filled in
    if ($tag_1 == "") {
        $has_errors = "yes";
        $tag_1_error = "error-text";
        $tag_1_field = "tag-error";
        }
    
    
    // Get subject ID's via get_ID function...
    $subjectID_1 = get_ID($dbconnect, 'subject', 'Subject_ID', 'Subject', $tag_1);
    $subjectID_2 = get_ID($dbconnect, 'subject', 'Subject_ID', 'Subject', $tag_2);
    $subjectID_3 = get_ID($dbconnect, 'subject', 'Subject_ID', 'Subject', $tag_3);
    
    
    // edit entry to database
$editentry_sql = "UPDATE `quotes` SET `Quote` = '$quote', `Notes` = '$notes', `Subject1_ID` = '$subjectID_1', `Subject2_ID` = '$subjectID_2', `Subject3_ID` = '$subjectID_3' WHERE `quotes`.`ID` = $ID;";
$editentry_query = mysqli_query($dbconnect, $editentry_sql);
    
    // get quote ID for next page
    $get_quote_sql = "SELECT * FROM `quotes` WHERE `Quote` = '$quote'";
    $get_quote_query = mysqli_query($dbconnect, $get_quote_sql);
    $get_quote_rs = mysqli_fetch_assoc($get_quote_query);
    
    $quote_ID = $get_quote_rs['ID'];
    $_SESSION['Quote_Success']=$quote_ID;
    
    
    // Go to success page...
    header('Location: index.php?page=quote_success');
    
}   // end button pushed if

?>

<div class="add-quote-form">

<h1>Edit Quote...</h1>

<?php

// if author id is unknow, get author details

?>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/editquote&ID=$ID");?>" enctype="multipart/form-data">
    
    
    <!-- Quote text area -->
    <div class="<?php echo $quote_error; ?>">
        This field can't be blank
    </div>

    <textarea class="add-field <?php echo $quote_field?>" name="quote" rows="6"><?php echo $quote; ?></textarea>
    <br/><br />
    
    <input class="add-field <?php echo $notes; ?>" type="text" name="notes" value="<?php echo $notes; ?>" placeholder="Notes (optional) ..."/>
    
    <br/><br />
    
    <div class="<?php echo $tag_1_error ?>">
        Please enter at least one subject tag
    </div>
    <div class="autocomplete">
        <input class="<?php echo $tag_1_field; ?>" id="subject1" type="text" value="<?php echo $tag_1; ?>" name="Subject_1" placeholder="Subject 1(Start Typing)...">
    </div>
    
    <br/><br />
    
    <div class="autocomplete">
        <input id="subject2" type="text" value="<?php echo $tag_2; ?>" name="Subject_2" placeholder="Subject 2 (Start Typing, optional)...">
    </div>
    
    <br/><br />
    
    <div class="autocomplete">
        <input id="subject3" type="text" value="<?php echo $tag_3; ?>" name="Subject_3" placeholder="Subject 3 (Start Typing, optional)...">
    </div>
    
    <br/><br />
    
        <!-- Submit Button -->
    <p>
        <input type="submit" value="Submit" />
    </p>
    
</form>
    
</div>      <!-- end add entry div -->


<!-- script to make autocomplete work -->
<script>

/* bunch of functions to make autocomplete work */
<?php include("autocomplete.php"); ?>
    
/* Arrays containing lists. */
var all_tags = <?php print("$all_subjects"); ?>;
autocomplete(document.getElementById("subject1"), all_tags);
autocomplete(document.getElementById("subject2"), all_tags);
autocomplete(document.getElementById("subject3"), all_tags);
    


</script>