<?php
	include 'dbconnect.php';
	if(!isset($_SESSION['bal'])){
		$sql="SELECT * FROM cashreg WHERE id = '1'";
		$result = $conn->query($sql);
		$result2 = $result->fetch_assoc();
		$_SESSION['bal'] = $result2['cash'];
	}
	function shekel_user(){
		include 'dbconnect.php';
		$sql="SELECT * FROM users WHERE user_id = " .$_GET['retire'];
		$result = $conn->query($sql);
		$result2 = $result->fetch_assoc();
		$curr = $result2['balance'];
		$bala = $curr + $_SESSION['bal'];
		//Query for Mark update
		$sql="UPDATE cashreg SET cash = '$bala' WHERE id = '1'";
			if($conn->query($sql) === TRUE){
				$total = $conn->query("SELECT * FROM cashreg");
				$total2 = $total->fetch_assoc();
				$_SESSION['bal'] = $total2['cash'];
		}else{
			$message = "Wtf m8?";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
		$sql="UPDATE users SET balance = 0 WHERE user_id = " .$_GET['retire'];
			//EXECUTE QUERY
			if($conn->query($sql) === TRUE)
			{
				header('location: index.php?disp_id=vbalance');
			}else{
				$message = "Wtf m8?";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
	}

	if(isset($_GET['retire'])){
		shekel_user();
	}
	if(isset($_GET['action'])){
		flush_cash();
	}
	if(isset($_POST['addbal'])){
		$sql="SELECT * FROM users WHERE user_id = '24'";
		$result = $conn->query($sql);
		$result2 = $result->fetch_assoc();
		$curr = $result2['balance'];
		$new = $curr - $_POST['bal'];
		//Query for owner update
		$sql="UPDATE users SET balance = '$new' WHERE user_id = '24'";
			if($conn->query($sql) === TRUE){
		
		}else{
			$message = "Wtf m8?";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
		//Querry for Mark update
		$new2 = $_SESSION['bal'] + $_POST['bal'];
		$sql="UPDATE cashreg SET cash = '$new2' WHERE id = '1'";
		if($conn->query($sql) === TRUE){
			$_SESSION['bal'] = $new2;
		header('location: index.php?disp_id=vbalance');
		}else{
			$message = "Wtf m8?";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
	}
//Add waiter balance
if(isset($_GET['uid'])){
	if(isset($_POST[$_GET['uid']])){
		$bala = $_SESSION['bal'] - $_POST[$_GET['uid']];
		//Query for Mark update
		$sql="UPDATE cashreg SET cash = '$bala' WHERE id = '1'";
			if($conn->query($sql) === TRUE){
			$_SESSION['bal'] = $bala;
		}else{
			$message = "Wtf m8?";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
		//Querry for Waiter update
		$sql="SELECT * FROM users WHERE user_id = " .$_GET['uid'];
			$result = $conn->query($sql);
			$result2 = $result->fetch_assoc();
			$curr = $result2['balance'] + $_POST[$_GET['uid']];
		$sql="UPDATE users SET balance = '$curr' WHERE user_id = " .$_GET['uid'];
		if($conn->query($sql) === TRUE){
		header('location: index.php?disp_id=vbalance');
		}else{
			$message = "Wtf m8?";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
	}
}
	function flush_cash(){
			include 'dbconnect.php';
			$sql="SELECT * FROM users WHERE user_id = '24'";
			$result = $conn->query($sql);
			$result2 = $result->fetch_assoc();
			$curr = $result2['balance'];
			$new = $curr + $_SESSION['bal'];
			//Query for owner update
			$sql="UPDATE users SET balance = '$new' WHERE user_id = '24'";
				if($conn->query($sql) === TRUE){
					$conn->query("UPDATE cashreg SET cash = '0' WHERE id = '1'");
					$_SESSION['bal'] = 0;
			}else{
				$message = "Wtf m8?";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
				$sql="UPDATE users SET balance = 0 WHERE user_id =" .$_SESSION['user_id'];
				if($conn->query($sql) === TRUE){

			}else{
				$message = "Wtf m8?";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
	}
	if($_SESSION['role_id'] == 3){
		
?>
	<label>
	Current Balance In "PENDING" And "READY" Orders: 
		<?php
			$totalPen = 0;
			$sql="SELECT * FROM ordhead WHERE status = '0' OR status = '1'";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				while ($row = $result->fetch_assoc()){
					$totalPen = $totalPen + $row['total'];
				}
			}
			echo $totalPen;
		?>
	</label>
	<label>
	Current Balance In "SERVING" Orders: 
		<?php
			$totalSer = 0;
			$sql="SELECT * FROM ordhead WHERE status = '2'";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				while ($row = $result->fetch_assoc()){
					$totalSer = $totalSer + $row['total'];
				}
			}
			echo $totalSer;
		?>
	</label>
	<label>
	Current Balance In "DELIVERED" Orders: 
		<?php
			$totalDel = 0;
			$sql="SELECT * FROM ordhead WHERE status = '3'";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				while ($row = $result->fetch_assoc()){
					$totalDel = $totalDel + $row['total'];
				}
			}
			echo $totalDel;
		?>
	</label>
	<label>Current Business Balance: 
		<?php 
		echo $_SESSION['bal'];
		?>
	</label>
	<form method="post" id="addbal" action="index.php?disp_id=vbalance">
		<input type="number" name="bal" min="1" style="display: inline; width: 30%;"/>
		<button type="submit" form="addbal" name="addbal" style="display: inline; width: 20%;">Add</button>
		<a href="index.php?disp_id=vbalance&action=flush" class="btn bg-red">Flush Cash</a>
	</form>
<!-- Manage Users-->
	<table class="table table-condensed">
                                <thead>
                                    <tr>
										<th>#</th>
                                        <th>Username</th>
                                        <th>Name</th>
										<th>Surname</th>
										<th>Balance</th>
										<th>Add Balance</th>
										<th>Return</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php
											$sql = "SELECT * FROM users WHERE role_id = '1' ORDER BY user_id ASC";
											$result = $conn->query($sql);

											if ($result->num_rows > 0) {
												// output data of each row
												while($row = $result->fetch_assoc()) {
												$rolenu = $row['role_id'];
												if ($rolenu == 0){
													$rolena = 'Owner';
												}else if ($rolenu == 1){
													$rolena = 'Waiter';
												}else if ($rolenu == 2){
													$rolena = 'Kitchen';
												}else if ($rolenu == 3){
													$rolena = 'Mark';
												}else
								?>
                                    <tr align="center" >
										<td style="padding-top: 5%;"><?php echo $row['user_id']; ?></td>
										<td style="padding-top: 5%;"><?php echo $row['username']; ?></td>
                                        <td style="padding-top: 5%;"><?php echo $row['name']; ?></td>
                                        <td style="padding-top: 5%;"><?php echo mb_strimwidth($row['surname'], 0, 50, "..."); ?></td>
										<td style="padding-top: 5%;"><?php echo mb_strimwidth($row['balance'], 0, 50, "..."); ?></td>
										<td>
											<form method="post" id="<?php echo $row['user_id']; ?>" action="index.php?disp_id=vbalance&uid=<?php echo $row['user_id']; ?>">
											  <input type="number" name="<?php echo $row['user_id']; ?>" style="display: inline; width: 30%;"/>
											  <button type="submit" name="addwbal" form="<?php echo $row['user_id']; ?>" style="display: inline; width: 30%; height: auto;">Add</button>
											</form>
										</div></td>
										<td style="padding-top: 5%;"><a href="index.php?disp_id=vbalance&retire=<?php echo $row['user_id']; ?>">Return</a></td>
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
	}else if ($_SESSION['role_id'] == 1){
?>
<label>
	Current Balance In "PENDING" And "READY" Orders: 
		<?php
			$totalPen = 0;
			$sql="SELECT * FROM ordhead WHERE status = '0' OR status = '1' AND user_id = ".$_SESSION['user_id']."";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				while ($row = $result->fetch_assoc()){
					$totalPen = $totalPen + $row['total'];
				}
			}
			echo $totalPen;
		?>
	</label>
	<label>
	Current Balance In "SERVING" Orders: 
		<?php
			$totalSer = 0;
			$sql="SELECT * FROM ordhead WHERE status = '2' AND user_id = ".$_SESSION['user_id']."";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				while ($row = $result->fetch_assoc()){
					$totalSer = $totalSer + $row['total'];
				}
			}
			echo $totalSer;
		?>
	</label>
	<label>
	Current Balance In "DELIVERED" Orders: 
		<?php
			$totalDel = 0;
			$sql="SELECT * FROM ordhead WHERE status = '3' AND user_id = ".$_SESSION['user_id']."";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				while ($row = $result->fetch_assoc()){
					$totalDel = $totalDel + $row['total'];
				}
			}
			echo $totalDel;
		?>
	</label>
	<label>
	My Balance: 
		<?php
			$totalDel = 0;
			$sql = "SELECT * FROM users WHERE user_id = ".$_SESSION['user_id']." ORDER BY user_id ASC";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			echo $row['balance'];
		?>
	</label>
<?php
	}
?>