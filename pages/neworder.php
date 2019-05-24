<?php
if(!isset($_SESSION['ordno'])){
	$_SESSION['ordno'] = rand(000001, 100000);
}
echo "Current Order Number: " .$_SESSION['ordno'];

if(isset($_POST['add'])){
		include 'dbconnect.php';
	
			$ordno = $_SESSION['ordno'];
			$prod = $_POST['products'];
			$quant = $_POST['quantity'];
			$comm = $_POST['comm'];
			$sql = "SELECT * FROM products WHERE prod_id = '$prod'";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			$price = $quant * $row['price'];
			$sql = "INSERT INTO orddetails (order_id, prod_id, units, price, comment) VALUES ('$ordno', '$prod', '$quant', '$price', '$comm')";
			//EXECUTE QUERY
			if($conn->query($sql) === TRUE)
			{
				header('location: index.php?disp_id=neworder');
			}else{
				$message = "Wtf m8?";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
	}

if(isset($_POST['addord'])){
	$tblid = $_POST['tables'];
	$total = 0;
	$sql = "SELECT * FROM orddetails WHERE order_id = ".$_SESSION['ordno'];
	$result = $conn->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$total = $total + $row['price'];
		}
	}
	$sql = "INSERT INTO ordhead (order_id, table_id, date, user_id, total, status, regtime) VALUES (".$_SESSION['ordno'].", '$tblid', CURRENT_TIMESTAMP(), ".$_SESSION['user_id'].", '$total' , '0', CURRENT_TIMESTAMP())";
	if($conn->query($sql) === TRUE){
		$_SESSION['ordno'] = NULL;
		header('location: index.php?disp_id=neworder');
	}else{
		$message = "Wtf m8?";
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="layout/scripts/scripts.js"></script>
<div>
	
	<form role="form" method="post" id="addord" action="index.php?disp_id=neworder">
      <h1 style="text-align:center">Select Table</h1>
		<select id="sectors" name="sectors" style="width: 40%; display: inline;">
		<option selected="" disabled="">Select Sector</option>
		<?php
				$sql = "SELECT * FROM sectors ORDER BY sect_name ASC";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				// output data of each row
					while($row = $result->fetch_assoc()) {									
			?>
			<option value="<?php echo $row['sect_id']; ?>"><?php echo $row['sect_name']; ?></option>
			<?php
					}
				} else {
						echo "0 results";
				}
			?>
		</select>
		<select id="tables" name="tables" style="width: 40%; display: inline;">
		 <option selected="" disabled="">Select Table</option> 	
		</select>
		</form><br><br>
		<h2 align="center">Select Items</h2>
		<form role="form" method="post" id="addp" action="index.php?disp_id=neworder">
			<select id="products" name="products">
												<?php
												$sql = "SELECT * FROM products ORDER BY categ_id ASC";
												$result = $conn->query($sql);
												if ($result->num_rows > 0) {
												// output data of each row
													while($row = $result->fetch_assoc()) {									
												?>
												<option value="<?php echo $row['prod_id']; ?>"><?php echo $row['prod_name']; ?></option>
												<?php
														}
													} else {
															echo "0 results";
													}
												?></select>
			<label style="display: inline;">Quantity: </label><input type="number" name="quantity" id="quantity" min="1" style="width: 10%;">
			<label style="display: inline;">Comments: </label><input type="text" name="comm" id="comm" style="width: 50%;"><br><br>
			<button type="submit" name="add" form="addp">Add</button>
		</form>
		
		<h1 style="text-align:center">Current Items</h1>
		<table class="table table-condensed" name="details" id="displ">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
										<th>Price</th>
										<th>Comment</th>
                                    </tr>
                                </thead>
								<tbody>
									<?php
									$sql = "SELECT * FROM orddetails WHERE order_id =" .$_SESSION['ordno'];
												$result = $conn->query($sql);
												if ($result->num_rows > 0) {
												// output data of each row
													while($row = $result->fetch_assoc()) {
														$sql = "SELECT * FROM products WHERE prod_id =" .$row['prod_id'];
														$result2 = $conn->query($sql);
														$row2 = $result2->fetch_assoc();
												?>
                                    <tr align="center" >
										
												
												<td><?php echo $row2['prod_name']; ?></td>
												<td><?php echo $row['units']; ?></td>
												<td><?php echo $row['price']; ?></td>
												<td><?php echo $row['comment']; ?></td>
												
                                    </tr>
									<?php
														}
													} else {
															echo "0 results";
													}
												?>
									</tbody>
                            </table>
	<button type="submit" name="addord" form="addord">Finalize Order</button>
</div>