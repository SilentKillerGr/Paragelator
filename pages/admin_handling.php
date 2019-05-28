<?php
	session_start();
	include 'dbconnect.php';
	
	//ASSIGN VARIABLES FROM FORM
	$username = $_POST['uname'];
	$password = $_POST['psw'];
	
	//ENCRYPT PASSWORD
	//$password = md5($password);
	
	$query = "SELECT password, role_id, user_id FROM users WHERE username = '$username'";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	
	//USERDATA
	$dbPassword = $row['password'];
	
	if (password_verify($password, $dbPassword))
	{
		$_SESSION['loggedin'] = $username;
		$_SESSION['role_id'] = $row['role_id'];
		$_SESSION['user_id'] = $row['user_id'];
		$_SESSION['balance'] = $row['balance'];
		header("Location: ../index.php");
		die();
	}
	else
	{
		echo "Passwords do not match!";
	}
?>