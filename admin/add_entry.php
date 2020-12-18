<?php

$author_ID = $_SESSION['Add_Quote'];
echo $author_ID;

// Get subject / topic list from database
$all_tags_sql = "SELECT * FROM `subject` ORDER BY `Subject_ID` ASC ";
$all_tags_query = mysqli_query($dbconnect, $all_tags_sql);
$all_tags_rs = mysqli_fetch_assoc($all_tags_query);


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

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/add_entry");?>" enctype="multipart/form-data">
    

    <!-- Quote text area -->
    <div class="<?php echo $quote_error; ?>">
        This field can't be blank
    </div>

    <textarea class="add-field <?php echo $quote_field?>" name="quote" rows="6"><?php echo $quote; ?></textarea>
    
    
    <input class="add-field <?php echo $notes; ?>" type="text" name="notes" value="<?php echo $notes; ?>" placeholder="Notes (optional) ..."/>
    
    <input class="add-field" type='text' id='autocomplete' placeholder="Type in a subject rag" name="tag_1">
    
        <!-- Submit Button -->
    <p>
        <input type="submit" value="Submit" />
    </p>
    
</form>
    
</div>      <!-- end add entry div -->