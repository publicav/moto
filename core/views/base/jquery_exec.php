	$(document).on('click', 'a#add_value', function(e) {
		var param = '';	
		e.preventDefault();	
		if (Object.keys(cmd_arr).length != 0) {
			param = create_cmd('',cmd_arr);
			console.log('cmd_arr = ',cmd_arr);
			console.log('param = ',param);

		}	
		// console.log('cmd_arr = ',cmd_arr);		
		$.colorbox( { 
					href:$(this).attr('href') + param,
					width:"900px",
					height:"90%",
					iframe:true
		});
	});
