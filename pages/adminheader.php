<?php 
	include 'dbconnect.php';
	$usrname = $_SESSION['loggedin'];
	function logout(){
		session_destroy();
		header("Location: index.php");
		exit();
	}
	if (isset($_GET['logout'])){
		logout();
	}
?>
<!-- Modals for actions -->
	<!-- Insert Product -->
	<div id="modal-wrapper" class="modal">
		<form role="form" method="post" class="modal-content animate" action="pages/server.php">

        

    <div class="imgcontainer">

      <span onclick="document.getElementById('modal-wrapper').style.display='none'" class="close" title="Close PopUp">&times;</span>

      <h1 style="text-align:center">Εγγραφή Νέου Χρήστη</h1>

    </div>
	  	<input type="text" placeholder="Όνομα Χρήστη" name="uname" required>
		<input type="password" placeholder="Κωδικός Πρόσβασης" name="psw" required>
		<input type="text" placeholder="Όνομα" name="name" required>
		<input type="text" placeholder="Επώνυμο" name="surn" required>
		<input type="radio" id="radios" name="utype" value="1" checked>Σερβος
      	<input type="radio" id="radios" name="utype" value="2">Αυγος
		<input type="radio" id="radios" name="utype" value="3">Πεκερ 
		<button type="submit">Εγγραφή</button>
  </form>
	</div>
	<script>
	var modal = document.getElementById('modal-wrapper');
	var modals = document.getElementById('modal-wrapper-s');
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}

	window.onclick = function(event) {
		if (event.target == modals) {
			modals.style.display = "none";
		}
	}
	</script>
<html>
	<head>
		<title>Paragelator Admin</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
		<link href="layout/styles/login.css" rel="stylesheet">
		<script> var __adobewebfontsappname__="dreamweaver" </script>
		<style>
			.prods{
				
				box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
				list-style-type:none;
				margin-left: 30%;
				border-radius: 25px;
				background: white;
				border: 2px solid black;
				padding: 20px; 
    			width: 700px;
    			height: auto;
				overflow:hidden;
				white-space:nowrap; 
  				text-overflow:ellipsis;
			}
		</style>
	</head>
	<body id="top">
		<div class="row100 bgded">
			<header id="header" class="clear">
				<div id="logo" class="fl_left">
				<h1><a href="index.php">Paragelator Admin</a></h1>
			  </div>
				<nav id="mainav" class="fl_right">
					<li class="active"><a href="index.php">Αρχικη</a></li>
				</nav>
			</header>
			<div class="wrapper row3">
						<main class="container clear"> 
							<div class="sidebar one_quarter first"> 
								<nav class="sdb_holder">
									<ul>
										<?php
											if($_SESSION['role_id'] == 0){
										?>
										<li><a href="index.php?disp_id=umanage">Manage Personel</a></li>
										<li><a href="index.php?disp_id=catmanage">Manage Product Categories</a></li>
										<li><a href="index.php?disp_id=prodmanage">Manage Catalogue</a></li>
										<li><a href="index.php?disp_id=vorders">View Orders</a></li>
										<?php
											}else if($_SESSION['role_id'] == 1){
										?>
										<li><a href="index.php?disp_id=neworder">New Order</a></li>
										<li><a href="#">View Orders</a>
										<ul>
											<li><a href="index.php?disp_id=vorders&ord_type=open">Open Orders</a></li>
											<li><a href="index.php?disp_id=vorders&ord_type=closed">Closed Orders</a></li>
										</ul>
										</li>
										<li><a href="index.php?disp_id=vbalance&user_id=<?php echo $_SESSION['user_id']; ?>">View Personal Balance</a></li>
										<?php
											}else if($_SESSION['role_id'] == 2){
										?>
										<li><a href="index.php?disp_id=vorders&ord_type=pending">View Orders</a></li>
										
										<?php
											}else if($_SESSION['role_id'] == 3){
										?>
										<li><a href="index.php?disp_id=vorders">View Orders</a></li>
										<li><a href="index.php?disp_id=vbalance">View Balance</a></li>
										<?php
											}else{
										?>
										<li><a onclick="document.getElementById('modal-wrapper').style.display='block'">Εισαγωγή Προϊόντος</a></li>
										<li><a href="productlists.php">Επεξεργασία Προϊόντων</a></li>
										<?php
											}
										?>
										<li><a href="index.php?logout">Logout</a></li>
									</ul>
								</nav>
								</div>