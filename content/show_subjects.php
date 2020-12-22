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
    
    <!-- show subjects -->
    <span class="tag">
        <a href="index.php?page=subject&subjectID=<?php echo $sub_rs['Subject_ID']; ?>">
            <?php echo $sub_rs['Subject']; ?></a>
        
    </span> &nbsp;
    
   
      
    <?php
        
     }  // end check subject if
  
    // break reference with the last element as per the manual
    unset($subject);
        

    }   // end subject loop
    
    
    // if logged in, show edit / delete options...
    if (isset($_SESSION['admin'])) {
        
        ?>
    <div class="edit-tools">

    
    <!-- add quote in link -->      
    <a href="index.php?page=../admin/editquote&ID=<?php echo $find_rs['ID']; ?>" title="Edit quote"><i class="fa fa-edit fa-2x"></i></a>

    &nbsp; &nbsp;

    <a href="index.php?page=../admin/deletequote_confirm&ID=<?php echo $find_rs['ID']; ?>" title="Delete quote"><i class="fa fa-trash fa-2x"></i></a>
    </div>
    
    <?php
        
    }   // end logged in if showing editing tools
    
    ?>
    
    
</p>