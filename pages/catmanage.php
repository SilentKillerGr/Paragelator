<?php
	
	function delete_categ(){
		include 'dbconnect.php';
		$cid = $_GET['categ'];
		$sql = "DELETE FROM `category` WHERE categ_id = '$cid'";

			//EXECUTE QUERY
			if($conn->query($sql) === TRUE)
			{
				$message = "Done";
				echo "<script type='text/javascript'>alert('$message');</script>";
				header('location: index.php?disp_id=catmanage');
			}else{
				$message = "Wtf m8?";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
	}

	if(isset($_GET['categ'])){
		delete_categ();
	}
	
	if(isset($_POST['submit'])){
		include 'dbconnect.php';
		if(isset($_POST['cname'])){
			$cname = $_POST['cname'];
			$sql = "INSERT INTO category (categ_name) VALUES ('$cname')";
			//EXECUTE QUERY
			if($conn->query($sql) === TRUE)
			{
				header('location: index.php?disp_id=catmanage');
			}else{
				$message = "Wtf m8?";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}
	}
?>
<div>
	<form role="form" method="post" id="adds" action="index.php?disp_id=catmanage">
      <h1 style="text-align:center">Add Category</h1>
		<input type="text" placeholder="Category Name" name="cname">
	</form>
	<button type="submit" name="submit" form="adds">Add</button>
</div>
<table class="table table-condensed">
                                <thead>
                                    <tr>
										<th>#</th>
                                        <th>Category Name</th>
										<th>Action</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php
											$sql = "SELECT * FROM category ORDER BY categ_id ASC";
											$result = $conn->query($sql);

											if ($result->num_rows > 0) {
												// output data of each row
												while($row = $result->fetch_assoc()) {									
								?>
                                    <tr align="center" >
										<td><?php echo $row['categ_id']; ?></td>
										<td><?php echo $row['categ_name']; ?></td>                                    
										<td class="dropdown" align="center">									 
										  <a class="btn" href="index.php?disp_id=catmanage&categ=<?php echo $row['categ_id']; ?>">Delete</a></td>
                                    </tr>
								<?php
												}
											} else {
												echo "0 results";
											}
								?>
									</tbody>
                            </table>