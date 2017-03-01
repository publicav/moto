$(function(){
	$( '#loginform' ).submit(function( event ){
		event.preventDefault();
		console.log(this);
		var me = this;
		registration( me );
		login_form.dialog( "close" );
	});

	login_form = $( '#loginmodal' ).dialog({
									title: "Регистрация пользователя",
									autoOpen: false,
									resizable: false,
									modal: true,
									height: 250,
									width: 400
	});
	
	$('#menu').on('click','#login',function( event ) {
		login_form.dialog( "open" );			
		event.preventDefault();			
	});	
	
	$('#menu').on('click','#logout',function( event ) {
		unregistration();
		event.preventDefault();
	});
	
});