<?php
// Master Autoindex
// ionutvmi@gmail.com 
// Sep 2012
// master-land.net
include "inc/init.php";
include "lib/pagination.class.php";



$links[] = mai_img("arr.gif")." الاكثر مشاهدة ";

include "header.php";


$where_text = "size != '0'";


$total_results = $db->count("SELECT `id` FROM `". MAI_PREFIX ."files` WHERE $where_text");
if($total_results > 0) {


	$data = $db->select("SELECT * FROM `". MAI_PREFIX ."files` WHERE $where_text ORDER BY `".$set->plugins["top_sort"]."` ".$set->plugins["top_sort_type"]." LIMIT 0,".$set->plugins["top_number"]);


	foreach($data as $d){
		if($d->time > (time()-60*60*24)) 
			$new_text = "<span class='new'>($lang->new)</span>";
		else
			$new_text = '';

			$files .= "<div class='content".(++$i%2==0 ? "2" : "")."'>
			<a href='$set->url/data/file/$d->id/dawn.html'><table><tr><td>";
			
			// icon
			if($d->icon == '') {
				$ext = (object)pathinfo($d->path);
				$ext->extension = strtolower($ext->extension);
				
				if(in_array($ext->extension,array('png','jpg','jpeg','gif','jar'))) {
					if($ext->extension == 'jar') 
						$icon = "/icon.php?s=".base64_encode($d->path);
					else
						$icon = "/thumb.php?w=45&src=".base64_encode($d->path);
				}else{
					$all_icons = str_replace(".png","",array_map("basename",glob(MAI_TPL."style/png/*.png")));
					if(!in_array($ext->extension,$all_icons))
						$icon = "/". MAI_TPL ."style/png/file.png";
					else	
						$icon = "/". MAI_TPL ."style/png/$ext->extension.png";
				}
			} else {
				$icon = "/thumb.php?ext&w=45&src=".urlencode($d->icon);
			}
			
		
			$files .= "<img src='$set->url".$icon."' width='45'>";
			$files .= "</td><td>".$d->name." $new_text<br/>".convert($d->size)." </td></tr></table></a></div>";
			
	
	}
} else {
	$files = $lang->no_data;
}

echo'<div class="title">ملفات نشطة</div>';

echo $files;

include "footer.php";