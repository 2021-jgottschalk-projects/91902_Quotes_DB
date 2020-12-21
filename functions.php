<?php 

// function to 'clean' data
function test_input($data) {
	$data = trim($data);	
	$data = htmlspecialchars($data); //  needed for correct special character rendering
	return $data;
}

// function to get subject, cuontry & career ID's
function get_ID($dbconnect, $table_name, $column_ID, $column_name, $entity)
{
    
    if($entity=="")
    {
        return 0;
    }
    
    
    // get entity ID if it exists
    $findid_sql = "SELECT * FROM $table_name WHERE $column_name LIKE '$entity'";
    $findid_query = mysqli_query($dbconnect, $findid_sql);
    $findid_rs = mysqli_fetch_assoc($findid_query);
    $findid_count=mysqli_num_rows($findid_query);
    
    // If subject ID does exists, return it...
    if($findid_count > 0) {
        $find_ID = $findid_rs[$column_ID];
        return $find_ID;
    }   // end if (entity existed, ID returned)
    

    else {
        $add_entity_sql = "INSERT INTO $table_name ($column_ID, $column_name) VALUES (NULL, '$entity');";
        $add_entity_query = mysqli_query($dbconnect, $add_entity_sql);
        
    $new_id_sql = "SELECT * FROM $table_name WHERE $column_name LIKE '$entity'";
    $new_id_query = mysqli_query($dbconnect, $new_id_sql);
    $new_id_rs = mysqli_fetch_assoc($new_id_query);
        
    $new_id = $new_id_rs[$column_ID];
    
    return $new_id;
        
    }   // end else (entity added to table and ID returned)
    
} // end get ID function

?>