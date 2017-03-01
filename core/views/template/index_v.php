<div id=wrap>
<?php
// include("base/top.php");
// include("base/left.php");
?>
<div id="top"> 
</div>
<div id="menu"> 
<?php 	include(__DIR__ . "/../base/menu.php"); ?>
</div>
<?php 	include(__DIR__ . "/../base/login_form.php"); // loginform ?>

<div id="left">
        <?php  if ( !is_null ($this->_auth) )	include(__DIR__ . "/../base/menu_left.php"); ?>
</div>

<div id="right"> 
</div>


<div id="test"></div>
<?php
//  include_once('base/footer.php');
?>

</div>
