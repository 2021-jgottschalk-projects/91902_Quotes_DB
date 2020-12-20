<?php

// function to get subject ID
function get_subjectID ($dbconnect, $subject)
{
    
    if($subject == "")
    {
        return 0
    }
    
    // get subject ID's if they exist...
    $subid_sql = "SELECT * FROM `subject` WHERE `Subject` LIKE '$subject'";
    $subid_query = mysqli_query($dbconnect, $subid_sql);
    $subid_rs = mysqli_fetch_assoc($subid_query);
    $subid_count=mysqli_num_rows($subid_query);
    
    
    // if subject ID does not exist, add new subject to database
    
    if($subid_count > 0) {
        $subject_ID = $subid_rs['Subject_ID'];
        
        echo "Subject ID".$subject_ID;
        
        return $subject_ID;
    }
    
    else {
        $add_subject_sql ="INSERT INTO `subject` (`Subject_ID`, `Subject`) VALUES (NULL, '$subject');";
        $add_subject_query = mysqli_query($dbconnect, $add_subject_sql);
        
        // get subject ID
        
        $new_sub_sql = "SELECT * FROM `subject` WHERE `Subject` LIKE '$subject'";
        $new_sub_query = mysqli_query($dbconnect, $new_sub_sql);
        $new_sub_rs = mysqli_fetch_assoc($new_sub_query);
        
        $subject_ID = $new_sub_rs['Subject_ID'];
        
        echo "Subject ID".$subject_ID;
        
        return $subject_ID;
        
    }
}

$author_ID = $_SESSION['Add_Quote'];
echo $author_ID;

// Get subject / topic list from database
$all_tags_sql = "SELECT * FROM `subject` ORDER BY `Subject_ID` ASC ";
$all_tags_query = mysqli_query($dbconnect, $all_tags_sql);
$all_tags_rs = mysqli_fetch_assoc($all_tags_query);


// Make subject array for autocomplete functionality...
while($row=mysqli_fetch_array($all_tags_query))
{
  $subject=$row['Subject'];
  $subjects[] = $subject;
}

$all_subjects=json_encode($subjects);

// initialise form variables
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
$quote_field = $tag_1_field = "form-ok";

// Code below excutes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // get values from form
    $quote = mysqli_real_escape_string($dbconnect, $_POST['quote']);
    $notes = mysqli_real_escape_string($dbconnect, $_POST['notes']);
    $tag_1 = mysqli_real_escape_string($dbconnect, $_POST['Subject_1']);
    $tag_2 = mysqli_real_escape_string($dbconnect, $_POST['Subject_2']);
    $tag_3 = mysqli_real_escape_string($dbconnect, $_POST['Subject_3']);
    
    // put checking code here in due course...
    
    $subjectID_1 = get_subjectID($dbconnect, $tag_1);
    $subjectID_2 = get_subjectID($dbconnect, $tag_2);
    $subjectID_3 = get_subjectID($dbconnect, $tag_3);
    
        
    echo "tag 1: ".$subjectID_1."<br />";
    echo "tag 2: ".$subjectID_2."<br />";
    echo "tag 3: ".$subjectID_3."<br />";
    
    // add entry to database
    $addentry_sql = "INSERT INTO `quotes` (`ID`, `Author_ID`, `Quote`, `Notes`, `Subject1_ID`, `Subject2_ID`, `Subject3_ID`) VALUES (NULL, '$author_ID', '$quote', '$notes', '$subjectID_1', '$subjectID_2', '$subjectID_3');";
    $addentry_query = mysqli_query($dbconnect, $addentry_sql);
    
    // get quote ID for next page
    
}   // end button pushed if

?>

<div class="add-quote-form">

<h1>Add Quote...</h1>

<?php

// if author id is unknow, get author details

?>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/add_entry");?>" enctype="multipart/form-data">
    

    <!-- Quote text area -->
    <div class="<?php echo $quote_error; ?>">
        This field can't be blank
    </div>

    <textarea class="add-field <?php echo $quote_field?>" name="quote" rows="6"><?php echo $quote; ?></textarea>
    <br/><br />
    
    <input class="add-field <?php echo $notes; ?>" type="text" name="notes" value="<?php echo $notes; ?>" placeholder="Notes (optional) ..."/>
    
    <br/><br />
    
    <div class="autocomplete">
        <input id="subject1" type="text" name="Subject_1" placeholder="Subject 1(Start Typing)...">
    </div>
    
    <br/><br />
    
    <div class="autocomplete">
        <input id="subject2" type="text" name="Subject_2" placeholder="Subject 2 (Start Typing, optional)...">
    </div>
    
    <br/><br />
    
    <div class="autocomplete">
        <input id="subject3" type="text" name="Subject_3" placeholder="Subject 3 (Start Typing, optional)...">
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
    
/*An array containing all the country names in the world:*/
var all_tags = <?php print("$all_subjects"); ?>

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("subject1"), all_tags);
autocomplete(document.getElementById("subject2"), all_tags);
autocomplete(document.getElementById("subject3"), all_tags);
    
</script>