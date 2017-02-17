<?php
$plugins->add_hook("index","top_add");

function top_info(){
return array( 
"name" => "اضافة الاكثر مشاهدة",
"author" => "محمد الجيلاني",
"author_site" => "http://alamera.ga",
"description" => " سيتم عرض الملفات الموجودة أعلى على موقع الويب الخاص بك",
);
}

function top_install(){
	global $db;
	// settings 
	$settings_data = array(
	"name" => "top_sort", // name of the setting must be unique so adding the plugin name is a good practice
	"value" => "dcount", // default value
	"title" => "فرز الملفات أكبر من:", // title will be displayed on settings page
	"description" => "سيتم فرز الملفات أكبر من هذه المعايير", // description
	"type" => "select \ndcount=Downloads Number \nviews=Views مشاهدات", // type check master-land.net for more info
	"plugin" => "top", // your plugin <name>
	);
	$settings_data2 = array(
	"name" => "top_number", 
	"value" => "20", 
	"title" => "لا توجد ملفات:", 
	"description" => "عدد الملفات ليتم عرضها، نضع في اعتبارنا هناك في ذلك الحدود الفاصلة للصفحات", 
	"type" => "text",
	"plugin" => "top", 
	);
	$settings_data3 = array(
	"name" => "top_sort_type", 
	"value" => "DESC", 
	"title" => "فرز الملفات:", 
	"description" => " يجب فرز الملفات <b>القديم اولا</b> or <b>الجديد اولا</b>", 
	"type" => "select \nASC=ASC \nDESC=DESC",
	"plugin" => "top", 
	);

	$db->insert_array(MAI_PREFIX."plugins_settings",$settings_data);
	$db->insert_array(MAI_PREFIX."plugins_settings",$settings_data2);
	$db->insert_array(MAI_PREFIX."plugins_settings",$settings_data3);


}

function top_is_installed(){
	global $db;
	if($db->count("SELECT `name` FROM `".MAI_PREFIX."plugins_settings` WHERE `plugin`='top'") > 0)
		return true;
	
	return false;
}

function top_uninstall(){
	global $db;
	$db->query("DELETE FROM `".MAI_PREFIX."plugins_settings` WHERE `plugin`='top'");
}

function top_add($value){
global $dir,$set;
// here you can edit the html code

if(!$dir)
$value .="<div class='content2'><a href='$set->url/top.php'><img src='$set->url/".MAI_TPL."style/images/gdir.gif' alt='.'/>&nbsp;الاكثر مشاهدة</a></div>";
return $value;
}
?>