<?php

?>
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
                                    <tr>
										<td><input type="checkbox" name="<?php echo $row['user_id']; ?>" id="basic_checkbox_1" />
                                		<label for="basic_checkbox_1"><?php echo $row['user_id']; ?></label></td>
										<td><?php echo $row['username']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo mb_strimwidth($row['surname'], 0, 50, "..."); ?></td>
                                        <td><?php echo mb_strimwidth($rolena, 0, 50, "..."); ?></td>
										<td><?php echo mb_strimwidth($row['balance'], 0, 50, "..."); ?></td>
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