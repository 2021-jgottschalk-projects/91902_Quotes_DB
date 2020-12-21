<?php

// function to get subject ID
function get_subjectID ($dbconnect, $subject)
{
    
    if($subject == "")
    {
        return 0;
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

?>