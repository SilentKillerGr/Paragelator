<thead>
                                    <tr>
										<th>#</th>
                                        <th>Table Name</th>
										<th>Date</th>
										<th>Total</th>
										<th>Status</th>
										<th>Register Time</th>
										<th>Action</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php
											$sql = "SELECT * FROM ordhead WHERE status = '0' ORDER BY regtime DESC";
											$result = $conn->query($sql);

											if ($result->num_rows > 0) {
												// output data of each row
												while($row = $result->fetch_assoc()) {									
								?>
                                    <tr align="center" >
										<td><?php echo $row['order_id']; ?></td>
										<td><?php echo $row['table_id']; ?></td>
										<td><?php echo $row['date']; ?></td>
										<td><?php echo $row['total']; ?></td>
										<td><?php if($row['status'] == '0'){
														echo "Pending";
												  }else if($row['status'] == 1){
														echo "Ready";
												  }else if($row['status'] == 2){
														echo "Serving";
												  }
											?>
										</td>
										<td><?php echo $row['regtime']; ?></td>	
										<td><a href="index.php?disp_id=vorders&order=<?php echo $row['order_id']; ?>">Ready</a></td>
                                    </tr>
								<?php
												}
											} else {
												echo "0 results";
											}
								?>
									</tbody>