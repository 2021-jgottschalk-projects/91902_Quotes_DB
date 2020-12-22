<?php echo $_REQUEST['ID']; 

// initialise variables
$quote = "Please type your quote here";
$notes = "";
$tag_1 = "";
$tag_2 = "";
$tag_3 = "";

// Put in error stuff here

// get content to populate form
$ID=preg_replace('/[^0-9.]/','',$_REQUEST['ID']);

$find_sql = "SELECT * from quotes WHERE ID = ".$ID;
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

$author_ID = $find_rs['Author_ID'];
$quote = $find_rs['Quote'];
$notes = $find_rs['Notes'];

$subject1_ID = $find_rs['Subject1_ID'];
$subject2_ID = $find_rs['Subject2_ID'];
$subject3_ID = $find_rs['Subject3_ID'];

// retrieve subject names from subject table...
/*
$tag_1_sql = "SELECT * FROM `subject` WHERE Subject_ID = $subject1_ID";
$tag_1_query = mysqli_query($dbconnect, $tag_1_sql);
$tag_1_rs = mysqli_fetch_assoc($tag_1_query);

$tag_1 = $tag_1_rs['Subject']; */

$tag_1_rs = get_rs($dbconnect, "SELECT * FROM `subject` WHERE Subject_ID = $subject1_ID");
$tag_1 = $tag_1_rs['Subject'];


// if everything is ok, update databasee and show updated item

// update database

// show item

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