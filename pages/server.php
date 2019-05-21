<?php
	session_start();
	include 'dbconnect.php';

	//ASSIGN VARIABLES FROM FORM
	$username = $_POST['uname'];
	$password = $_POST['psw'];
	$type = $_POST['utype'];
	$name = $_POST['name'];
	$surname = $_POST['surn'];
	
	//ENCRYPT PASSWORD
	//$password = md5($password);
	
	$password = password_hash($password, PASSWORD_BCRYPT);
	
	//CHECK IF VALUES ARE OKAY
	
	//CHECK IF USER IS UNIQUE
	$sql = "SELECT username FROM users WHERE username = '$username'";
	if($result=mysqli_query($conn,$sql))
	{
		$rowcount = mysqli_num_rows($result);
	}
	
	if($rowcount >= 1)
	{
		echo "There is already an user with this username.";
	}
	else
	{
		//INSERT DATA INTO DATABASE
		$sql = "INSERT INTO users (username, password, role_id, name, surname)
		VALUES ('$username', '$password', '$type', '$name', '$surname')";
		
		//EXECUTE QUERY
		if($conn->query($sql) === TRUE)
		{
			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: ../index.php');
			echo "Account has been added successfully.";
			
			die();
		}
		else
		{
			echo "Error: ".$sql."<br/>".$conn->error;
		}
	}
?>