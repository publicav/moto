let getUrlVars = () => {
    var vars = {} , hash;
	if (location.search) {
		var hashes = (location.search.substr(1)).split('&');
		for(var i = 0; i < hashes.length; i++) {
			hash = hashes[i].split('=');
			vars[hash[0]] = hash[1];
		}
	}
    return vars;
}

const SELECTED_ACTIONS = 1, EDIT_ACTIONS = 2;
const ADD_USER_ACTIONS = 1, EDIT_USER_ACTIONS = 2;
const ADD_COUNTER_BTN_NAME = 'ok_f', EDIT_COUNTER_BTN_NAME = 'edit_f';
const parseBASENAME = window.location.pathname.slice( 1 ).split( '/' );
const BASENAME = parseBASENAME[parseBASENAME.length-1];

var cmd_arr	= {};
cmd_arr = getUrlVars();
console.log(cmd_arr);

/**
 * Возвращает индекс массива объектов.
 *
 * @param {array} arr массив объектов.
 * @param {number} find_id Значение id объекта по которому  осуществляется поиск.
 * @return {number} Возвращает index когда arr[..].id = find_id.
 */
let find_arr_id = ( arr, find_id ) => {
	var ret = -1;
	for (var i = 0; i < arr.length; i++) if (arr[i].id == find_id) {ret = i; break;}
	return ret;
}

/**
 * Парсим командную строку ищем значение st.
 *
 * @param {string} param исходная командная строка.
 * @return {string} Возвращает retSt если находит st={number} .
 */
let cmdLineParsing = ( param ) => {
	var st, retSt;
	if (param != '') {
		var stArr = (param.substr(1)).split('&');
		for (var i = 0; i < stArr.length; i++) {
			st =  stArr[i].split('=');       // массив param будет содержать
			if (st[0] == 'st' ) {
				if (st[1] != 0) retSt = st[1];
			}
		}
	}
	return retSt;
}

let get_last_val = ( {objCounterLastVal, param } ) => {
	$.ajax({dataType: 'json', type: 'post', url: 'ajax/lastvalue_counter/', data: param})
	 .done(( result ) => {
			var data = result.data;
			objCounterLastVal.val( data.value );
	})
	.fail(( result ) => alert( result.responseJSON.error));
}


let get_counter = ( { objCounter, objCounterLastVal = {}, url_counter, actions = SELECTED_ACTIONS, couner_value = 0, editCounter = 0 }, data = 1, last_val = () =>{}) => {
	objCounter.prop('disabled', true);
	objCounter.html('<option>загрузка...</option>');
	$.getJSON( url_counter, { data: data } )
 	.done(( result, a, b ) => {
			var options = '';
			$( result.data ).each(function() { options += '<option value="' + $( this ).attr('id') + '">' + $( this ).attr('name') + '</option>';	});
			objCounter.html( options );
			objCounter.prop( 'disabled', false );
			if ( actions == EDIT_ACTIONS ) objCounter.find('[value="' + couner_value + '"]').prop( "selected", true );
	})
	.then((result) => {
		var counter;
		if (Object.keys(objCounterLastVal).length != 0) {
			if ( editCounter == 0 ) {
				// console.log( result.data[0].id ,actions, couner_value );
				if ( actions == SELECTED_ACTIONS ) counter = result.data[0].id;
				if ( actions == EDIT_ACTIONS ) 	if (couner_value == 0 ) counter = result.data[0].id; else counter = couner_value;
				$.ajax({dataType: 'json', type: 'post', url: 'ajax/lastvalue_counter/', data: { 'counter': counter } } )
				 .done(( result ) => {
						var data = result.data;
						objCounterLastVal.val( data.value );
				})
				.fail(( result ) => alert( result.responseJSON.error));
			}
		}
	})
	.fail(( result, b, c ) => alert( result.responseJSON.error ));
//	console.log(a, b, c);
}

let get_substation = ( {objSubstation, objCounter, objCounterLastVal = {}, url_substation, url_counter, editCounter = 0},
			      data = 1, actions = SELECTED_ACTIONS, value = 0, couner_value = 0 ) => {
	objSubstation.prop('disabled', true);
	objSubstation.html('<option>загрузка...</option>');
	$.getJSON(url_substation, {data: data})
	.done((result) => {
			var options = '';
			$(result.data).each(function() { options += '<option value="' + $(this).attr('id') + '">' + $(this).attr('name') + '</option>';	});
			objSubstation.html( options );
			objSubstation.prop('disabled', false);
			if (actions == SELECTED_ACTIONS) get_counter( { objCounter, objCounterLastVal, url_counter}, result.data[0].id );
			if (actions == EDIT_ACTIONS) {
				objSubstation.find('[value="' + value + '"]').prop("selected", true);
				get_counter( { objCounter, objCounterLastVal, url_counter, actions, EDIT_ACTIONS, couner_value}, value );
			}
	})
	.fail(( result, b, c ) => alert( result.responseJSON.error));
}


let create_cmd = ( base_link, params )  => {
	var count = 0;
	var cmd = base_link;
	for (let key in params) {
		if (count == 0 ) cmd += '?'; else cmd += '&';
		cmd += key + '=' + params[key];
		count++;
	}
	return cmd;
}

let print_table = ( counter )  => {
	var count = 0 , class_e;
	var st = `	<div class="title_table_counter">
					<div class="title_lots">Участок</div>
					<div class="title_substation">Подстанция</div>
					<div class="title_counts">Ячейка</div>
					<div class="title_date">Дата</div>
					<div class="title_date">Значение</div>
				</div>`;

	for (let key in counter) {
		if (count % 2 != 0)  class_e = 'counter_str_odd'; else class_e = 'counter_str_even';
		st += `	<div id="id_${counter[key].id}" class="${class_e}" title="Ввод - <b>${counter[key].name_user}</b>">
				<div class="col_lots">${counter[key].lot}</div>
				<div class="col_substation">${counter[key].substation}</div>
				<div class="col_counts">${counter[key].counter}</div>
				<div class="col_date">${counter[key].date1}</div>
				<div class="col_value">${counter[key].value}</div>
				</div>`;
		count++;
	}
	return st;
}
const navigation = ( data ) =>{
	var page = data.page;
	var span = '';
	for(let i =0 ; i<page.length; i++) {
	    if (page[i].st == null) {
            span += `<span class="pagecurrent">${page[i].text}</span>`;
		} else {
	    	span += `<span class="pagelink"><a href="${data.file}?st=${page[i].st}${data.paramUrl}" title="${page[i].title}">${page[i].text}</a></span>`;
        }
    }
    var result = `<p>${span}<p>`;
	return result;
}

let print_t_calc = ( data )  => {
	var count = 0 , class_e;
	var title = data.title;
	var counter = data.Data;
	var st = `	<div class="title_table_counter">
					<div class="title_calc_counter">Ячейка</div>
					<div class="title_calc_date">Дата</div>
					<div class="title_calc_value">Значение</div>
				</div>`;

	for (let key in counter) {
		if (count % 2 != 0)  class_e = 'counter_str_odd'; else class_e = 'counter_str_even';
		if ( counter[key].rare < 0 ) class_e = 'counter_str_err';
		st += `	<div class="${class_e}" title="Расчёт">
					<div class="colum_calc_counter">${title}</div>
					<div class="colum_calc_date">${counter[key][0]}</div>
					<div class="colum_calc_value">${counter[key][1]}</div>
				</div>`;
		count++;
	}
	return st;
}


let print_menu = ( menu ) => {
	var st = '';
	for(let i = 0; i < menu.length; i++)
		st += `	<li class="menu_childs1">
					<a id="${menu[i].id_a}" href="${menu[i].id_a}">${menu[i].name}</a>
				</li>`;
	return st;
}

let json_get_table = ( objTarget, cmd_arr ) => {
	$.ajax({dataType: 'json', type: 'get', url: 'ajax/filterValue/',  data: cmd_arr})
	 .done(( result ) => {
		if (result.success) {
			var data = result.data;
			objTarget.html( print_table( data ) );
            var navigationD = navigation( result.navigationData );
			objTarget.append( '<div class="navigator">' +  navigationD + '</div>' );
			// objTarget.append( result.navigator );
			history.pushState( null, null, create_cmd( '', cmd_arr ) );
		} else  alert( result.error );
	 })
	 .fail(() => alert( result.responseJSON.error ));
}

let json_get_t_calc = ( objTarget, cmd_arr ) => {
	$.ajax({dataType: 'json', type: 'get', url: 'ajax/calculation_counter/',  data: cmd_arr})
	 .done(( result ) => {
		if (result.success) {
			var data = result.data;
			objTarget.html( print_t_calc( result ) );
			objTarget.append( result.navigator );
			history.pushState( null, null, create_cmd( '', cmd_arr ) );
		} else  alert( result.error );
	 })
	 .fail((result) => alert( result.responseJSON.error ));
}

/**
 * Возвращает отформатированую таблицу всех пользователей.
 *
 * @param {object} user_all  массив объектов.
 * @return {string} st возвращает отформатированую таблицу всех пользователей.
 */
let print_table_user = ( user_all ) => {
	var count = 0, class_e;
	var st = `<div class="title_table_user">
				<div class="title_user">Пользователь</div>
				<div class="title_family">Фамилия</div>
				<div class="title_name">Имя</div>
			  </div>`;
	for (let key in user_all) {
		if (count % 2 != 0)  class_e = 'counter_str_odd'; else class_e = 'counter_str_even';
		st += `<div id="id_${user_all[key].id}" class="${class_e}"  title="Редактировать параметры пользователя">
				<div class="col_user">${user_all[key].users}</div>
				<div class="col_family">${user_all[key].family}</div>
				<div class="col_name">${user_all[key].name}</div>
			   </div>`;
		count++;

	}
	return st;
}

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
let print_add_record = ( {name_lot, name_substation, name_counter, date, time, value, id} ) => {
	var row_add = `
			<div class="col_lots">${name_lot}</div>
			<div class="col_substation">${name_substation}</div> 
			<div class="col_counts">${name_counter}</div> 
			<div class="col_date">${date} ${time}</div> 
			<div class="col_value">${value}</div> 
			<a id="${id}">Правка</a>	
			`;
	return row_add;
}

let json_get_user = ( objTarget ) => {
	$.ajax({dataType: 'json', type: 'get', url: 'ajax/getuser_all/'})
	 .done(( result ) => {
			var data = result.data;
			$( objTarget ).html( print_table_user( data ) );
			$( objTarget ).prepend( add_user_btn() );
	})
	.fail(( result, b, c ) => alert( result.responseJSON.error ));

	function add_user_btn() {
		let st = `	<div id="add_user_btn">
						<div class="btn-ico"><img src="img/web/add_user.png" width="32" height="32" alt="add_user"></div>
						<div class="btn-text">Добавить пользователя</div>
					</div>`;
		return st;
	}
}

let l_form_edit_value = ( {objLot, objSubstation, objCounter, objDate, objTime, objValEdit,
							 objId, url_substation, url_counter, param} ) => {
	$.ajax({dataType: 'json', type: 'post', url: 'ajax/loadform_value/', data: param })
	 .done((result) => {
		var data = result.data;
		var obj = {	objSubstation, 	objCounter, url_substation, url_counter	};
		objLot.find('[value="' + data.lot_id + '"]').prop("selected", true);
		get_substation(obj, data.lot_id, 2, data.sub_id, data.counter_id);
		objDate.val(data.date1);
		objTime.val(data.time1);
		objValEdit.val(data.value);
		objId.val(data.id);
	})
	.fail((result) => alert(result.error));
}

let l_form_edit_user = ( {objUser, objPassword, objConfirmPassword, objUserFamily, objUserName, objId, param } ) => {
	$.ajax({dataType: 'json', type: 'post', url: 'ajax/loadform_user/', data: param})
	 .done((result) => {
		var data = result.data;
		if( data == null) return;
		objUser.val(data.users);
		objPassword.val('');
		objConfirmPassword.val('');
		objUserFamily.val(data.family);
		objUserName.val(data.name);
		objId.val(data.id);
	})
	.fail(() => alert( result.responseJSON.error ));
}

let edit_form_actions = ( obj_form ) => {
	var form = obj_form.view.edit_form_submit;
	var workForm = obj_form.view.edit_form;
	var lot = obj_form.objLot.val();
	var substation = obj_form.objSubstation.val();
	var counts = obj_form.objCounter.val();
	var m_method = $(form).attr('method');
	var m_action = $(form).attr('action');
	var m_data = $(form).serialize(); // input1=value1&input2=value2..., только input=text
	m_data += `&lot=${lot}&substation=${substation}&counter=${counts}&actions=edit`;

	$.ajax({dataType: 'json', type: m_method, url: m_action, data: m_data})
	.done((result) => {
		if (result.success) {
			var data = result.data;
			workForm.dialog( "close" );
			json_get_table(obj_form.objTarget, obj_form.cmd);
		} else  alert( result.error );
	})
	.fail((result) => alert( result.responseJSON.error ));
}

let add_form_actions = ( {form, objLot, objSubstation, objCounter, objBtnOk, objBtnEdit, objListRec, btnPress, gl_add_counts, edit_arr} ) =>{
	var lot = objLot.val();
	var substation = objSubstation.val();
	var counts = objCounter.val();
	var m_method=$(form).attr('method');
	var m_action=$(form).attr('action');
	var m_data=$(form).serialize(); // input1=value1&input2=value2..., только input=text

	m_data += `&lot=${lot}&counter=${counts}&substation=${substation}`;
	if (btnPress.id == ADD_COUNTER_BTN_NAME)  m_data += '&actions=add';
	if (btnPress.id == EDIT_COUNTER_BTN_NAME) m_data += '&actions=edit';

	$.ajax({dataType: 'json', type: m_method, url: m_action, data: m_data })
	.done((result) => {
		if (result.success) {
			var data = result.data;
			gl_add_counts++;

			var row_edit = print_add_record( data );
			var row_add = `<li>${row_edit}</li>`;

			if (btnPress.id == ADD_COUNTER_BTN_NAME) ok_btn( data, row_add );
			if (btnPress.id == EDIT_COUNTER_BTN_NAME) edit_btn(data, row_edit );


		}
		else  alert( result.error );
	})
	.fail(( result ) => alert( result.responseJSON.error ));

	let ok_btn = ( data, row_add ) => {
			if (gl_add_counts <= 10) {
				edit_arr.unshift( data );
				objListRec.prepend( row_add );
			} else {
				edit_arr.unshift( data );
				edit_arr.pop();
				objListRec.find('li:last').remove();
				objListRec.prepend( row_add );
			}
	}
	let edit_btn = ( data, row_edit ) => {
			var index = find_arr_id( edit_arr, data.id );
			edit_arr[index] = data;
			objBtnOk.button("option", "disabled", false); // - блокировка элемента с id=ADD_COUNTER_BTN_NAME
			objBtnEdit.button("option", "disabled", true); // - разблокировка элемента с id=EDIT_COUNTER_BTN_NAME
			objListRec.find('li:nth-child(' + ( index + 1 ) + ')').html( row_edit );
	}

}

let user_form_actions = ( obj_form ) => {
	var form, workForm, actions;
	if ( obj_form.actionsCmd == ADD_USER_ACTIONS ) {
		form = obj_form.view.user_form_add_submit;
		workForm = obj_form.view.user_form_add;
		actions = '&actions=add';
	}
	if ( obj_form.actionsCmd == EDIT_USER_ACTIONS) {
		form = obj_form.view.user_form_edit_submit;
		workForm = obj_form.view.user_form_edit;
		actions = '&actions=edit';
	}
	var m_method = $(form).attr('method');
	var m_action = $(form).attr('action');
	var m_data = $(form).serialize(); // input1=value1&input2=value2..., только input=text
	m_data += actions;

	$.ajax({dataType: 'json', type: m_method, url: m_action, data: m_data })
	.done((result) => {
		if (result.success == true) {
			var data = result;
			workForm.dialog( "close" );
			json_get_user( obj_form.objTarget );
		} else  alert(result.error);
	})
	.fail((result) => alert( result.responseJSON.error ));
}

let unregistration = () => {
	$.ajax({dataType: 'json', type: 'post', url: 'ajax/unregistration/'} )
	.done((result) => {
			$.ajax({dataType: 'json', type: 'post', url: 'json/menu.json'} )
			.done((result_menu) => {
				var menu =  result_menu.menu;
				$('#menu').html( `<ul>${print_menu( menu )}</ul>` );
				$('#left').html( '' );
				$('#right').html( '' );
			})
			.fail(() => alert('Error'));
			alert(result.message);
	})
	.fail(() => alert('Error'));
}

let registration = ( form ) => {
	var m_method=$(form).attr('method');
	var m_action=$(form).attr('action');
	var m_data=$(form).serialize();

	$.ajax({ dataType: 'json', type: m_method, url: m_action, data: m_data })
	.done((result) => {
		$.ajax({ dataType: 'json', type: 'post', url: 'json/menu_registration.json' })
		 .done((result_menu) => {
			var menu =  result_menu.menu;
			var mainfile = `<ul>${print_menu( menu )}`;
			if (result.id != 0) mainfile += `<div class="user"><div class="title_user">Вы зашли как:</div>${result.name} ${result.family}</div>`;
			mainfile += '</ul>';
			$('#menu').html( mainfile );
		})
		.fail(( result ) => alert('Error'));

		$.ajax({ dataType: 'json', type: 'post', url: 'ajax/menuleft/' })
		.done((result_menu) => {
			var menu =  result_menu;
			$( '#left' ).html( `<div id="menu_left" class="left-box"><ol>${print_menu( menu )}</ol></div>` );
		})
		.fail(( result ) => {
			console.log(result);
			//alert(result.responseJSON.error);
		});
	})
	.fail(( result ) => alert(result.responseJSON.error));
}


let edit_privilege = () => {
	var m_data = { 'id_user': $('#edit_user_id').val() }
	$.ajax({ dataType: 'json', type: 'post', data: m_data, url: 'ajax/loadform_privelege/' })
	.done(( result_menu ) => {
			var menu_v =  result_menu;
			var mainfile = '<ol>';
			for( let i = 0; i < menu_v.length; i++ )
				mainfile += `<li>${menu_v[i].name}
								<input id="check_${menu_v[i].id_a}" class="privilege_checkbox" type="checkbox" ${menu_v[i].checked}/>
							</li>`;
			mainfile += '</ol>';
			$( '#user_form_privelege' ).html( mainfile );

	})
	.fail(( result ) => alert( result.error ));
}

let privilege_user_form_actions = ( obj_form ) => {
	var sList = '';
	var form = obj_form.view.user_form_privilege_submit;
	var workForm = obj_form.view.user_form_privilege;
	var m_method = $(form).attr('method'); //берем из формы метод передачи данных
	var m_action = $(form).attr('action'); //получаем адрес скрипта на сервере, куда нужно отправить форму

	var m_checkbox = form.find('input[type=checkbox]');	// запомнить !!!

	$(m_checkbox).each(function () {
		var sThisVal = (this.checked ? "1" : "0");
		sList += (sList=="" ? sThisVal : "," + sThisVal);
	});

	var m_data = {
		data: sList,
		id_user: $('#edit_user_id').val()
	};
	$.ajax({ dataType: 'json', type: m_method, url: m_action, data: m_data })
	.done((result) => {
	})
	.fail((result) => alert(result.error));
	workForm.dialog( "close" );
}

