$(document).ready(function() 
{
	var grey = false;
	
	var color_grey = "#f0f0f0"
	
	var last_id = -1;
	
	$("tr.row").each(function() {
		var id = $(this).find("td.row_id").html()
		
		if (last_id !== id) {			
			grey = !grey;
			last_id = id;
		} 
		
		if (grey) {
			$(this).css("background-color", color_grey);
		}
	})
});