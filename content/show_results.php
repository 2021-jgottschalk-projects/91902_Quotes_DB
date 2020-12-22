<p>
    
    
    <?php
    // remove non-standard characters from quotes
    $quote = preg_replace('/[^A-Za-z0-9.,\s\'\-]/', ' ', $find_rs['Quote']);
    
    // Display quote
    echo $quote."<br /><br />";
    ?>
    
    
    <!-- show author name -->
    <span class="country tag">
    <i>  
        <a href="index.php?page=author&authorID=<?php echo $find_rs['Author_ID']; ?>">
        <?php echo $find_rs['First']; ?> 
         <?php echo $find_rs['Middle']; ?> 
        <?php echo $find_rs['Last']; ?>
        </a>
    </i>
    </span>
</p>