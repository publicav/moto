$(function() {
	var objSelected = {
		objLot: $('#lot_edit'),
		objSubstation: $('#substation_edit'),
		objCounter: $('#counter_edit'),
		url_substation: 'ajax/subst/',
		url_counter: 'ajax/counter/'
	};
	
	var objEditForm = {
		objDate : $('#date_airing_begin_edit'), 
		objTime: $('#time_airing_begin_edit'), 
		objValEdit: $('#counter_val_edit'),
		objId: $('#edit_id1'), 
		__proto__: objSelected
	}

	$( "#date_airing_begin_edit" ).datepicker({changeYear: true, dateFormat: 'dd-mm-yy'});
	$.mask.definitions['H']='[012]';
	$.mask.definitions['M']='[012345]';
	$.mask.definitions['F']='[0-9.]+';
	$('#time_airing_begin_edit').mask('H9:M9');
	
	$('#lot_edit').change(function () {
		var lot = $(this).val();
		get_substation(objSelected, lot);	
	});

	$('#substation_edit').change(function () {
		var substation = $(this).val();
		get_counter( objSelected, substation);	
	});

	edit_form = $( "#edit_counter" ).dialog({
						title: "Редактирование значения счётчика",
						autoOpen: false,
						resizable: false,
						height: 350,
						width: 620,
						modal: true,
						classes: {
							 "ui-dialog": "edit_counter"
						},
						buttons: {
							"Ok": {		
								text: 'Ok',
								click : function (obj_form){
									var obj = { 
										objLot : $('#lot_edit'),
										objSubstation: $('#substation_edit'), 
										objCounter: $('#counter_edit'),
										objTarget:  $('#right'),
										cmd: cmd_arr,
										__proto__: obj_form
									};

									edit_form_actions( obj );
								   
								}
							},											
							Cancel: function() {
							  edit_form.dialog( "close" );
							}
						}
	});
	
	edit_form_submit = edit_form.find( "form" ).on( "submit", function( event ) {
	  event.preventDefault();
	});

	$('#right').on('click','.counter_str_even',function( event ) {
		var edit_id = $(this).attr('id');
		objEditForm.param = {'id': edit_id.slice(3)};
		l_form_edit_value( objEditForm );
		edit_form.dialog( "open" );
	});
	$('#right').on('click','.counter_str_odd',function( event ) {
		var edit_id = $(this).attr('id');
		objEditForm.param = {'id': edit_id.slice(3)};
		l_form_edit_value( objEditForm );
		edit_form.dialog( "open" );
	});

					
	
});