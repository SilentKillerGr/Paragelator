<?php
//Include the database configuration file
include 'dbconnect.php';

if(!empty($_POST["sector_id"])){
    //Fetch all state data
    $query = $conn->query("SELECT * FROM tables WHERE sect_id = ".$_POST['sector_id']." ORDER BY table_name ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //State option list
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){ 
            echo '<option value="'.$row['table_id'].'">'.$row['table_name'].'</option>';
        }
    }else{
        echo '<option value="">Table not available</option>';
    }
}
?>