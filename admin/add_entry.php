<?php


// entity is subject, country, occupation etc
function autocomplete_list($dbconnect, $item_sql, $entity)    
{
// Get entity / topic list from database
$all_items_query = mysqli_query($dbconnect, $item_sql);
$all_items_rs = mysqli_fetch_assoc($all_items_query); 
    
// Make item arrays for autocomplete functionality...
while($row=mysqli_fetch_array($all_items_query))
{
  $item=$row[$entity];
  $items[] = $item;
}

$all_items=json_encode($items);
return $all_items;
    
}


$author_ID = $_SESSION['Add_Quote'];

// Get subject / topic list from database
$all_tags_sql = "SELECT * FROM `subject` ORDER BY `Subject` ASC ";
$all_subjects = autocomplete_list($dbconnect, $all_tags_sql, 'Subject');


// get country list from database
$all_countries_sql="SELECT * FROM `country` ORDER BY `Country` ASC ";
$all_countries = autocomplete_list($dbconnect, $all_countries_sql, 'Country');

$all_occupations_sql = "SELECT * FROM `career` ORDER BY `Career` ASC ";
$all_occupations = autocomplete_list($dbconnect, $all_occupations_sql, 'Career');

// if author not known, initialise variables and set up error messages

if($author_ID=="unknown")
{
    $first = "";
    $middle = "";
    $last = "";
    $yob = "";
    $gender_code = "";
    $country_1 = "";
    $country_2 = "";
    $occupation_1 = "";
    $occupation_2 = "";
    
    // Initialise country and occupation ID's
    $country_1_ID = $country_2_ID = $occupation_1_ID = $occupation_2_ID = 0;
        
    // set up error fields / visibility
    $first_error = $last_error = $yob_error = $gender_error = $country_1_error = $occupation_1_error = "no-error";
    
    $first_field = $last_field = $yob_field = $gender_field = "form-ok";
    $country_1_field = $occupation_1_field = "tag-ok";
        
}


// initialise form variables for quote
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

// Code below excutes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // if author is unknown, get values from author part of form
    if($author_ID=="unknown")
    {
    $first = mysqli_real_escape_string($dbconnect, $_POST['first']); 
    $middle = mysqli_real_escape_string($dbconnect, $_POST['middle']); 
    $last = mysqli_real_escape_string($dbconnect, $_POST['last']); 
    $yob = mysqli_real_escape_string($dbconnect, $_POST['yob']); 
        
    $gender_code = mysqli_real_escape_string($dbconnect, $_POST['gender']); 
    if ($gender_code=="F") {
        $gender = "Female";
    }
    else if ($gender_code=="M") {
            $gender = "Male";
        }
        
    else {
        $gender = "";
    }
        
    $country_1 = mysqli_real_escape_string($dbconnect, $_POST['country1']);
    $country_2 = mysqli_real_escape_string($dbconnect, $_POST['country2']);
    $occupation_1 = mysqli_real_escape_string($dbconnect, $_POST['occupation1']);
    $occupation_2 = mysqli_real_escape_string($dbconnect, $_POST['occupation2']);
        
    }   // end of getting new author values
    
    // get values from quote secion of form
    $quote = mysqli_real_escape_string($dbconnect, $_POST['quote']);
    $notes = mysqli_real_escape_string($dbconnect, $_POST['notes']);
    $tag_1 = mysqli_real_escape_string($dbconnect, $_POST['Subject_1']);
    $tag_2 = mysqli_real_escape_string($dbconnect, $_POST['Subject_2']);
    $tag_3 = mysqli_real_escape_string($dbconnect, $_POST['Subject_3']);
    
    // put checking code here in due course...
    
    if ($author_ID=="unknown")
    {
        if ($first == "") {
        $has_errors = "yes";
        $first_error = "error-text";
        $first_field = "form-error";
        }
        
        if ($last == "") {
        $has_errors = "yes";
        $last_error = "error-text";
        $last_field = "form-error";
        }
        
        if ($gender == "") {
        $has_errors = "yes";
        $gender_error = "error-text";
        $gender_field = "form-error";
        }
        
        if ($country_1 == "") {
        $has_errors = "yes";
        $country_1_error = "error-text";
        $country_1_field = "tag-error";
        }
        
        if ($occupation_1 == "") {
        $has_errors = "yes";
        $occupation_1_error = "error-text";
        $occupation_1_field = "tag-error";
        }
        
        // get country and occupation IDs
        $countryID_1 = get_ID($dbconnect, 'country', 'Country_ID', 'Country', $country_1);
        $countryID_2 = get_ID($dbconnect, 'country', 'Country_ID', 'Country', $country_2);
        
        $occupationID_1 = get_ID($dbconnect, 'career', 'Career_ID', 'Career', $occupation_1);
        $occupationID_2 = get_ID($dbconnect, 'career', 'Career_ID', 'Career', $occupation_2);
            
        // add author to database
        $add_author_sql = "INSERT INTO `author` (`Author_ID`, `First`, `Middle`, `Last`, `Gender`, `Born`, `Country1_ID`, `Country2_ID`, `Career1_ID`, `Career2_ID`) VALUES (NULL, '$first', '$middle', '$last', '$gender_code', '$yob', '$countryID_1', '$countryID_2', '$occupationID_1', '$occupationID_2');";
        $add_author_query = mysqli_query($dbconnect, $add_author_sql);
        
        // Get Author ID
        $find_author_sql = "SELECT * FROM `author` WHERE `Last` = '$last'";
        $find_author_query = mysqli_query($dbconnect, $find_author_sql);
        $find_author_rs = mysqli_fetch_assoc($find_author_query);
        
        $new_authorID = $find_author_rs['Author_ID'];
        echo "New Author ID:".$new_authorID;
        
        $author_ID = $new_authorID;
        
        
    }   // end unknown author if
    
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
    
    
    // add entry to database
    $addentry_sql = "INSERT INTO `quotes` (`ID`, `Author_ID`, `Quote`, `Notes`, `Subject1_ID`, `Subject2_ID`, `Subject3_ID`) VALUES (NULL, '$author_ID', '$quote', '$notes', '$subjectID_1', '$subjectID_2', '$subjectID_3');";
    $addentry_query = mysqli_query($dbconnect, $addentry_sql); 
    
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

<h1>Add Quote...</h1>

<?php

// if author id is unknow, get author details

?>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/add_entry");?>" enctype="multipart/form-data">
    
    
    <?php
    
    if ($author_ID=="unknown")
    {
            
        ?>
    <!-- Get author details if not known -->
    <div class="<?php echo $first_error; ?>">
        Author's first name can't be blank
    </div>
    
    <input class="add-field <?php echo $first_field; ?>" type="text" name="first" value="<?php echo $first; ?>" placeholder="Author's First Name" />
            
    <br /><br />
    
    <input class="add-field <?php echo $middle_field; ?>" type="text" name="middle" value="<?php echo $middle; ?>" placeholder="Author's Middle Name (optional)" />
            
    <br /><br />
    
    <div class="<?php echo $last_error; ?>">
        Author's last name can't be blank
    </div>
    
    <input class="add-field <?php echo $yob_field; ?>" type="text" name="last" value="<?php echo $last; ?>" placeholder="Author's Last Name" />
            
    <br /><br />
    
    <select class="adv <?php echo $gender_field; ?>" name="gender">
        
        <?php 
        if($gender_code=="") {
        ?>
            
        <option value="" selected>Gender (Choose something)... </option>
        
        <?php
        }
        
        else {
            ?>
        <option value="<?php echo $gender_code;?>" selected><?php echo $gender; ?></option>
        
        <?php
        
        }
        ?>
        
        <option value="F">Female</option>
        <option value="M">Male</option>
        
    </select>
    
    <br /><br />
    
    <div class="<?php echo $yob_error; ?>">
        Author's Year of Birth can't be blank
    </div>
    
    <input class="add-field <?php echo $yob_field; ?>" type="text" name="yob" value="<?php echo $yob; ?>" placeholder="Author's year of birth" />
            
    <br /><br />
    
    <div class="autocomplete">
        <input id="country1" type="text" name="country1" placeholder="Country 1 (Start Typing)...">
    </div>
    
    <br/><br />
    
    <div class="autocomplete">
        <input id="country2" type="text" name="country2" placeholder="Country 2 (Start Typing)...">
    </div>
    
    <br/><br />
    
    <div class="autocomplete">
        <input id="occupation1" type="text" name="occupation1" placeholder="Occupation 1 (Required, Start Typing)...">
    </div>
    
    <br/><br />
    
    <div class="autocomplete">
        <input id="occupation2" type="text" name="occupation2" placeholder="Occupation 2 (Start Typing)...">
    </div>
    
    <br/><br />
    
    <?php
        
    } // end unknown author if / form
    
    ?>

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
        <input class="<?php echo $tag_1_field; ?>" id="subject1" type="text" name="Subject_1" placeholder="Subject 1(Start Typing)...">
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