$(function(){
	var gl_add_counts = 0, buttonpressed;
	var edit_arr = new Array()
	var objSelected = {
		objLot: 	  	 $( '#lot' ),
		objSubstation:	 $( '#substation' ),
 		objCounter:   	 $( '#counter' ),
 		objCounterLastVal: $( '#counter_last_val' ),
		url_substation: 'ajax/subst/',
		url_counter:    'ajax/counter/',
		editCounter:	0
	};	
	

	if (('id_lot' in cmd_arr) && ('id_sub' in cmd_arr) && ('id_counter' in cmd_arr))	{
		   $('#lot [value="' + cmd_arr.id_lot + '"]').prop("selected", true);
		   get_substation(objSelected, cmd_arr.id_lot, EDIT_ACTIONS, cmd_arr.id_sub, cmd_arr.id_counter);
		   
	} else {
		if (('id_lot' in cmd_arr) && ('id_sub' in cmd_arr))	{
			   $('#lot [value="' + cmd_arr.id_lot + '"]').prop("selected", true);
			   get_substation(objSelected, cmd_arr.id_lot, EDIT_ACTIONS, cmd_arr.id_sub);
		} else {
			if ('id_lot' in cmd_arr)	{
				 $('#lot [value="' + cmd_arr.id_lot + '"]').prop("selected", true);
				 get_substation(objSelected, cmd_arr.id_lot);					 
			} else {
				get_substation(objSelected, $('#lot').val());
			}	  
		}
	}			
console.log('cmd array ->',cmd_arr);

	$( '#date_airing_begin' ).datepicker( {changeYear: true, dateFormat: 'dd-mm-yy'} );
	
	$.mask.definitions['H']='[012]';
	$.mask.definitions['M']='[012345]';
	$.mask.definitions['F']='[0-9.]+';
	$('#time_airing_begin').mask('H9:M9');
    console.log( objSelected );
//	get_substation(objSelected, $('#lot').val());	

	$( '#lot' ).change(function () {
		let lot = $( this ).val();
		get_substation( objSelected, lot );	
		$('#counter_val').val('');
		let counter = objSelected.objCounter.val();
		objSelected.param = {'counter': counter};
	});

	$( '#substation' ).change(function () {
		let substation = $( this ).val();
		get_counter( objSelected, substation);	
		$('#counter_val').val('');
	});
	$( '#counter' ).change(function () {
		$('#counter_val').val( '' );
		let counter = $( this ).val();
		objSelected.param = {'counter': counter};
		if ( objSelected.editCounter == 0 ) get_last_val( objSelected );
	});
	
	 $('#counter_val').keydown(function(event) {
        // Разрешаем: backspace, delete, tab и escape
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || 
             // Разрешаем: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || (event.keyCode == 188) || (event.keyCode == 190) ||
			(event.keyCode == 116 && event.ctrlKey === true) ||  (event.keyCode == 110) ||
             // Разрешаем: home, end, влево, вправо
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // Ничего не делаем
                 return;
        }
        else {
            // Обеждаемся, что это цифра, и останавливаем событие keypress
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
	
	$( '#counter_val' ).keyup(function () {
		let counterVal = $( this ).val();
		let counterLastVal = $( '#counter_last_val' ).val();
		if ( objSelected.editCounter == 0  ) {	
			if ( String(counterVal.length)  > 0 ) {
				counterVal = counterVal.replace( ',', '.' );
				var dtVal =  +counterVal - +counterLastVal;
				if ( dtVal >= 0 ) {
					$( this ).removeClass('bad_cell').addClass('good_cell');
				} else {
					$( this ).removeClass('good_cell').addClass('bad_cell');
				}	
				console.log('This - > ', counterVal, typeof(counterVal), dtVal );
			}
		} else 	$('#counter_last_val').removeClass('good_cell').removeClass('bad_cell').addClass('norm_cell');
	});
	
		$('#list_counts').on('click','a',function( event ) {
				var arr_id = $( this ).attr('id');
				var index = find_arr_id( edit_arr,arr_id );
				var lot_value = edit_arr[index].lot;
				var substation_value = edit_arr[index].substation;
				var couner_value = edit_arr[index].counter;
				objSelected.editCounter = 1;
				$( '#counter_last_val' ).val('');
				$('#counter_val').removeClass('good_cell').removeClass('bad_cell').addClass('norm_cell');;
			
				
				$('#lot').find('[value="' + lot_value + '"]').prop("selected", true );		
				
				get_substation( objSelected, lot_value, EDIT_ACTIONS, substation_value, couner_value );
				
				$('#date_airing_begin').val( edit_arr[index].date );		
				$('#time_airing_begin').val( edit_arr[index].time );	
				$('#counter_val').val( edit_arr[index].value );	
				$('#edit_id').val( arr_id );	

				$('#ok_f').button("option", "disabled", true ); // - блокировка элемента с id=ok_f
				$('#edit_f').button("option", "disabled", false ); // - блокировка элемента с id=edit_f
				
				event.preventDefault();
				
		});

		$( 'input[type=submit], a, button').button().
		click(function(){
			buttonpressed = $(this).attr('id');
		});
		
		$('#add_value_counts_form').submit(function(event){
			event.preventDefault();
			me = this;
			btn = {id: buttonpressed};
			buttonpressed = '';
			obj = {
				form: 		me,				
				objBtnOk:	$('#ok_f'),
				objBtnEdit: $('#edit_f'),
				btnPress: 	btn,				
				objListRec: $('#list_counts'),
				gl_add_counts,
				edit_arr,
				__proto__:	 objSelected
			}
			
			add_form_actions( obj );
			objSelected.editCounter = 0;
			
	  });
	
});