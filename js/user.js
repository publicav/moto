$(function(){
    var objEditUser = { 
		objUser : 	  		$( '#user_edit' ),
		objPassword:		$( '#pass_edit' ),
		objConfirmPassword: $( '#pass_repeat_edit' ),
		objUserFamily: 		$( '#family_edit' ),
		objUserName: 		$( '#name_edit' ),
		objId: 				$( '#edit_user_id' )
	};
	json_get_user( $( '#right' ) );
	user_form_add = $( "#user_div_add" ).dialog({
					title: "Добавление пользователя",
					autoOpen: false,
					resizable: false,
					modal: true,
					height: 430,
					width: 500,
					buttons: {
						"Ok": {		
							text: 'Ok',
							click : function ( obj_form ){
								var obj = { 
									objTarget:  $( '#right' ),
									actionsCmd: ADD_USER_ACTIONS,
									__proto__: 	obj_form
								};
								user_form_actions( obj );
							}
						},	
						Cancel: function() {
							user_form_add.dialog( "close" );
						}
					}
	});

	user_form_add_submit = user_form_add.find( "form" ).on( "submit", function( event ) {
	  event.preventDefault();
	});

	user_form_edit = $( "#user_div_edit" ).dialog({
						title: "Редактирование пользователя",
						autoOpen: false,
						resizable: false,
						modal: true,
						height: 430,
						width: 500,
						buttons: {
							"edit_privilege_btn": {
								class: 'ui-button-left',
								text: 'Привелегии...',
								click : function (){
									edit_privilege();
									user_form_edit.dialog( "close" );
									user_form_privilege.dialog( "open" );
								}
							},
							"Ok": {		
								text: 'Ok',
								click : function (obj_form){
									var obj = { 
										objTarget:  $( '#right' ),
										actionsCmd: EDIT_USER_ACTIONS,
										__proto__:	 obj_form
									};
									user_form_actions(obj);
								}
							},	
							Cancel: function() {
							  user_form_edit.dialog( "close" );
							}
						}
	});

	user_form_edit_submit = user_form_edit.find( "form" ).on( "submit", function( event ) {
	  event.preventDefault();
	});

	user_form_privilege = $( "#user_div_privelege" ).dialog({
								title: "Редактирование привелегий",
								autoOpen: false,
								resizable: false,
								modal: true,
								height: 350,
								width: 350,
								buttons: {
									"Ok": privilege_user_form_actions,
									Cancel: function() {
									  user_form_privilege.dialog( "close" );
									}
								}
	});

	user_form_privilege_submit = user_form_privilege.find( "form" ).on( "submit", function( event ) {
	  event.preventDefault();
	});

	
	$('#right').on('click','#add_user_btn',function( event ) {
		$('#user_add').val('');	
		$('#pass_add').val('');
		$('#pass_repeat_add').val('');	
		$('#family_add').val('');	
		$('#name_add').val('');	
		$('#edit_user_id').val('');	
		
		user_form_add.dialog( "open" );			
		event.preventDefault();			
	});

	$('#right').on('click','.counter_str_even',function( event ) {
		var edit_user_id = $( this ).attr('id');
		objEditUser.param = {'id': edit_user_id.slice(3)};			
		l_form_edit_user( objEditUser )
		user_form_edit.dialog( "open" );
	});

	$('#right').on('click','.counter_str_odd',function( event ) {
		var edit_user_id = $( this).attr('id');
		objEditUser.param = {'id': edit_user_id.slice( 3 )};
		l_form_edit_user( objEditUser )
		user_form_edit.dialog( "open" );
	});
	
	$( document ).tooltip();
	$( "#right button" )
		.button()
		.click(function( event ) {
			event.preventDefault();
	});
});