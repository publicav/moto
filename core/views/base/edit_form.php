<div id="edit_counter" style="display:none;">
    <form id="edit_value_counts_form" name="add_value_form" method="post" action="ajax/actionform_value/">     
		<input id="edit_id1"  type="hidden"  name="edit_id"/>
		<div class="p_input"><div class="label_p"><label for="lot_edit">Участок</label></div><?php include_once("core/views/base/lot_edit.php"); ?></div>
		<div class="p_input"><div class="label_p"><label for="substation_edit">Подстанция</label></div><select id="substation_edit" class="input_selected"></select></div>
		<div class="p_input"><div class="label_p"><label for="counter_edit">Ячейка</label></div><select id="counter_edit" class="input_selected"></select></div>
        
		<div class="p_input"><div class="label_p"><label for="path_name"> Время замера</label></div><input type="text"  class="input_date_b" id="date_airing_begin_edit"  name="date_begin" value="<?php echo  date("d-m-Y");;?>"/><input   class="input_time_b" id="time_airing_begin_edit" type="text" name="time_begin"/></div>
        <div class="p_input"><div class="label_p"><label for="counter_val">Значение счётчика</label></div><input id="counter_val_edit"  type="" class="input_form" name="counter_val"/></div>        
		<input id="ok_f"  type="submit"  tabindex="-1" style="position:absolute; top:-1000px">
	</form>
</div>