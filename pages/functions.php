<?php
session_start();
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

if(!empty($_POST["status_id"])){
	?>
<meta http-equiv="refresh" content="3; URL=index.php?disp_id=vorders&statusid=<?php echo $_POST['status_id']; ?>">
<?php
	if(isset($_GET['statusid'])){
		$_POST['status_id'] = $_GET['statusid'];
	}
	if($_POST['status_id'] == "-1"){
											if($_SESSION['role_id'] == 0){
												$sql = "SELECT * FROM ordhead WHERE date = DATE(NOW()) ORDER BY regtime DESC";
											}else{
												$sql = "SELECT * FROM ordhead ORDER BY regtime DESC";
											}
											$result = $conn->query($sql);
											$sql2 = "SELECT * FROM tables";
											$result2 = $conn->query($sql2);
											$row2 = $result2->fetch_assoc();
											if ($result->num_rows > 0) {
												// output data of each row
												while($row = $result->fetch_assoc()) {									
								?>
                                    <tr align="center" >
										<td><?php echo $row['order_id']; ?></td>
										<td><?php echo $row2['table_name']; ?></td>
										<td><?php echo $row['date']; ?></td>
										<td><?php echo $row['total']; ?></td>
										<td><?php if($row['status'] == '0'){
														echo "Pending";
												  }else if($row['status'] == 1){
														echo "Ready";
												  }else if($row['status'] == 2){
														echo "Serving";
												  }else if($row['status'] == '3'){
														echo "Delivered";
												  }
											?>
										</td>
										<td><?php echo $row['regtime']; ?></td>						 										  
                                    </tr>
								<?php
												}
											} else {
												echo "0 results";
											}
	}else{
		if($_POST['status_id'] == 4){
			$_POST['status_id'] = 0;
		}
    //Fetch all state data
		if($_SESSION['role_id'] == 0){
			$query = $conn->query("SELECT * FROM ordhead WHERE status = ".$_POST['status_id']." AND date = DATE(NOW()) ORDER BY regtime DESC");
		}else{
			$query = $conn->query("SELECT * FROM ordhead WHERE status = ".$_POST['status_id']." ORDER BY regtime DESC");
		}    
    //Count total number of rows
    $rowCount = $query->num_rows;
    $sql2 = "SELECT * FROM tables";
	$result2 = $conn->query($sql2);
	$row2 = $result2->fetch_assoc();
	
    //State option list
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){ 
            echo '<tr align="center" >';
			echo '<td>'.$row['order_id']. '</td>';
			echo '<td>'.$row2['table_name'].'</td>';
			echo '<td>'.$row['date'].'</td>';
			echo '<td>'.$row['total']. '</td>';
			echo '<td>';
			if($row['status'] == 0){
				echo "Pending";
			}else if($row['status'] == 1){
				echo "Ready";
			}else if($row['status'] == 2){
				echo "Serving";
			}else if($row['status'] == 3){
				echo "Delivered";
			}
			echo '</td>';
			echo '<td>'.$row['regtime']. '</td>	
                                    </tr>';
        }
    }else{
        echo '<option value="">No Oders</option>';
    }
}
}

if(!empty($_POST["waiter_id"])){
	?>
<meta http-equiv="refresh" content="3; URL=index.php?disp_id=vorders&waiterid=<?php echo $_POST['waiter_id']; ?>">
<?php
	if(isset($_GET['waiterid'])){
		$_POST['waiter_id'] = $_GET['waiterid'];
	}
	if($_POST['waiter_id'] == "-1"){
											$sql = "SELECT * FROM ordhead WHERE date = DATE(NOW()) ORDER BY regtime DESC";
											$result = $conn->query($sql);
											$sql2 = "SELECT * FROM tables";
											$result2 = $conn->query($sql2);
											$row2 = $result2->fetch_assoc();
											if ($result->num_rows > 0) {
												// output data of each row
												while($row = $result->fetch_assoc()) {									
								?>
                                    <tr align="center" >
										<td><?php echo $row['order_id']; ?></td>
										<td><?php echo $row2['table_name']; ?></td>
										<td><?php echo $row['date']; ?></td>
										<td><?php echo $row['total']; ?></td>
										<td><?php if($row['status'] == '0'){
														echo "Pending";
												  }else if($row['status'] == 1){
														echo "Ready";
												  }else if($row['status'] == 2){
														echo "Serving";
												  }else if($row['status'] == '3'){
														echo "Delivered";
												  }
											?>
										</td>
										<td><?php echo $row['regtime']; ?></td>						 										  
                                    </tr>
								<?php
												}
											} else {
												echo "0 results";
											}
	}else{
    //Fetch all state data
	$query = $conn->query("SELECT * FROM ordhead WHERE user_id = ".$_POST['waiter_id']." AND date = DATE(NOW()) ORDER BY regtime DESC");   
    //Count total number of rows
    $rowCount = $query->num_rows;
    $sql2 = "SELECT * FROM tables";
	$result2 = $conn->query($sql2);
	$row2 = $result2->fetch_assoc();
	
    //State option list
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){ 
            echo '<tr align="center" >';
			echo '<td>'.$row['order_id']. '</td>';
			echo '<td>'.$row2['table_name'].'</td>';
			echo '<td>'.$row['date'].'</td>';
			echo '<td>'.$row['total']. '</td>';
			echo '<td>';
			if($row['status'] == 0){
				echo "Pending";
			}else if($row['status'] == 1){
				echo "Ready";
			}else if($row['status'] == 2){
				echo "Serving";
			}else if($row['status'] == 3){
				echo "Delivered";
			}
			echo '</td>';
			echo '<td>'.$row['regtime']. '</td>	
                                    </tr>';
        }
    }else{
        echo '<option value="">No Oders</option>';
    }
}
}
?>