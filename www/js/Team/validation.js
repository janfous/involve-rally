$(document).ready(function() 
{
	var selection = {};
	
	$('select').change(function(event) {
		var name = event.target.name;
		name = name.substring(0, name.length - 2);
	
		var max_name = name + "_max";
		var max_val = $("input[name=" + max_name + "]").val()
		
		if ($(this).val().length > max_val) {
			$(this).val(selection[name]);			
		} else {
			selection[name] = $(this).val();
		}	
	});
});