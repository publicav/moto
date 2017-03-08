$( function () {
    $( "#left" ).on( 'mouseover', ".dropdown-item", function () {
        $( this ).next().addClass( "show-submenu" ).removeClass( "hide-submenu" );
    } )
    $( "#left" ).on( 'mouseout', ".dropdown-item", function () {
        $( this ).next().addClass( "hide-submenu" ).removeClass( "show-submenu" );
    } )
    $( "#left" ).on( 'mouseover', ".submenu", function () {
        $( this ).addClass( "show-submenu" ).removeClass( "hide-submenu" );
    } )
    $( "#left" ).on( 'mouseout', ".submenu", function () {
        $( this ).addClass( "hide-submenu" ).removeClass( "show-submenu" );
    } )
} )
