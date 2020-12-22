<?php

// Get subject / topic list from database
$all_tags_sql = "SELECT * FROM `subject` ORDER BY `Subject` ASC ";
$all_subjects = autocomplete_list($dbconnect, $all_tags_sql, 'Subject');

// initialise variables
$quote = "Please type your quote here";
$notes = "";
$tag_1 = "";
$tag_2 = "";
$tag_3 = "";

// initialise tag ID's
$tag_1_ID = $tag_2_ID = $tag_3_ID = 0;

$has_errors = "no";

// set up error fields / visibility
$quote_error = $tag_1_error =  "no-error";
$quote_field = "form-ok";
$tag_1_field = "tag-ok";

// Put in error stuff here

// get content to populate form
// $ID=preg_replace('/[^0-9.]/','',$_REQUEST['ID']);
$ID = 155;
echo "ID: ".$ID.'<br />';

$find_sql = "SELECT * FROM `quotes` WHERE `ID` = $ID";
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

$author_ID = $find_rs['Author_ID'];
$quote = $find_rs['Quote'];
$notes = $find_rs['Notes'];

$subject1_ID = $find_rs['Subject1_ID'];
$subject2_ID = $find_rs['Subject2_ID'];
$subject3_ID = $find_rs['Subject3_ID'];

// retrieve subject names from subject table...
$tag_1_rs = get_rs($dbconnect, "SELECT * FROM `subject` WHERE Subject_ID = $subject1_ID");
$tag_1 = $tag_1_rs['Subject'];

$tag_2_rs = get_rs($dbconnect, "SELECT * FROM `subject` WHERE Subject_ID = $subject2_ID");
$tag_2 = $tag_2_rs['Subject'];

$tag_3_rs = get_rs($dbconnect, "SELECT * FROM `subject` WHERE Subject_ID = $subject3_ID");
$tag_3 = $tag_3_rs['Subject'];


// Code below excutes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
// get items from form...
$quote = mysqli_real_escape_string($dbconnect, $_POST['quote']);
$notes = mysqli_real_escape_string($dbconnect, $_POST['notes']);
$tag_1 = mysqli_real_escape_string($dbconnect, $_POST['Subject_1']);
$tag_2 = mysqli_real_escape_string($dbconnect, $_POST['Subject_2']);
$tag_3 = mysqli_real_escape_string($dbconnect, $_POST['Subject_3']);

// Get subject ID's via get_ID function...
$subjectID_1 = get_ID($dbconnect, 'subject', 'Subject_ID', 'Subject', $tag_1);
$subjectID_2 = get_ID($dbconnect, 'subject', 'Subject_ID', 'Subject', $tag_2);
$subjectID_3 = get_ID($dbconnect, 'subject', 'Subject_ID', 'Subject', $tag_3);
    
// if everything is ok, update databasee and show updated item
$editentry_sql = "UPDATE `quotes` SET `Quote` = '$quote', `Notes` = '$notes', `Subject1_ID` = '$subject1_ID', `Subject2_ID` = '$subject2_ID', `Subject3_ID` = '$subject3_ID' WHERE `quotes`.`ID` = $ID;";
$editentry_query = mysqli_query($dbconnect, $editentry_sql);
$editentry_rs = mysqli_fetch_assoc($editentry_query);

$_SESSION['Quote_Sucess']=$ID;

// Go to success page...
// header('Location: index.php?page=quote_success');

} // end button puahed

?>

<div class="add-quote-form">
    
    <h1>Edit Quote...</h1>
    
    <form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/editquote");?>" enctype="multipart/form-data">
        
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
        <input class="<?php echo $tag_1_field; ?>" id="subject1" type="text" name="Subject_1" value="<?php echo $tag_1; ?>" placeholder="Subject 1(Start Typing)...">
    </div>
    
    <br/><br />
    
    <div class="autocomplete">
        <input id="subject2" type="text" name="Subject_2" value="<?php echo $tag_2; ?>" placeholder="Subject 2 (Start Typing, optional)...">
    </div>
    
    <br/><br />
    
    <div class="autocomplete">
        <input id="subject3" type="text" name="Subject_3" value="<?php echo $tag_3; ?>" placeholder="Subject 3 (Start Typing, optional)...">
    </div>
    
    <br/><br />
    
        <!-- Submit Button -->
    <p>
        <input type="submit" value="Submit" />
    </p>
    
</form>
    
</div>      <!-- end edit entry div -->


<!-- script to make autocomplete work -->
<script>

/* bunch of functions to make autocomplete work */
<?php include("autocomplete.php"); ?>
    
/* Arrays containing lists. */
var all_tags = <?php print("$all_subjects"); ?>;
autocomplete(document.getElementById("subject1"), all_tags);
autocomplete(document.getElementById("subject2"), all_tags);
autocomplete(document.getElementById("subject3"), all_tags);
    
var all_countries = <?php print("$all_countries"); ?>;
autocomplete(document.getElementById("country1"), all_countries);
autocomplete(document.getElementById("country2"), all_countries);

var all_occupations = <?php print("$all_occupations"); ?>;
autocomplete(document.getElementById("occupation1"), all_occupations);
autocomplete(document.getElementById("occupation2"), all_occupations);

</script>