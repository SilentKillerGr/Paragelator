<!--Modal For Edit User-->
<?php
	if(isset($_POST['submit'])){
		include 'dbconnect.php';
		$uid = $_GET['user'];
		if(isset($_POST['uname'])){
			$uname = $_POST['uname'];
			$sql = "UPDATE `users` SET username = '$uname' WHERE user_id = '$uid'";
			//EXECUTE QUERY
			if($conn->query($sql) === TRUE)
			{
				header('location: index.php?disp_id=umanage');
			}else{
				$message = "Wtf m8?";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}
		if(isset($_POST['name'])){
			$name = $_POST['name'];
			$sql = "UPDATE `users` SET name = '$name' WHERE user_id = '$uid'";
			//EXECUTE QUERY
			if($conn->query($sql) === TRUE)
			{
				header('location: index.php?disp_id=umanage');
			}else{
				$message = "Wtf m8?";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}
		if(isset($_POST['surn'])){
			$surname = $_POST['surn'];
			$sql = "UPDATE `users` SET surname = '$surname' WHERE user_id = '$uid'";
			//EXECUTE QUERY
			if($conn->query($sql) === TRUE)
			{
				header('location: index.php?disp_id=umanage');
			}else{
				$message = "Wtf m8?";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}
		if(isset($_POST['utype'])){
			$utype = $_POST['utype'];
			$sql = "UPDATE `users` SET role_id = '$utype' WHERE user_id = '$uid'";
			//EXECUTE QUERY
			if($conn->query($sql) === TRUE)
			{
				header('location: index.php?disp_id=umanage');
			}else{
				$message = "Wtf m8?";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}
	}
?>
<?php
		$uid = $_GET['user'];
		$sql = "SELECT * FROM users WHERE user_id = '$uid' ";
		$result = $conn->query($sql);	
		$row = $result->fetch_assoc();
		$r1 = "";
		$r2 = "";
		$r3 = "";
		if ($row['role_id'] == 1){
			$r1 = "checked";
		}else if($row['role_id'] == 2){
			$r2 = "checked";
		}else if($row['role_id'] == 3){
			$r3 = "checked";
		}
		
	?>
<div>
	<form role="form" method="post" id="edits" action="index.php?disp_id=edituser&user=<?php echo $uid; ?>">


      <h1 style="text-align:center">Edit User</h1>
	
		<input type="text" placeholder="<?php echo $row['username']; ?>" name="uname">
		<input type="text" placeholder="<?php echo $row['name']; ?>" name="name">
		<input type="text" placeholder="<?php echo $row['surname']; ?>" name="surn">
		<input type="radio" id="radios" name="utype" value="1" <?php echo $r1; ?>>Σερβος
      	<input type="radio" id="radios" name="utype" value="2" <?php echo $r2; ?>>Αυγος
		<input type="radio" id="radios" name="utype" value="3" <?php echo $r3; ?>>Πεκερ 
  </form>
	<button type="submit" name="submit" form="edits">Εγγραφή</button>
	</div>