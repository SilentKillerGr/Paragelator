<?php
	function delete_categ(){
		include 'dbconnect.php';
		$pid = $_GET['prod'];
		$sql = "DELETE FROM `products` WHERE prod_id = '$pid'";

			//EXECUTE QUERY
			if($conn->query($sql) === TRUE)
			{
				$message = "Done";
				echo "<script type='text/javascript'>alert('$message');</script>";
				header('location: index.php?disp_id=prodmanage');
			}else{
				$message = "Wtf m8?";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
	}

	if(isset($_GET['prod'])){
		delete_categ();
	}
	
	if(isset($_POST['submit'])){
		include 'dbconnect.php';
		if(isset($_POST['pname'])){
			$pname = $_POST['pname'];
			$categ_id = $_POST['categ_id'];
			$price = $_POST['price'];
			$sql = "INSERT INTO products (prod_name, categ_id, price) VALUES ('$pname', '$categ_id', '$price')";
			//EXECUTE QUERY
			if($conn->query($sql) === TRUE)
			{
				header('location: index.php?disp_id=prodmanage');
			}else{
				$message = "Wtf m8?";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}
	}
?>
<div id="modal-wrapper" class="modal">
	<form role="form" method="post" class="modal-content animate" id="adds" action="index.php?disp_id=prodmanage">
	<div class="imgcontainer">

      <span onclick="document.getElementById('modal-wrapper').style.display='none'" class="close" title="Close PopUp">&times;</span>

      <h1 style="text-align:center">Add Category</h1>

    </div>
      	
		<input type="text" placeholder="Product Name" name="pname">
		<select name="categ_id">
			<?php
				$sql = "SELECT * FROM category ORDER BY categ_name ASC";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				// output data of each row
					while($row = $result->fetch_assoc()) {									
			?>
			<option value="<?php echo $row['categ_id']; ?>"><?php echo $row['categ_name']; ?></option>
			<?php
					}
				} else {
						echo "0 results";
				}
			?>
		</select>
		<input type="text" placeholder="Price" name="price">
		<button type="submit" name="submit" form="adds">Add</button>
	</form>
	
</div>
<div>
<a class="btn" onclick="document.getElementById('modal-wrapper').style.display='block'">New Product</a>
<table class="table table-condensed">
                                <thead>
                                    <tr>
										<th>#</th>
                                        <th>Product Name</th>
										<th>Category Name</th>
										<th>Price</th>
										<th>Action</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php
											$sql = "SELECT * FROM products ORDER BY prod_id ASC";
											$result = $conn->query($sql);

											if ($result->num_rows > 0) {
												// output data of each row
												while($row = $result->fetch_assoc()) {
												$cids = $row['categ_id'];
												$sql = "SELECT * FROM category WHERE categ_id = '$cids'";
												$ree = $conn->query($sql);
												$rowe = $ree->fetch_assoc()
								?>
                                    <tr align="center" >
										<td><?php echo $row['prod_id']; ?></td>
										<td><?php echo $row['prod_name']; ?></td>   
										<td><?php echo $rowe['categ_name']; ?></td>
										<td><?php echo $row['price']; ?></td>
										<td class="dropdown" align="center">									 
										  <a class="btn" href="index.php?disp_id=prodmanage&prod=<?php echo $row['prod_id']; ?>">Delete</a></td>
                                    </tr>
								<?php
												}
											} else {
												echo "0 results";
											}
								?>
									</tbody>
                            </table>
</div>