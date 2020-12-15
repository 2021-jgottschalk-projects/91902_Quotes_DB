<p>
    <?php
    $career_1 = $find_rs['Career1_ID'];
    $career_2 = $find_rs['Career2_ID'];
    
    $all_careers = array($career_1, $career_2);
    // loop through items and look up their values...
    
    // Counts # of countries that without ID zero...
    $num_careers = count(array_filter($all_countries));
    
        
    if ($num_careers == 1)
    {
    echo "<b>Occupation</b>: ";
    }
    
    else { echo "<b>Occupations</b>: ";}
    
    foreach ($all_careers as $career) {
    
    $career_sql = "SELECT * FROM `career` WHERE `Career_ID` = $career";
    $career_query = mysqli_query($dbconnect, $career_sql);
    $career_rs = mysqli_fetch_assoc($career_query);
    
    if ($career != 0) {
        
    ?>
    
        
    <span class="career tag"><?php echo $career_rs['Career']; ?> </span> &nbsp;
      
    <?php
        
    } // end country if
  
    // break reference with the last element as per the manual
    unset($career);
        
    }
    
    ?>
    
    
</p>