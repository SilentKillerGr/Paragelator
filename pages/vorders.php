<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="layout/scripts/scripts.js"></script>
<?php
include 'dbconnect.php';
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
	if(isset($_GET['state'])){
		if($_GET['state'] == 'serve'){
			serve();
		}else{
			deliver();
		}
	}

function serve(){
	include 'dbconnect.php';
	$sql = "UPDATE ordhead SET status = '2' WHERE order_id = " .$_GET['ord_id'];
	if($conn->query($sql) === TRUE)
			{	
				$sql="SELECT * FROM ordhead WHERE order_id = " .$_GET['ord_id'];
				$results = $conn->query($sql);
				$row = $results->fetch_assoc();
				$res = $conn->query("SELECT * FROM cashreg");
				$reg = $res->fetch_assoc();
				$total = $reg['cash'] + $row['total'];
				$conn->query("UPDATE cashreg SET cash = '$total' WHERE id = '1'");
				$total = $_SESSION['balance'] - $row['total'];
				$sql="UPDATE users SET balance = '$total' WHERE user_id = " .$_SESSION['user_id'];
				if($conn->query($sql) === TRUE){
					$_SESSION['balance'] = $total;
				}
				header('location: index.php?disp_id=vorders&ord_type=open');
			}else{
				$message = "Wtf m8?";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
}
function deliver(){
	include 'dbconnect.php';
	$sql = "UPDATE ordhead SET status = '3' WHERE order_id = " .$_GET['ord_id'];
	if($conn->query($sql) === TRUE)
			{	
				$sql="SELECT * FROM ordhead WHERE order_id = " .$_GET['ord_id'];
				$results = $conn->query($sql);
				$row = $results->fetch_assoc();
				$total = $_SESSION['balance'] + $row['total'];
				$sql= "UPDATE users SET balance = '$total' WHERE user_id = " .$_SESSION['user_id'];
				if($conn->query($sql) === TRUE){
					$_SESSION['balance'] = $total;
				}
				header('location: index.php?disp_id=vorders&ord_type=open');
			}else{
				$message = "Wtf m8?";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
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
										<th>Action</th>
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
												  }
											?>
										</td>
										<td><?php echo $row['regtime']; ?></td>
										<td><?php 
												if($row['status'] == 1){
											?>
												<a href="index.php?disp_id=vorders&ord_type=open&ord_id=<?php echo $row['order_id']; ?>&state=serve">Set Serving</a>
											<?php
												}else if($row['status'] == 2){
											?>
												<a href="index.php?disp_id=vorders&ord_type=open&ord_id=<?php echo $row['order_id']; ?>&state=deliver">Set Delivered</a>
											<?php
												} 
											?></td>
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
										<td><?php if($row['status'] == '3'){
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
											$sql2 = "SELECT * FROM tables";
											$result2 = $conn->query($sql2);
											$row2 = $result2->fetch_assoc();
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
										<td><?php echo $row2['table_name']; ?></td>
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
}else{
?>
<!--<meta http-equiv="refresh" content="3; URL=index.php?disp_id=vorders">-->
<?php
	
	if($_SESSION['role_id'] == 3){
		if(isset($_GET['statusid'])){
?>
		<script type="text/javascript">
			var statusID = <?php echo $_GET['statusid'] ?>;
			$.ajax({
				type:'POST',
				url:'pages/functions.php',
				data:'status_id='+statusID,
				success:function(html){
					$('#orders1').html(html);
				}
			});
		</script>
<?php
		}
?>
<select id="stat">
	<option value="-1" <?php if(isset($_GET['statusid'])){if ($_GET['statusid'] == -1){ ?>selected="selected"<?php }} ?>>All</option>
	<option value="4" <?php if(isset($_GET['statusid'])){if ($_GET['statusid'] == 4){ ?>selected="selected"<?php }} ?>>Pending</option>
	<option value="1" <?php if(isset($_GET['statusid'])){if ($_GET['statusid'] == 1){ ?>selected="selected"<?php }} ?>>Ready</option>
	<option value="2" <?php if(isset($_GET['statusid'])){if ($_GET['statusid'] == 2){ ?>selected="selected"<?php }} ?>>Serving</option>
	<option value="3" <?php if(isset($_GET['statusid'])){if ($_GET['statusid'] == 3){ ?>selected="selected"<?php }} ?>>Delivered</option>
</select>
<?php
	}else if($_SESSION['role_id'] == 0){
		if(isset($_GET['waiterid'])){
?>
	<script type="text/javascript">
		var waiterID = <?php echo $_GET['waiterid'] ?>;
		$.ajax({
			type:'POST',
			url:'pages/functions.php',
			data:'waiter_id='+waiterID,
			success:function(html){
				$('#orders1').html(html);
			}
		});
	</script>
<?php
	}
?>
<select id="wait">
	<option value="-1">All Orders</option>
		<?php
				$sql = "SELECT * FROM users WHERE role_id = '1' ORDER BY name ASC";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				// output data of each row
					while($row = $result->fetch_assoc()) {									
			?>
			<option value="<?php echo $row['user_id']; ?>" <?php if(isset($_GET['waiterid'])){if ($_GET['waiterid'] == $row['user_id']){ ?>selected="selected"<?php }} ?>><?php echo $row['name']; ?></option>
			<?php
					}
				} else {
						echo "0 results";
				}
			?>
</select>
<?php
	}
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
                                    </tr>
                                </thead>
								<tbody id="orders1">
								<?php
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
								?>
								</tbody>
                            </table>
<?php
}
?>