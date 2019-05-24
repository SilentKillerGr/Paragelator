<?php
if(!isset($_SESSION['num'])){
	$_SESSION['num'] = 0;
}
function change_state(){
		include 'dbconnect.php';
		$oid = $_GET['order'];
		$sql = "UPDATE ordhead SET status = '1' WHERE order_id = '$oid'";

			//EXECUTE QUERY
			if($conn->query($sql) === TRUE)
			{
				$message = "Done";
				echo "<script type='text/javascript'>alert('$message');</script>";
				header('location: index.php?disp_id=vorders&ord_type=pending');
			}else{
				$message = "Wtf m8?";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
	}

	if(isset($_GET['order'])){
		change_state();
	}
if($_SESSION['role_id'] == 1){
	if($_GET['ord_type'] == 'open'){
		
?>
<table class="table table-condensed">
                                <thead>
                                    <tr>
										<th>#</th>
                                        <th>Table Name</th>
										<th>Date</th>
										<th>Total</th>
										<th>Status</th>
										<th>Register Time</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php
											$sql = "SELECT * FROM ordhead WHERE user_id = " .$_SESSION['user_id']. " AND status = '1'";
											$result = $conn->query($sql);
											if($_SESSION['num'] == 0){
												$_SESSION['num'] = $result->num_rows;
											}else if($result->num_rows > $_SESSION['num']){
												echo $_SESSION['num'];
								?>
									<audio id="soundHandle" style="display: none;"></audio>
									<script>
									  soundHandle = document.getElementById('soundHandle');
									  soundHandle.src = 'assets/wryyy.mp3';
									  soundHandle.play();
									</script>
								<?php
												$_SESSION['num'] = $result->num_rows;
											}else if($result->num_rows < $_SESSION['num']){
												$_SESSION['num'] = $result->num_rows;
											}
											$sql = "SELECT * FROM ordhead WHERE user_id = " .$_SESSION['user_id']. " AND status != '3' ORDER BY regtime DESC";
											$result = $conn->query($sql);
											if ($result->num_rows > 0) {
												// output data of each row
												while($row = $result->fetch_assoc()) {									
								?>
                                    <tr align="center" >
										<td><?php echo $row['order_id']; ?></td>
										<td><?php echo $row['table_id']; ?></td>
										<td><?php echo $row['date']; ?></td>
										<td><?php echo $row['total']; ?></td>
										<td><?php if($row['status'] == '0'){
														echo "Pending";
												  }else if($row['status'] == 1){
														echo "Ready";
												  }else if($row['status'] == 2){
														echo "Serving";
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
								?>
									</tbody>
                            </table>
<?php
	}else if($_GET['ord_type'] == 'closed'){
?>
<table class="table table-condensed">
                                <thead>
                                    <tr>
										<th>#</th>
                                        <th>Table Name</th>
										<th>Date</th>
										<th>Total</th>
										<th>Status</th>
										<th>Register Time</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php
											$sql = "SELECT * FROM ordhead WHERE user_id = " .$_SESSION['user_id']. " AND status = '3' ORDER BY regtime DESC";
											$result = $conn->query($sql);

											if ($result->num_rows > 0) {
												// output data of each row
												while($row = $result->fetch_assoc()) {									
								?>
                                    <tr align="center" >
										<td><?php echo $row['order_id']; ?></td>
										<td><?php echo $row['table_id']; ?></td>
										<td><?php echo $row['date']; ?></td>
										<td><?php echo $row['total']; ?></td>
										<td><?php if($row['status'] == '0'){
														echo "Pending";
												  }else if($row['status'] == 1){
														echo "Ready";
												  }else if($row['status'] == 2){
														echo "Serving";
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
								?>
									</tbody>
                            </table>

<?php
	}
}else if($_SESSION['role_id'] == 2 && $_GET['ord_type'] == 'pending'){
	?>
	<table id="orders" class="table table-condensed">
                                <thead>
                                    <tr>
										<th>#</th>
                                        <th>Table Name</th>
										<th>Date</th>
										<th>Total</th>
										<th>Status</th>
										<th>Register Time</th>
										<th>Action</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php
											$sql = "SELECT * FROM ordhead WHERE status = '0' ORDER BY regtime DESC";
											$result = $conn->query($sql);
											
											if($_SESSION['num'] == 0){
												$_SESSION['num'] = $result->num_rows;
											}else if($result->num_rows > $_SESSION['num']){
								?>
									<audio id="soundHandle" style="display: none;"></audio>
									<script>
									  soundHandle = document.getElementById('soundHandle');
									  soundHandle.src = 'assets/wryyy.mp3';
									  soundHandle.play();
									</script>
								<?php
												$_SESSION['num'] = $result->num_rows;
											}else if($result->num_rows < $_SESSION['num']){
												$_SESSION['num'] = $result->num_rows;
											}
											if ($result->num_rows > 0) {
												// output data of each row
												while($row = $result->fetch_assoc()) {									
								?>
                                    <tr align="center" >
										<td><?php echo $row['order_id']; ?></td>
										<td><?php echo $row['table_id']; ?></td>
										<td><?php echo $row['date']; ?></td>
										<td><?php echo $row['total']; ?></td>
										<td><?php if($row['status'] == '0'){
														echo "Pending";
												  }else if($row['status'] == 1){
														echo "Ready";
												  }else if($row['status'] == 2){
														echo "Serving";
												  }
											?>
										</td>
										<td><?php echo $row['regtime']; ?></td>	
										<td><a href="index.php?disp_id=vorders&order=<?php echo $row['order_id']; ?>">Ready</a></td>
                                    </tr>
								<?php
												}
											} else {
												echo "0 results";
											}
								?>
									</tbody>
                            </table>
<?php
}
?>