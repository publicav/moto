$(function() {
//	var cmd_arr	= {};
//	cmd_arr = getUrlVars();
	var base_link = BASENAME;	
	var objFiltred = {
		objSubstation: $('#substation'),
		objCounter: $('#counter'),
        url_substation: 'ajax/subst_filter/',
		url_counter: 'ajax/counter_filter/'
	};	
	
	json_get_t_calc($('#right'), cmd_arr);
	$.datepicker.setDefaults(
		$.extend($.datepicker.regional["ru"])
	);
	
	// Востанавливаем значения фильтров если была перезагрузка страницы через F5 или обновить
	if (('id_lot' in cmd_arr) && ('id_sub' in cmd_arr) && ('id_counter' in cmd_arr))	{
		   $('#lot [value="' + cmd_arr.id_lot + '"]').prop("selected", true);
		   get_substation(objFiltred, cmd_arr.id_lot, EDIT_ACTIONS, cmd_arr.id_sub, cmd_arr.id_counter);
		   
	} else {
		if (('id_lot' in cmd_arr) && ('id_sub' in cmd_arr))	{
			   $('#lot [value="' + cmd_arr.id_lot + '"]').prop("selected", true);
			   get_substation(objFiltred, cmd_arr.id_lot, EDIT_ACTIONS, cmd_arr.id_sub);
		} else {
			if ('id_lot' in cmd_arr)	{
				 $('#lot [value="' + cmd_arr.id_lot + '"]').prop("selected", true);
				 get_substation(objFiltred, cmd_arr.id_lot);					 
			}	  
		}
	}			
	$('#lot').change(function () {
		var lot = $(this).val();
		cmd_arr.id_lot = lot;
		if (lot == 0) {
			console.log(cmd_arr);
			delete cmd_arr.id_lot;
			delete cmd_arr.id_sub;
			delete cmd_arr.id_counter;
			delete cmd_arr.date_b;
		} else { 
			delete cmd_arr.date_b;
			delete cmd_arr.id_sub;
            delete cmd_arr.id_counter;
			$('#substation').prop('disabled', false);
		}
		
		get_substation(objFiltred, lot);
		json_get_t_calc($('#right'), cmd_arr);
		history.pushState(null, null, create_cmd(base_link, cmd_arr));
						
	});
// Изменение подстанции фильр выбора		
	$('#substation').change(function () {
		var lot = $( '#lot' ).val();
		var substation = $(this).val();
		cmd_arr.id_lot = lot;
		cmd_arr.id_sub = substation;
		
		if (substation == 0) {	
			delete cmd_arr.id_sub;
			delete cmd_arr.id_counter;
			delete cmd_arr.date_b;
		
		} else {
			delete cmd_arr.date_b;
			delete cmd_arr.id_counter;
		}	
		get_counter(objFiltred, substation);
		json_get_t_calc($('#right'), cmd_arr);
		history.pushState(null, null, create_cmd(base_link, cmd_arr));
						
	});
// Изменение ячейки фильр выбора		
	$('#counter').change(function () {
		cmd_arr.id_lot = $('#lot').val();
		cmd_arr.id_sub = $('#substation').val();
		cmd_arr.id_counter = $(this).val();
		if (cmd_arr.id_counter == 0 ) {
			delete cmd_arr.id_counter;			
		}
		json_get_t_calc($('#right'), cmd_arr);
		history.pushState(null, null, create_cmd(base_link, cmd_arr));
	});

	$('.filtred_checkbox').on('click', function(e){  
		var checkbox_id = $(this).attr('id');
		var lot = $('#lot').val();

		if ((checkbox_id == 'dt1_en'))
			if ($('#dt1_en').prop('checked')) {  
				delete cmd_arr.st;

				$('#dt2_en').prop('disabled', false);

				$( "#dt1" ).datepicker('enable');
				cmd_arr.date_b = $("#dt1").datepicker().val();
				json_get_t_calc($('#right'), cmd_arr);
				history.pushState(null, null, create_cmd(base_link, cmd_arr));
				
			} else { 
				delete cmd_arr.date_b;
				delete cmd_arr.st;
				delete cmd_arr.date_e;

				$('#dt2_en').prop('disabled', true);
				$('#dt2_en').prop('checked', false);

				
				$( "#dt1" ).datepicker('disable');					
				$( "#dt2" ).datepicker('disable');					
				
				json_get_t_calc($('#right'), cmd_arr);
				history.pushState(null, null, create_cmd(base_link, cmd_arr));
			}

		if ((checkbox_id == 'dt2_en'))
			if ($('#dt2_en').prop('checked')) {  
				delete cmd_arr.st;

				$( "#dt2" ).datepicker('enable');
				cmd_arr.date_e = $("#dt2").datepicker().val();
				json_get_t_calc($('#right'), cmd_arr);
				history.pushState(null, null, create_cmd(base_link, cmd_arr));
				
			} else { 
				delete cmd_arr.date_e;
				delete cmd_arr.st;

				$( "#dt2" ).datepicker('disable');					
				json_get_t_calc($('#right'), cmd_arr);
				history.pushState(null, null, create_cmd(base_link, cmd_arr));
			}
	});

	$( "#dt1" ).datepicker({changeYear: true, changeMonth: true, minDate: '2016-01-01', maxDate: '0', dateFormat: 'yy-mm-dd',
		onSelect: function(dateText, inst) {
			cmd_arr.date_b = dateText;
			json_get_t_calc($('#right'), cmd_arr);
		}
	});

	$( "#dt2" ).datepicker({changeYear: true, changeMonth: true, minDate: '2016-01-01', maxDate: '0', dateFormat: 'yy-mm-dd',
		onSelect: function(dateText, inst) {
			cmd_arr.date_e = dateText;
			json_get_t_calc($('#right'), cmd_arr);
		}
	});

	if (!$('#dt1_en').prop('checked')) $( "#dt1" ).datepicker('disable');
	if (!$('#dt2_en').prop('checked')) $( "#dt2" ).datepicker('disable');

	$('#right').on('click','a',function( event ) {
		event.preventDefault();
		// console.log(event.target.search);
		var param = event.target.search;
		if (param != '') {
			var stArr = (param.substr(1)).split('&');
			for(var i=0; i < stArr.length; i++) {
				st =  stArr[i].split('=');       // массив param будет содержать
				if (st[0] == 'date_b' ) {
					if (st[1] != 0) cmd_arr.date_b = st[1]; else delete cmd_arr.date_b;
				}	
			}			
		}
		json_get_t_calc($('#right'), cmd_arr);
	});

	// Переход со страницы расход на страницу редактирования
	$('#edit_count').on('click', function(e) {
		var mount =['31', '28', '31', '30', '31', '30', '31', '31', '30', '31', '30', '31'];
		var param = cmd_arr;
		if ( 'date_b' in cmd_arr ) {
		 var dtBg = cmd_arr.date_b;
		 var dtArr = dtBg.split('-')
  			if (! (Number( dtArr[0] ) % 4) )  mount[ 1 ] = '29';
			param.date_e = dtArr[0] + '-' + dtArr[1] + '-' + mount[ Number(dtArr[1])-1 ];
            param.date_b = dtArr[0] + '-' + dtArr[1] + '-' + '01';
          console.log(param);
		}
        window.location.href = $('#edit_count').attr('href') + '?' + $.param(param);
        e.preventDefault();
    });

	$( document ).tooltip({ content: function() { return this.getAttribute("title") } });
});