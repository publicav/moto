$( function () {

    menuLeftInit();

    $( '#loginform' ).submit( function ( e ) {
        e.preventDefault();
        console.log( this );
        const me = this;
        registration( me );
        login_form.dialog( "close" );
    } );

    const login_form = $( '#loginmodal' ).dialog( {
        title: "Регистрация пользователя",
        autoOpen: false,
        resizable: false,
        modal: true,
        height: 250,
        width: 400
    } );

    $( '#menu' ).on( 'click', '#login', function ( e ) {
        login_form.dialog( "open" );
        e.preventDefault();
    } );

    $( '#menu' ).on( 'click', '#logout', function ( e ) {
        unregistration();
        e.preventDefault();
    } );

    const unregistration = () => {
        $.ajax( { dataType: 'json', type: 'post', url: 'ajax/unregistration/' } )
            .done( ( result ) => {
                $.ajax( { dataType: 'json', type: 'post', url: 'json/menu.json' } )
                    .done( ( result_menu ) => {
                        let menu = result_menu.menu;
                        $( '#menu' ).html( `<ul>${print_mainmenu( menu )}</ul>` );
                        $( '#left' ).html( '' );
                        $( '#right' ).html( '' );
                    } )
                    .fail( () => alert( 'Error' ) );
                alert( result.message );
            } )
            .fail( () => alert( 'Error' ) );
    }

    const registration = ( form ) => {
        var m_method = $( form ).attr( 'method' );
        var m_action = $( form ).attr( 'action' );
        var m_data = $( form ).serialize();

        $.ajax( { dataType: 'json', type: m_method, url: m_action, data: m_data } )
            .done( ( result ) => {
                $.ajax( { dataType: 'json', type: 'post', url: 'json/menu_registration.json' } )
                    .done( ( result_menu ) => {
                        let menu = result_menu.menu;
                        let mainfile = `<ul>${print_mainmenu( menu )}`;
                        if ( result.id != 0 ) mainfile += `<div class="user"><div class="title_user">Вы зашли как:</div>${result.name} ${result.family}</div>`;
                        mainfile += '</ul>';
                        $( '#menu' ).html( mainfile );
                    } )
                    .fail( ( result ) => alert( 'Error' ) );

                $.ajax( { dataType: 'json', type: 'post', url: 'ajax/menuleft/' } )
                    .done( ( result_menu ) => {
                        var menu = result_menu;
                        $( '#left' ).html( `<nav id="navbar"><ul id="left-menu">${print_menu( menu )}</ul></nav>` );
                    } )
                    .fail( ( result ) => {
                        console.log( result );
                        //alert(result.responseJSON.error);
                    } );
            } )
            .fail( ( result ) => alert( result.responseJSON.error ) );
    }

    const print_mainmenu = ( menu ) => {
        let st = '';
        for ( let i = 0; i < menu.length; i ++ )
            st += `	<li class="menu_childs1">
					<a id="${menu[ i ].id_a}" href="${menu[ i ].id_a}">${menu[ i ].name}</a>
				</li>`;
        return st;
    }

    const print_menu = ( menu ) => {
        let st = '';
        let li_id = '';
        for ( let i = 0; i < menu.length; i ++ ) {
            let lm = menu[ i ][ 0 ];
            if ( lm.li_id !== null ) li_id = " class=" + lm.li_id; else li_id = '';
            st += `	<li${li_id}>
					<a id="${lm.id_a}" href="${lm.id_a}">
						<i class="${lm.icon}"></i>
						${lm.name}
					</a>
				</li>`;
            if ( menu[ i ].length > 1 ) {
                let j = 1;
                st += `<ul class="submenu hide-submenu">`;
                while ( j < menu[ i ].length ) {
                    console.log( menu[ i ][ j ] )
                    var subLm = menu[ i ][ j ];
                    st +=
                        `<li>
                            <a  id="${subLm.id_a}" href="${subLm.id_a}">
                                <i class="${subLm.icon}"></i>
                                ${subLm.name}
                            </a>
                        </li>`;
                    j ++;
                }
                st += "</ul>";
            }
        }
        return st;
    }


} );