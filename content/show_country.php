<p>
    <?php
    $country_1 = $find_rs['Country1_ID'];
    $country_2 = $find_rs['Country2_ID'];
    
    $all_countries = array($country_1, $country_2);
    // loop through items and look up their values...
    
    // Counts # of countries that without ID zero...
    $num_countries = count(array_filter($all_countries));
    
        
    if ($num_countries == 1)
    {
    echo "<b>Country</b>: ";
    }
    
    else { echo "<b>Countries</b>: ";}
    
    foreach ($all_countries as $country) {
    
    $country_sql = "SELECT * FROM `country` WHERE `Country_ID` = $country";
    $country_query = mysqli_query($dbconnect, $country_sql);
    $country_rs = mysqli_fetch_assoc($country_query);
    
    if ($country != 0) {
        
    ?>
    
        
    <span class="country tag"><?php echo $country_rs['Country']; ?> </span> &nbsp;
      
    <?php
        
    } // end country if
  
    // break reference with the last element as per the manual
    unset($country);
        
    }
    
    ?>
    
    
</p>