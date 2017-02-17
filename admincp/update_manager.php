<?php

include "../inc/init.php";
include ''.MAI_ROOT.'lib/pagination.class.php';

if(!is_admin()) {
    header("Location: $set->url");exit;
}

$links[] = mai_img("arr.gif")." <a href='index.php'>$lang->admincp </a>";
$links[] = mai_img("arr.gif")." مدير التحديثات";
$act=$_GET['act'];

include "../header.php";

echo '<div class="title">مدير التحديثات</div><div class="content"><form method="POST" action="update_manager.php?act=add">
<textarea name="u_text"></textarea>
<br/>
<input type="submit" value="اضافة"/>
</form>
</div>';
$msg='';
switch($act){
case 'del':
if($_GET['id']){

$id = (int)$_GET['id'];

$update = $db->get_row("SELECT * FROM `". MAI_PREFIX ."updates` WHERE `id`='$id'");
if(!$update) {
$msg .='<div class="red">غير قادر على حذف التحديث. كما أنها موجودة!</div>';
}
else{
$msg .='<div class="green">لقد تم حذف التحديث!</div>';
$db->query("DELETE FROM ". MAI_PREFIX ."updates WHERE `id` = '$id'");
}
}
break;
case 'add':
if($_POST['u_text']){
$u_text=$_POST['u_text'];
$add = array(
            "text" => $db->escape($u_text),
			"time" => time()
            );
 $db->insert_array(MAI_PREFIX."updates",$add);
 $msg .='<div class="green">تم اضافة التحديث بنجاح </div>';
 }
 else{
 
 }
break;
}
echo $msg;
$total_results = $db->count("SELECT `id` FROM `". MAI_PREFIX ."updates`");
if($total_results > 0) {

	// pagination
	$perpage = 10;
	$page = (int)$_GET['page'] == 0 ? 1 : (int)$_GET['page'];
	if($page > ceil($total_results/$perpage)) $page = ceil($total_results/$perpage);
	$start = ($page-1)*$perpage;

	$s_pages = new pag($total_results,$page,$perpage);

	$show_pages = $lang->pages.": ".$s_pages->pages;
$data = $db->select("SELECT * FROM `". MAI_PREFIX ."updates` ORDER BY id DESC LIMIT $start,$perpage");
foreach($data as $d){
echo"<div class='content".(++$j%2==0 ? "2" : "")."'>منذو: <b>".ago($d->time)."</b></br/>".htmlspecialchars($d->text)."<br/>
<a href='$set->url/admincp/edit_update.php?id=$d->id'><b>[تعديل]</b></a> - <a href='$set->url/admincp/update_manager.php?act=del&id=$d->id'><b>[<font color='red'>حذف</font>]</b></a><br/>
</div>";
}
echo '<div class="pages">'.$show_pages.'</div>';
}
include "../footer.php";

?>