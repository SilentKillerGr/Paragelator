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
