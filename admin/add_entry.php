<?php

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

$has_errors = "no";

// set up error fields / visibility
$quote_error = $tag_1_error =  "no-error";
$quote_field = $tag_1_field = "form-ok";



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