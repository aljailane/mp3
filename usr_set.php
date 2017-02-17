<?php
/*
Project Name: Next Auto Index
Project URI: http://wapindex.mirazmac.info
Project Version: 1.0
Licence: GPL v3
*/
## This is a modified version of Master Autoindex. So all source rights goes to ionutvmi ##
include "inc/init.php";
$plugins->run_hook("usr_set_top");

$links[] = mai_img("arr.gif")." $lang->settings ";

if($_POST['items']){
	$_SESSION['perp'] = (int)$_POST['items'];
	$form .= "<div class='green'>$lang->saved </div>";
}

$form .= "<form action='?' method='post'>

	$lang->elements_per_page: 
	<select name='items'>";
	$items = range(5,50,5);
	foreach($items as $item){
		if($_SESSION['perp'] == $item)
			$form .= "<option value='$item' selected='1'>$item</option>";
		else
			$form .= "<option value='$item'>$item</option>";
	}
$form .="	</select>


<br/>
<input type='submit' value='$lang->save'>
</form>";


include "header.php";
$tpl->grab("usr_set.tpl","usr_set");
$tpl->assign("form",$form);
$tpl->display();

$plugins->run_hook("usr_set_end");
include "footer.php";