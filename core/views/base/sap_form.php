<div id="sapmodal" style="display:none;">

    <form id="sapform" name="sapform" method="post" action="ajax/actionform_sap/">
        <fieldset class="fieldset_default">
            <input id="sap_id" type="hidden" name="sap_id"/>
            <div class="p_input">
                <div class="label_p"><label for="norrder">Номер заказа</label></div>
                <input id="norrder" type="text" class="input_form_centr" name="norrder" disabled="disabled"/>

                <div class="label_p"><label for="inv_num">Инвентарный номер</label></div>
                <input id="inv_num" type="text" class="input_form_centr" name="inv_num" disabled="disabled"/>

                <div class="label_p"><label for="dt1">Дата заказа</label></div>
                <input id="dt1" type="text" class="input_form_centr" name="dt1" disabled="disabled"/>

                <div class="label_p"><label for="position">Место</label></div>
                <input id="position" type="text" class="input_form_centr" name="position" disabled="disabled"/>

                <div class="label_p"><label for="descrform">Описание</label></div>
                <input id="descrform" type="text" class="input_form_centr" name="descrform" disabled="disabled"/>

            </div>
            <div class="p_input">
                <div class="label_p"><label for="nsup">Номер САП</label></div>
                <input id="nsup" type="number" class="input_form_centr" name="nsup"/>
            </div>
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </fieldset>
    </form>
</div>
