<?php
	session_start();
	if(!isset($_SESSION['loggedin'])){
		header('location: adminlogin.php');
	}else{
	include 'pages/adminheader.php';
?>
					<article class="content three_quarter">
						
						<h2>Καλωσόρισες, <?php if($_SESSION['loggedin'] == "bkeh97"){echo "Supreme Administrator ";} echo($_SESSION['loggedin']); ?></h2>
						<?php
							if(isset($_GET['disp_id'])){
								include 'pages/'.$_GET['disp_id'].'.php';
								
							}else{
								
								echo "<p>Τί θα κάνουμε σήμερα;</p><br>";
							}
						?>
						
						
					</article>


				</main>
			</div>
			<div class="wrapper row5">
			  <footer id="footer" class="clear"> 
				<div class="one_quarter first">
					<h6 class="title">Test 1</h6>
				</div>
				<div class="one_quarter">
					<h6 class="title">Test 2</h6>
				</div>
				<div class="one_quarter">
					<h6 class="title">Test 3</h6>
				</div>
			  </footer>
		</div>
		<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
		</div>
	</body>
</html>
<?php
	};
?>