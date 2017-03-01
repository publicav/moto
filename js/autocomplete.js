$( function () {
    var cache = {};
    $( "#nzakaz" ).autocomplete( {
        minLength: 1,
        source: function (request, response) {
            var term = request.term;
            if ( term in cache ) {
                response( cache[ term ] );
                return;
            }

            $.getJSON( "ajax/nzakaz/", request, function (data, status, xhr) {
                cache[ term ] = data;
                response( data );
            } );
        }
    } ).autocomplete( "instance" )._renderItem = function (ul, item) {
        return $( "<li>" )
            .append( "<div id=c" + "'item.id'" + ">" + item.label + ',  ' + item.decription + "</div>" )
            .appendTo( ul );
    };

    $( "#nzakaz" ).on( "autocompleteselect", function (event, ui) {
        console.log( ui );
        var data = {
            'id': ui.item.id,
        }
        $.ajax( { dataType: 'json', type: 'get', url: 'ajax/sel_nzakaz/', data: data } )
            .done( function (result) {
                console.log( result );
            } )
            .fail( function (result) {
                    alert( 'Error - ' + result.responseJSON.error )
                }
            );

    } );

} );
