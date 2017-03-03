<div id=wrap>
<?php
// include("base/top.php");
// include("base/left.php");
?>
<div id="top"> 
</div>
<div id="menu"> 
<?php 	
	include(__DIR__ . "/../base/menu.php"); 
	?>
</div>
<?php 
	// include(__DIR__ . "/../base/login_form.php"); // loginform 
?>

<div id="left">
			<?php if ( !is_null ($this->_auth) )	
					include(__DIR__ . "/../base/menu_left.php"); 
				?>
</div>

<div id="right"> 
	<div id="help1">
		<p>Для работы с программой нужно установить ниже представленные браузеры.</p>
		<p><b>x32</b></p>
		<p><a href="prog/MozillaFirefox32OfflineInstaller.exe" title="Mozila Firefox">Mozilla Firefox</a></p>
		<p><a href="prog/GoogleChrome32OfflineInstaller.exe" title="Google Chrome">Google Chrome</a></p>
		<p><a href="prog/OperaOfflineInstaller.exe" title="Opera">Opera</a></p>

		<p><b>x64</b></p>
		<p><a href="prog/MozillaFirefox64OfflineInstaller.exe" title="Mozila Firefox">Mozilla Firefox x64</a></p>
		<p><a href="prog/GoogleChrome64OfflineInstaller.exe" title="Google Chrome">Google Chrome x64</a></p>
	<div>
	<div id="product">Движение электродвигатей  2017-<?=date('Y')?>  ver. 1.00 </div>
</div>


<div id="test"></div>
<?php
//  include_once('base/footer.php');
?>

</div>
