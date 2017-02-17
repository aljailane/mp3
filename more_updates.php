<?php
include('inc/init.php');
include('lib/pagination.class.php');

$total_results = $db->count("SELECT `id` FROM `". MAI_PREFIX ."updates`");
if($total_results > 0) {
$updates="<div class='title'>المزيد من التحديثات</div>";
	// pagination
	$perpage = 10;
	$page = (int)$_GET['page'] == 0 ? 1 : (int)$_GET['page'];
	if($page > ceil($total_results/$perpage)) $page = ceil($total_results/$perpage);
	$start = ($page-1)*$perpage;

$links[] = mai_img("arr.gif")." مزيد من التحديثات / صفحة: $page";
	$s_pages = new pag($total_results,$page,$perpage);

	$show_pages = $lang->pages.": ".$s_pages->pages;
	$show_pages=str_replace('?page=',''.$set->url.'/updates/',$show_pages);
	$show_pages=str_replace("'>",".html'>",$show_pages);
$data = $db->select("SELECT * FROM `". MAI_PREFIX ."updates` ORDER BY time DESC LIMIT $start,$perpage");
foreach($data as $d){
$updates .="<div class='update_l'>$d->text
</div>";
}
}
include "header.php";
$tpl->grab('updates.tpl','updates');
$tpl->assign('MAI_TPL',$set->url."/".MAI_TPL);
$tpl->assign('url',$set->url);
$tpl->assign('updates',$updates);
$tpl->assign('show_pages',$show_pages);
$tpl->display();

include "footer.php";
?>