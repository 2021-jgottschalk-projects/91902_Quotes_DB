<?php

$author_ID = $_REQUEST['ID'];

// get country list from database
$all_countries_sql="SELECT * FROM `country` ORDER BY `Country` ASC ";
$all_countries = autocomplete_list($dbconnect, $all_countries_sql, 'Country');

// get occupation list from database
$all_occupations_sql = "SELECT * FROM `career` ORDER BY `Career` ASC ";
$all_occupations = autocomplete_list($dbconnect, $all_occupations_sql, 'Career');

// get authors from database
$all_authors_sql = "SELECT * FROM `author` ORDER BY `Last` ASC ";
$all_authors_query = mysqli_query($dbconnect, $all_authors_sql);
$all_authors_rs = mysqli_fetch_assoc($all_authors_query);


// set up error fields / visibility
$first_error = $last_error = $yob_error = $gender_error = $country_1_error = $occupation_1_error = "no-error";

$first_field = $last_field = $yob_field = $gender_field = "form-ok";
$country_1_field = $occupation_1_field = "tag-ok";

// get author details
$author_rs = get_rs($dbconnect, "SELECT * FROM `author` WHERE `Author_ID` = $author_ID");
$first = $author_rs['First'];
$middle = $author_rs['Middle'];
$last = $author_rs['Last'];
$gender_code = $author_rs['Gender'];

if($gender_code=="M") {
    $gender = "Male";
}
else {
    $gender = "Female";
}

$yob = $author_rs['Born'];


// retrieve country and occupations IDs from tables...
$country1_ID = $author_rs['Country1_ID'];
$country2_ID = $author_rs['Country2_ID'];
$occupation1_ID = $author_rs['Career1_ID'];
$occupation2_ID = $author_rs['Career2_ID'];

// look up country / career names to populate edit form...
$country1_rs = get_rs($dbconnect, "SELECT * FROM `country` WHERE `Country_ID` = $country1_ID");
$country1 = $country1_rs['Country'];
$country2_rs = get_rs($dbconnect, "SELECT * FROM `country` WHERE `Country_ID` = $country2_ID");
$country2 = $country2_rs['Country'];

$occupation1_rs = get_rs($dbconnect, "SELECT * FROM `career` WHERE `Career_ID` = $occupation1_ID");
$occupation1 = $occupation1_rs['Career'];
$occupation2_rs = get_rs($dbconnect, "SELECT * FROM `career` WHERE `Career_ID` = $occupation2_ID");
$occupation2 = $occupation2_rs['Career'];

$current_author = $last.", ".$first." ".$middle;


// Code below excutes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // get values from form
    
    
    // *** checking edits so we have a quote and at least one tag ****
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

    
    // get country and occupation IDs
    $countryID_1 = get_ID($dbconnect, 'country', 'Country_ID', 'Country', $country_1);
    $countryID_2 = get_ID($dbconnect, 'country', 'Country_ID', 'Country', $country_2);

    $occupationID_1 = get_ID($dbconnect, 'career', 'Career_ID', 'Career', $occupation_1);
    $occupationID_2 = get_ID($dbconnect, 'career', 'Career_ID', 'Career', $occupation_2);

    // edit entry to database
$editauthor_sql = "UPDATE `author` SET `First` = '$first', `Last` = '$last', `Gender` = '$gender_code', `Born` = '$yob', `Country1_ID` = '$countryID_1', `Country2_ID` = '$countryID_2', `Career1_ID` = '$occupationID_1', `Career2_ID` = '$occupationID_2' WHERE `author`.`Author_ID` = $author_ID;";
$editentry_author = mysqli_query($dbconnect, $editauthor_sql);
    
    // get author ID and go to author success page
    
    
    // Go back to author page
    header('Location: index.php?page=author&authorID='.$author_ID);
    
}   // end button pushed if

?>

<div class="add-quote-form">

<h1>Edit Author...</h1>

<?php

// if author id is unknow, get author details

?>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/editauthor&ID=$author_ID");?>" enctype="multipart/form-data">
    
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
        <input id="country1" type="text" name="country1" value = "<?php echo $country1 ?>" placeholder="Country 1 (Start Typing)...">
    </div>
    
    <br/><br />
    
    <div class="autocomplete">
        <input id="country2" type="text" name="country2" value = "<?php echo $country2 ?>" placeholder="Country 2 (Start Typing)...">
    </div>
    
    <br/><br />
    
    <div class="autocomplete">
        <input id="occupation1" type="text" name="occupation1" value = "<?php echo $occupation1 ?>" placeholder="Occupation 1 (Required, Start Typing)...">
    </div>
    
    <br/><br />
    
    <div class="autocomplete">
        <input id="occupation2" type="text" name="occupation2" value = "<?php echo $occupation2 ?>"placeholder="Occupation 2 (Start Typing)...">
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

var all_countries = <?php print("$all_countries"); ?>;
autocomplete(document.getElementById("country1"), all_countries);
autocomplete(document.getElementById("country2"), all_countries);

var all_occupations = <?php print("$all_occupations"); ?>;
autocomplete(document.getElementById("occupation1"), all_occupations);
autocomplete(document.getElementById("occupation2"), all_occupations);
    


</script>