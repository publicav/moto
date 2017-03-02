$( function () {
    let sapFormDialog;
    let cache = {};

    sapFormDialog = $( "#sapform" )
        .dialog( {
            title: "Добавлениме номера САП",
            autoOpen: false,
            resizable: false,
            height: 350,
            width: 620,
            modal: true,
            classes: {
                "ui-dialog": "edit_counter"
            },
            close: function ( event, ui ) {
                $( '#nzakaz' ).val( '' );
            },
            buttons: {
                "Ok": {
                    text: 'Ok',
                    click: function () {
                        // let form = sapFormSubmit.find( 'form' );
                        // form[ 1 ].submit();
                        actionFormSap( this );
                        sapFormDialog.dialog( "close" );
                    }
                },
                Cancel: function () {
                    $( '#nzakaz' ).val( '' );
                    sapFormDialog.dialog( "close" );
                },
            }
        } );

    var sapFormSubmit = $( document ).on( "submit", '#sapform', function ( event ) {
        event.preventDefault();
        actionFormSap( this );
        sapFormDialog.dialog( 'close' );
    } );
    console.log( sapFormSubmit );

    $( "#nzakaz" ).autocomplete( {
        minLength: 1,
        source: function ( request, response ) {
            let term = request.term;
            if ( term in cache ) {
                response( cache[ term ] );
                return;
            }

            $.getJSON( "ajax/nzakaz/", request, function ( data, status, xhr ) {
                cache[ term ] = data;
                response( data );
            } );
        }
    } ).autocomplete( "instance" )._renderItem = function ( ul, item ) {
        if ( item.inv == 0 ) item.inv = 'not used';
        if ( item.date == 0 ) item.date = 'not used';

        if ( item.pos == null ) item.pos = '';
        if ( item.descr == null ) item.descr = '';

        let div = `<div>${item.label}, | ${item.inv}, | ${item.date}, | ${item.pos}${item.descr} </div>`;
        return $( "<li>" )
            .append( div )
            .appendTo( ul );
    };

    $( "#nzakaz" ).on( "autocompleteselect", function ( event, ui ) {
        let data = {
            'id': ui.item.id,
        };
        $.ajax( { dataType: 'json', type: 'get', url: 'ajax/loadform_sap/', data: data } )
            .done( function ( result ) {
                let res = result.data;
                loadFormSap( res );
                sapFormDialog.dialog( "open" );
                console.log( result );

            } )
            .fail( function ( result ) {
                    alert( 'Error - ' + result.responseJSON.error )
                }
            );

    } );
    const loadFormSap = ( { id, n_order, inv, date, descr, pos, nsup } ) => {
        if ( inv == 0 ) inv = 'not used';
        if ( nsup == 0 ) nsup = '';
        console.log( id );
        $( '#sap_id' ).val( id );
        $( '#norrder' ).val( n_order );
        $( '#inv_num' ).val( inv );
        $( '#dt1' ).val( date );
        $( '#descrform' ).val( descr );
        $( '#position' ).val( pos );
        $( '#nsup' ).val( nsup );
    }
    const actionFormSap = ( form ) => {

        let m_method = $( form ).attr( 'method' );
        let m_action = $( form ).attr( 'action' );
        let m_data = $( form ).serialize();
        console.log( m_method, m_action, m_data );
        $.ajax( { dataType: 'json', type: m_method, url: m_action, data: m_data } )
            .done( ( result ) => {
                console.log( result );
            } )
            .fail( ( result ) => alert( result.responseJSON.error ) );

    }
} );
