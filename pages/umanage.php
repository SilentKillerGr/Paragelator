<?php
	
	function delete_user(){
		include 'dbconnect.php';
		$uid = $_GET['user'];
		$sql = "DELETE FROM `users` WHERE user_id = '$uid'";

			//EXECUTE QUERY
			if($conn->query($sql) === TRUE)
			{
				$message = "Done";
				echo "<script type='text/javascript'>alert('$message');</script>";
				header('location: index.php?disp_id=umanage');
			}else{
				$message = "Wtf m8?";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
	}

	if(isset($_GET['user'])){
		delete_user();
	}
?>
<!-- Modals for actions -->
	<!-- Insert User -->
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
<div>
	<table class="table table-condensed">
                                <thead>
                                    <tr>
										<th>#</th>
                                        <th>Username</th>
                                        <th>Name</th>
										<th>Surname</th>
                                        <th>Role</th>
										<th>Balance</th>
										<th>Actions</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php
											$sql = "SELECT * FROM users ORDER BY user_id ASC";
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
										<td><?php echo $row['user_id']; ?></td>
										<td><?php echo $row['username']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo mb_strimwidth($row['surname'], 0, 50, "..."); ?></td>
                                        <td><?php echo mb_strimwidth($rolena, 0, 50, "..."); ?></td>
										<td><?php echo mb_strimwidth($row['balance'], 0, 50, "..."); ?></td>
										<td class="dropdown" align="center">
										  <button class="dropbtn">Action</button>
										  <div class="dropdown-content">
										  <a href="index.php?disp_id=umanage&user=<?php echo $row['user_id']; ?>">Delete User</a>
										  <a href="index.php?disp_id=edituser&user=<?php echo $row['user_id']; ?>">Edit User</a>
										</div></td>
                                    </tr>
								<?php
												}
											} else {
												echo "0 results";
											}
								?>
									</tbody>
                            </table>
							<a class="btn" onclick="document.getElementById('modal-wrapper').style.display='block'">New User</a>
</div>