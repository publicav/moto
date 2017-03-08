const getUrlVars = () => {
    let vars = {}, hash;
    if ( location.search ) {
        let hashes = (location.search.substr( 1 )).split( '&' );
        for ( let i = 0; i < hashes.length; i ++ ) {
            hash = hashes[ i ].split( '=' );
            vars[ hash[ 0 ] ] = hash[ 1 ];
        }
    }
    return vars;
};

const SELECTED_ACTIONS = 1, EDIT_ACTIONS = 2;
const ADD_COUNTER_BTN_NAME = 'ok_f', EDIT_COUNTER_BTN_NAME = 'edit_f';
const parseBASENAME = window.location.pathname.slice( 1 ).split( '/' );
const BASENAME = parseBASENAME[ parseBASENAME.length - 1 ];

var cmd_arr = {};
cmd_arr = getUrlVars();
console.log( cmd_arr );

/**
 * Возвращает индекс массива объектов.
 *
 * @param {array} arr массив объектов.
 * @param {number} find_id Значение id объекта по которому  осуществляется поиск.
 * @return {number} Возвращает index когда arr[..].id = find_id.
 */
const find_arr_id = ( arr, find_id ) => {
    let ret = - 1;
    for ( let i = 0; i < arr.length; i ++ ) if ( arr[ i ].id == find_id ) {
        ret = i;
        break;
    }
    return ret;
};

/**
 * Парсим командную строку ищем значение st.
 *
 * @param {string} param исходная командная строка.
 * @return {string} Возвращает retSt если находит st={number} .
 */
const cmdLineParsing = ( param ) => {
    let st, retSt;
    if ( param != '' ) {
        let stArr = (param.substr( 1 )).split( '&' );
        for ( let i = 0; i < stArr.length; i ++ ) {
            st = stArr[ i ].split( '=' );       // массив param будет содержать
            if ( st[ 0 ] == 'st' ) {
                if ( st[ 1 ] != 0 ) retSt = st[ 1 ];
            }
        }
    }
    return retSt;
};

let get_last_val = ( { objCounterLastVal, param } ) => {
    $.ajax( { dataType: 'json', type: 'post', url: 'ajax/lastvalue_counter/', data: param } )
        .done( ( result ) => {
            let data = result.data;
            objCounterLastVal.val( data.value );
        } )
        .fail( ( result ) => alert( result.responseJSON.error ) );
};


let get_counter = ( { objCounter, objCounterLastVal = {}, url_counter, actions = SELECTED_ACTIONS, couner_value = 0, editCounter = 0 }, data = 1, last_val = () => {
} ) => {
    objCounter.prop( 'disabled', true );
    objCounter.html( '<option>загрузка...</option>' );
    $.getJSON( url_counter, { data: data } )
        .done( ( result, a, b ) => {
            let options = '';
            $( result.data ).each( function () {
                options += '<option value="' + $( this ).attr( 'id' ) + '">' + $( this ).attr( 'name' ) + '</option>';
            } );
            objCounter.html( options );
            objCounter.prop( 'disabled', false );
            if ( actions == EDIT_ACTIONS ) objCounter.find( '[value="' + couner_value + '"]' ).prop( "selected", true );
        } )
        .then( ( result ) => {
            let counter;
            if ( Object.keys( objCounterLastVal ).length != 0 ) {
                if ( editCounter == 0 ) {
                    // console.log( result.data[0].id ,actions, couner_value );
                    if ( actions == SELECTED_ACTIONS ) counter = result.data[ 0 ].id;
                    if ( actions == EDIT_ACTIONS )    if ( couner_value == 0 ) counter = result.data[ 0 ].id; else counter = couner_value;
                    $.ajax( {
                        dataType: 'json',
                        type: 'post',
                        url: 'ajax/lastvalue_counter/',
                        data: { 'counter': counter }
                    } )
                        .done( ( result ) => {
                            let data = result.data;
                            objCounterLastVal.val( data.value );
                        } )
                        .fail( ( result ) => alert( result.responseJSON.error ) );
                }
            }
        } )
        .fail( ( result, b, c ) => alert( result.responseJSON.error ) );
//	console.log(a, b, c);
};

let get_substation = ( { objSubstation, objCounter, objCounterLastVal = {}, url_substation, url_counter, editCounter = 0 },
    data = 1, actions = SELECTED_ACTIONS, value = 0, couner_value = 0 ) => {
    objSubstation.prop( 'disabled', true );
    objSubstation.html( '<option>загрузка...</option>' );
    $.getJSON( url_substation, { data: data } )
        .done( ( result ) => {
            let options = '';
            $( result.data ).each( function () {
                options += '<option value="' + $( this ).attr( 'id' ) + '">' + $( this ).attr( 'name' ) + '</option>';
            } );
            objSubstation.html( options );
            objSubstation.prop( 'disabled', false );
            if ( actions == SELECTED_ACTIONS )
                get_counter( {
                    objCounter,
                    objCounterLastVal,
                    url_counter
                }, result.data[ 0 ].id );
            if ( actions == EDIT_ACTIONS ) {
                objSubstation.find( '[value="' + value + '"]' ).prop( "selected", true );
                get_counter( {
                    objCounter,
                    objCounterLastVal,
                    url_counter,
                    actions,
                    EDIT_ACTIONS,
                    couner_value
                }, value );
            }
        } )
        .fail( ( result, b, c ) => alert( result.responseJSON.error ) );
};


let create_cmd = ( base_link, params ) => {
    let count = 0;
    let cmd = base_link;
    for ( let key in params ) {
        if ( count == 0 ) cmd += '?'; else cmd += '&';
        cmd += key + '=' + params[ key ];
        count ++;
    }
    return cmd;
};

const print_table = ( counter ) => {
    let count = 0, class_e;
    let st = `	<div class="title_table_counter">
					<div class="title_lots">Участок</div>
					<div class="title_substation">Подстанция</div>
					<div class="title_counts">Ячейка</div>
					<div class="title_date">Дата</div>
					<div class="title_date">Значение</div>
				</div>`;

    for ( let key in counter ) {
        if ( count % 2 != 0 ) class_e = 'counter_str_odd'; else class_e = 'counter_str_even';
        st += `	<div id="id_${counter[ key ].id}" class="${class_e}" title="Ввод - <b>${counter[ key ].name_user}</b>">
				<div class="col_lots">${counter[ key ].lot}</div>
				<div class="col_substation">${counter[ key ].substation}</div>
				<div class="col_counts">${counter[ key ].counter}</div>
				<div class="col_date">${counter[ key ].date1}</div>
				<div class="col_value">${counter[ key ].value}</div>
				</div>`;
        count ++;
    }
    return st;
};

const navigation = ( data ) => {
    let page = data.page;
    let span = '';
    for ( let i = 0; i < page.length; i ++ ) {
        if ( page[ i ].st == null ) {
            span += `<span class="pagecurrent">${page[ i ].text}</span>`;
        } else {
            span += `<span class="pagelink"><a href="${data.file}?st=${page[ i ].st}${data.paramUrl}" title="${page[ i ].title}">${page[ i ].text}</a></span>`;
        }
    }
    return `<p>${span}<p>`;
};

let print_t_calc = ( data ) => {
    let count = 0, class_e;
    let title = data.title;
    let counter = data.Data;
    let st = `	<div class="title_table_counter">
					<div class="title_calc_counter">Ячейка</div>
					<div class="title_calc_date">Дата</div>
					<div class="title_calc_value">Значение</div>
				</div>`;

    for ( let key in counter ) {
        if ( count % 2 != 0 ) class_e = 'counter_str_odd'; else class_e = 'counter_str_even';
        if ( counter[ key ].rare < 0 ) class_e = 'counter_str_err';
        st += `	<div class="${class_e}" title="Расчёт">
					<div class="colum_calc_counter">${title}</div>
					<div class="colum_calc_date">${counter[ key ][ 0 ]}</div>
					<div class="colum_calc_value">${counter[ key ][ 1 ]}</div>
				</div>`;
        count ++;
    }
    return st;
};


let json_get_table = ( objTarget, cmd_arr ) => {
    $.ajax( { dataType: 'json', type: 'get', url: 'ajax/filterValue/', data: cmd_arr } )
        .done( ( result ) => {
            if ( result.success ) {
                let data = result.data;
                objTarget.html( print_table( data ) );
                let navigationD = navigation( result.navigationData );
                objTarget.append( '<div class="navigator">' + navigationD + '</div>' );
                // objTarget.append( result.navigator );
                history.pushState( null, '', create_cmd( '', cmd_arr ) );
            } else  alert( result.error );
        } )
        .fail( () => alert( result.responseJSON.error ) );
};

let json_get_t_calc = ( objTarget, cmd_arr ) => {
    $.ajax( { dataType: 'json', type: 'get', url: 'ajax/calculation_counter/', data: cmd_arr } )
        .done( ( result ) => {
            if ( result.success ) {
                // let data = result.data;
                objTarget.html( print_t_calc( result ) );
                objTarget.append( result.navigator );
                history.pushState( null, '', create_cmd( '', cmd_arr ) );
            } else  alert( result.error );
        } )
        .fail( ( result ) => alert( result.responseJSON.error ) );
};

/**
 * Возвращает отформатированую строку введенных данных.
 * данные передаются ввиде одного объекта.
 * @param {string} name_lot строка содержащая участок ввода.
 * @param {string} name_substation строка содержащая подстанцию ввода.
 * @param {string} name_lot строка содержащая ячейку ввода.
 * @param {string} date  дата ввода.
 * @param {string} time  время ввода.
 * @param {number} value значение счётчика.
 * @param {number} id счётчика в базе.
 * @param {object} name_counter  массив объектов.

 * @return {string} row_add возвращает строку введенных данных.
 */
let print_add_record = ( { name_lot, name_substation, name_counter, date, time, value, id } ) => {
    let row_add = `
			<div class="col_lots">${name_lot}</div>
			<div class="col_substation">${name_substation}</div> 
			<div class="col_counts">${name_counter}</div> 
			<div class="col_date">${date} ${time}</div> 
			<div class="col_value">${value}</div> 
			<a id="${id}">Правка</a>	
			`;
    return row_add;
};

let l_form_edit_value = ( {
    objLot, objSubstation, objCounter, objDate, objTime, objValEdit,
    objId, url_substation, url_counter, param
} ) => {
    $.ajax( { dataType: 'json', type: 'post', url: 'ajax/loadform_value/', data: param } )
        .done( ( result ) => {
            let data = result.data;
            let obj = { objSubstation, objCounter, url_substation, url_counter };
            objLot.find( '[value="' + data.lot_id + '"]' ).prop( "selected", true );
            get_substation( obj, data.lot_id, 2, data.sub_id, data.counter_id );
            objDate.val( data.date1 );
            objTime.val( data.time1 );
            objValEdit.val( data.value );
            objId.val( data.id );
        } )
        .fail( ( result ) => alert( result.error ) );
};

let edit_form_actions = ( obj_form ) => {
    let form = obj_form.view.edit_form_submit;
    let workForm = obj_form.view.edit_form;
    let lot = obj_form.objLot.val();
    let substation = obj_form.objSubstation.val();
    let counts = obj_form.objCounter.val();
    let m_method = $( form ).attr( 'method' );
    let m_action = $( form ).attr( 'action' );
    let m_data = $( form ).serialize(); // input1=value1&input2=value2..., только input=text
    m_data += `&lot=${lot}&substation=${substation}&counter=${counts}&actions=edit`;

    $.ajax( { dataType: 'json', type: m_method, url: m_action, data: m_data } )
        .done( ( result ) => {
            if ( result.success ) {
                // let data = result.data;
                workForm.dialog( "close" );
                json_get_table( obj_form.objTarget, obj_form.cmd );
            } else  alert( result.error );
        } )
        .fail( ( result ) => alert( result.responseJSON.error ) );
};

let add_form_actions = ( { form, objLot, objSubstation, objCounter, objBtnOk, objBtnEdit, objListRec, btnPress, gl_add_counts, edit_arr } ) => {
    let lot = objLot.val();
    let substation = objSubstation.val();
    let counts = objCounter.val();
    let m_method = $( form ).attr( 'method' );
    let m_action = $( form ).attr( 'action' );
    let m_data = $( form ).serialize(); // input1=value1&input2=value2..., только input=text

    m_data += `&lot=${lot}&counter=${counts}&substation=${substation}`;
    if ( btnPress.id == ADD_COUNTER_BTN_NAME ) m_data += '&actions=add';
    if ( btnPress.id == EDIT_COUNTER_BTN_NAME ) m_data += '&actions=edit';

    $.ajax( { dataType: 'json', type: m_method, url: m_action, data: m_data } )
        .done( ( result ) => {
            if ( result.success ) {
                let data = result.data;
                gl_add_counts ++;

                let row_edit = print_add_record( data );
                let row_add = `<li>${row_edit}</li>`;

                if ( btnPress.id == ADD_COUNTER_BTN_NAME ) ok_btn( data, row_add );
                if ( btnPress.id == EDIT_COUNTER_BTN_NAME ) edit_btn( data, row_edit );


            }
            else  alert( result.error );
        } )
        .fail( ( result ) => alert( result.responseJSON.error ) );

    let ok_btn = ( data, row_add ) => {
        if ( gl_add_counts <= 10 ) {
            edit_arr.unshift( data );
            objListRec.prepend( row_add );
        } else {
            edit_arr.unshift( data );
            edit_arr.pop();
            objListRec.find( 'li:last' ).remove();
            objListRec.prepend( row_add );
        }
    };
    let edit_btn = ( data, row_edit ) => {
        let index = find_arr_id( edit_arr, data.id );
        edit_arr[ index ] = data;
        objBtnOk.button( "option", "disabled", false ); // - блокировка элемента с id=ADD_COUNTER_BTN_NAME
        objBtnEdit.button( "option", "disabled", true ); // - разблокировка элемента с id=EDIT_COUNTER_BTN_NAME
        objListRec.find( 'li:nth-child(' + ( index + 1 ) + ')' ).html( row_edit );
    }

};

