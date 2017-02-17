<?php
/*
Project Name: Next Auto Index
Project URI: http://wapindex.mirazmac.info
Project Version: 1.0
Licence: GPL v3
*/
## This is a modified version of Master Autoindex. So all source rights goes to ionutvmi ##
@set_time_limit(0);

include "../inc/init.php";

if(!is_admin()) {
	header("Location: $set->url");exit;
}

$links[] = mai_img("arr.gif")." <a href='index.php'>$lang->admincp </a>";
$links[] = mai_img("arr.gif")." Mass File Renamer ";


$content .= "<div class='title'>Mass File Renamer</div>
<div class='content'>";

if($_POST){

$content .= "<div class='green'>".frename($_POST['path'])."</div>";

}

$content .= "<form action='#' method='post'>
Folder: <br/><select name='path'><option value=''>./</option>";
$all_folders = $db->select("SELECT `path` FROM `". MAI_PREFIX ."files` WHERE `size` = '0'");

foreach($all_folders as $folder){
    $folder = substr($folder->path,6); // remove /files

    $content .= "<option value='$folder'>$folder</option>";
}
$content .="</select><br/>
Select Rule:<br/> <input type='text' name='rule' value='*.png'><br/>
Replace:<br/>
<input type='text' name='r' value=''>=><input type='text' name='w' value=''><br/>
Prefix:<br/> <input type='text' name='prefix' value=''><br/>
Sufix(it will be added before the file extension):<br/> <input type='text' name='sname' value='$set->name'>
<br/><br/>

<input type='submit' value='Rename'>
</form><br/>
<small> Use this carefully !</small></div>";


include "../header.php";

echo $content;

include "../footer.php";

function frename($path){
	global $db;
	$files = glob("../files".$path."/".$_POST['rule']);
	foreach($files as $file){
		if(is_file($file)){
		$info = (object)pathinfo($file);
		$new_name = $_POST['prefix'].str_replace($_POST['r'],$_POST['w'],basename($file,".".$info->extension)).$_POST['sname'].".".$info->extension;
		$new_path = dirname($file)."/".$new_name;
		rename($file,$new_path);
		$db->query("UPDATE `".MAI_PREFIX."files` SET `path`='".substr($new_path,2)."', `name`= '$new_name' WHERE `path`='".substr($file,2)."'");
		$zzz .= $new_name." SAVED ! <br/>";
		}
	}
	return $zzz;
}