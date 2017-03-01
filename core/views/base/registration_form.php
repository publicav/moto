  <div id="user_div_add" style="display:none;">
    <form id="user_form_add" name="user_form_add" method="post" action="ajax/actionform_user_add/">
	  <div class="p_input">	
      <div class="label_user_add_form"><label for="user_add">Логин:</label></div>
      <input type="text" name="user_add" id="user_add" class="input_user_add_form" tabindex="1">
	  </div>
      <div class="p_input">
      <div class="label_user_add_form"><label for="pass_add">Пароль:</label></div>
      <input type="password" name="pass_add" id="pass_add" class="input_user_add_form" tabindex="2">
	  </div>
      <div class="p_input">
      <div class="label_user_add_form"><label for="pass_repeat_add">Повторить пароль:</label></div>
      <input type="password" name="pass_repeat_add" id="pass_repeat_add" class="input_user_add_form" tabindex="3">
	  </div>
      <div class="p_input">
      <div class="label_user_add_form"><label for="family_add">Фамилия пользователя:</label></div>
      <input type="text" name="family_add" id="family_add" class="input_user_add_form" tabindex="4">
	  </div>
      <div class="p_input">
      <div class="label_user_add_form"><label for="name_add">Имя пользователя:</label></div>
      <input type="text" name="name_add" id="name_add" class="input_user_add_form" tabindex="4">
	  </div>

      <input id="ok_f"  type="submit"  tabindex="-1" style="position:absolute; top:-1000px">

    </form>
  </div>

  <div id="user_div_edit" style="display:none;">
    <form id="user_form_edit" name="user_form_edit" method="post" action="ajax/actionform_user/">
	  <input id="edit_user_id"  type="hidden"  name="edit_user_id"/>
	  <div class="p_input">	
      <div class="label_user_add_form"><label for="user_edit">Логин:</label></div>
      <input type="text" name="user_edit" id="user_edit" class="input_user_add_form" tabindex="1">
	  </div>
      <div class="p_input">
      <div class="label_user_add_form"><label for="pass_edit">Пароль:</label></div>
      <input type="password" name="pass_edit" id="pass_edit" class="input_user_add_form" tabindex="2">
	  </div>
      <div class="p_input">
      <div class="label_user_add_form"><label for="pass_repeat_edit">Повторить пароль:</label></div>
      <input type="password" name="pass_repeat_edit" id="pass_repeat_edit" class="input_user_add_form" tabindex="3">
	  </div>
      <div class="p_input">
      <div class="label_user_add_form"><label for="family_edit">Фамилия пользователя:</label></div>
      <input type="text" name="family_edit" id="family_edit" class="input_user_add_form" tabindex="4">
	  </div>
      <div class="p_input">
      <div class="label_user_add_form"><label for="name_edit">Имя пользователя:</label></div>
      <input type="text" name="name_edit" id="name_edit" class="input_user_add_form" tabindex="4">
	  </div>

      <input id="ok_f1"  type="submit"  tabindex="-1" style="position:absolute; top:-1000px">

    </form>
  </div>

  <div id="user_div_privelege" style="display:none;">
	<form id="user_form_privelege" name="user_form_privelege" method="post" action="ajax/actionform_privelege/">
	</form>
  </div>
  