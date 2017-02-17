<?php
# Plugin name: Updates Plugin Reloaded
# Author: MiraZ Mac
# Author URI: http://mirazmac.info
# Description: With this plugin you can edit the format of latest update. Not only that also you can set how many files you want to show and will be able to add a header. Major sources are taken from ionutvmi's update plugin.
# License: GPL v3

/******************************** 
========== !Note! =============
Uninstall and delete all old update plugin(!)
Major sources are taken from ionutvmi's update plugin.
=========
You are not allowed to modify this
plugin. If you do so you may not
receive future plugin updates.
******************************** 
*/


/*== Bismillah! ==*/

//The hook
$plugins->add_hook("index_search","updates_edit");

// The info
function updates_info(){
    return    array(    
    "name" => "تحديثات البرنامج المساعد حصرياً",
    "author" => "محمد الجيلاني",
    "author_site" => "http://alamera.ga",
    "description" => "<b style='color:blue'>منذ يتم إضافة فهرس السيارات القادمة 3.2 تحديث إدارة ولكن إذا كنت لا تزال تريد استخدام النوع القديم من التحديثات ثم استخدام هذا البرنامج المساعد. ومع ذلك نحن نوصي باستخدام تحديث مدير.</b><br/>
	مع هذا البرنامج المساعد يمكنك تحرير شكل آخر تحديث. ليس فقط أنه يمكنك أيضا تعيين عدد الملفات تريد إظهار وسيكون قادراً على إضافة رأس. المصادر الرئيسية هي مأخوذة من تحديث البرنامج المساعد إيونوتفمي.<br/><span style='color:red'>إلغاء وحذف كافة القديمة التحديث الاضافات
</span><br/><a href='http://alamera.ga'>قم بزيارة الصفحة الرئيسية للبرنامج المساعد</a> - <a href='http://facebook.com/darhost56'><span style='color:red'>تقرير الأخطاء</span></a>",
    );
}
// After Install
function updates_install(){
	global $db;
	// settings 
	$settings_data = array(
	"name" => "updates_tpl", 
	"value" => $db->escape("<a href='\$link'>\$file.name</a> was added on \$date[\" h:i:s A | Y/m/d l\"] <br/>"), 
	"title" => "Template", 
	"description" => "The template text for updates on main page. <br/> Vars: <b>\$link , \$tsince , \$size 
	<br/> \$file.name/id/path/indir/views/dcount/time/size/icon <br/>\$dir.name/id/path/indir/views/dcount/time/size/icon </b>", 
	"type" => "textarea",
	"plugin" => "updates", 
	);
		$settings_data2 = array(
	"name" => "updates_text", 
	"value" => $db->escape("<div class='title'>آخر تحديثات</div>"), 
	"title" => "آخر تحديث النص", 
	"description" => "القالب الخاص بأحدث تحديث العنوان", 
	"type" => "textarea",
	"plugin" => "updates", 
	);
		$settings_data3 = array(
	"name" => "updates_count", 
	"value" => "8", 
	"title" => "Updates Content Count", 
	"description" => "Count of files you want to show in latest updates<br/><small>Recommended: 10</small>", 
	"type" => "text",
	"plugin" => "updates", 
	);
	$db->insert_array(MAI_PREFIX."plugins_settings",$settings_data);
	$db->insert_array(MAI_PREFIX."plugins_settings",$settings_data2);
	$db->insert_array(MAI_PREFIX."plugins_settings",$settings_data3);
}
function updates_is_installed(){
	global $db;
	if($db->count("SELECT `name` FROM `".MAI_PREFIX."plugins_settings` WHERE `plugin`='updates'") > 0)
		return true;
	
	return false;
}
//After Uninstall
function updates_uninstall(){
	global $db;
	$db->query("DELETE FROM `".MAI_PREFIX."plugins_settings` WHERE `plugin`='updates'");
}
//The main function - credit goes to ionutvmi
function updates_edit(){
	global $up_data,$set,$lang,$updates,$db;
	
	if($up_data){
	$count=preg_replace("|[^0-9]|is","",$set->plugins["updates_count"]); //Removing everything but numbers
	$up_data = $db->select("SELECT * FROM `". MAI_PREFIX ."files` WHERE size > 0 ORDER BY `id` DESC LIMIT 0,$count"); //The Query
	$utext=$set->plugins["updates_text"];
	$updates = "$utext"; //The Updates Header
		foreach($up_data as $udata){
			$tpl_text = $set->plugins["updates_tpl"];
			$link = "$set->url/data/file/$udata->id/d.html";
			$tsince = tsince($udata->time,$lang->time_v);
			$size = convert($udata->size);

			foreach($udata as $k=>$v)
				$tpl_text = str_replace("\$file.$k",$v,$tpl_text);
			
			if($dir = $db->get_row("SELECT * FROM `".MAI_PREFIX."files` WHERE `id`='$udata->indir'"))
				foreach($dir as $k=>$v)
					$tpl_text = str_replace("\$dir.$k",$v,$tpl_text);
			
			$tpl_text = preg_replace("~\\\$([a-zA-Z]+)\.([a-zA-Z]{1,10}+)~iUs","",$tpl_text);			
			$tpl_text = preg_replace("~\\\$date\[\"([^\"]+)\"\]~iUse",'date("$1",'.$udata->time.')',$tpl_text);
			$tpl_text = str_replace(array("\$link","\$tsince","\$size"),array($link,$tsince,$size),$tpl_text);
			$updates .= $tpl_text;
			
		}
	}
}

