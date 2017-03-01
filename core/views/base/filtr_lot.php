<div  class="left-box">
	<div class="title_filtred">Фильтры</div>
	<div class="f_input_filtred">
		<label for="lot_en" class="filtred_label">Участок</label>
	</div>

	<select id="lot" class="filtred_selected">
	<?php
        \Pdo\Lots::lotsFilter()->render();
	?>
	</select>

	<div class="f_input_filtred">
		<label for="sub_en" class="filtred_label">Подстанция</label>
	</div>
	<select id="substation" class="filtred_selected" disabled="disabled"></select>

	<div class="f_input_filtred">
		<label for="counter_en" class="filtred_label">Ячейка</label>
	</div>
	<select id="counter" class="filtred_selected" disabled="disabled"></select>
</div>
<div class="f_input">
	<input id="dt1_en" class="filtred_checkbox" type="checkbox"/>
	<label for="dt1_en" class="filtred_label">Дата начало</label>
</div>
<div id="dt1" ></div>

<div class="f_input">
	<input id="dt2_en" class="filtred_checkbox" type="checkbox"/>
	<label for="dt2_en" class="filtred_label">Дата конец</label>
</div>
<div id="dt2" ></div>


