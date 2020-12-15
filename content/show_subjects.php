<p>
    <?php
    $subject_1 = $find_rs['Subject1_ID'];
    $subject_2 = $find_rs['Subject2_ID'];
    $subject_3 = $find_rs['Subject3_ID'];
    
    $all_subjects = array($subject_1, $subject_2, $subject_3);
    // loop through items and look up their values...
    foreach ($all_subjects as $subject) {
    
    $sub_sql = "SELECT * FROM `subject` WHERE `Subject_ID` = $subject";
    $sub_query = mysqli_query($dbconnect, $sub_sql);
    $sub_rs = mysqli_fetch_assoc($sub_query);
        
    if ($subject != 0)
    {
        
    ?>
    

    
    <span class="tag"><?php echo $sub_rs['Subject']; ?> </span> &nbsp;
    
   
      
    <?php
        
     }  // end check subject if
  
    // break reference with the last element as per the manual
    unset($subject);
        
    }
    
    ?>
    
    
</p>