// JavaScript Document
$(document).ready(function(){
		$('#sectors').on('change',function(){
			var sectorID = $(this).val();
			if(sectorID){
				$.ajax({
					type:'POST',
					url:'pages/functions.php',
					data:'sector_id='+sectorID,
					success:function(html){
						$('#tables').html(html);
					}
				}); 
			}else{
				$('#tables').html('<option value="">Select Sector First</option>'); 
			}
		});
	});

$(document).ready(function(){
		$('#stat').on('change',function(){
			var statusID = $(this).val();
			if(statusID){
				$.ajax({
					type:'POST',
					url:'pages/functions.php',
					data:'status_id='+statusID,
					success:function(html){
						$('#orders1').html(html);
					}
				}); 
			}else{
				$('#orders1').html('<tr align="center"><td>None</td></tr>'); 
			}
		});
	});

$(document).ready(function(){
		$('#wait').on('change',function(){
			var waiterID = $(this).val();
			if(waiterID){
				$.ajax({
					type:'POST',
					url:'pages/functions.php',
					data:'waiter_id='+waiterID,
					success:function(html){
						$('#orders1').html(html);
					}
				}); 
			}else{
				$('#orders1').html('<tr align="center"><td>None</td></tr>'); 
			}
		});
	});