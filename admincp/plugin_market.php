<?php
/*
Project Name: Next Auto Index
Project URI: http://wapindex.mirazmac.info
Project Version: 3.0
Licence: GPL v3
*/
## This is a modified version of Master Autoindex. So all source rights goes to ionutvmi ##

// for now a good old fashion grabber needs to be improved but time....



include "../inc/init.php";


$plugins->run_hook("plugin_market_top");

if(!is_admin()) {
	ob_end_clean();
	header("Location: $set->url");exit;
}

$links[] = mai_img("arr.gif")." <a href='index.php'>$lang->admincp </a>";
$links[] = mai_img("arr.gif")." <a href='?'>$lang->plugins_market</a>";


$act = $_GET['act'];

if(($act == 'install') && ($p_name = trim($_GET['p']))) {
    
    $tmp_name = "plugin".rand().".zip";
    $gu="aHR0cDovL21pcmF6bWFjLmluZm8vbWFya2V0L3BsdWdpbnMv";
	$_gu=base64_decode($gu);
    if(copy("$_gu".$p_name, $tmp_name)) {
        
        $zip = new ZipArchive;
        
     
        
        if ($zip->open($tmp_name) === true) {

            for($i = 0; $i < $zip->numFiles; $i++) { // we try (and hopefully succeed) to put the files in the correct folders

                    $filename = $zip->getNameIndex($i);
                    
                    $new_name = $filename;
                    
                    if(strpos($filename, "autoindex/") === 0)
                        $new_name = str_ireplace("autoindex/","", $filename);
                    
                    
                    if(trim($new_name) == '')
                        continue;
                    
                    $info = $zip->statIndex($i);
                    if($info['crc'] == 0) { // is dir
                        
                        if(!is_dir(MAI_ROOT.$new_name))
                            @mkdir(MAI_ROOT.$new_name,0777,true);
                            
                        continue;
                    }
                    
                    if(substr($filename, -11) == "_plugin.php") {
                       
                        copy("zip://".dirname(__FILE__)."/".$tmp_name."#".$filename, MAI_ROOT."plugins/".basename($filename));
                        continue;
                    }
                    
                    copy("zip://".dirname(__FILE__)."/".$tmp_name."#".$filename, MAI_ROOT.$new_name);

                }

            $zip->close();
        }
        
        $content .="<div class='green'>Plugin installed sucessfully! Please go to <a href='$set->url/admincp/plugin_manager.php'>Plugin Manager</a> to activate it.</div>";
    } else
        $content .="<div class='red'>Plugin Installation Failed! Please try again.</div>";
    
    @unlink($tmp_name);
} else {
    $id=$_GET['id'];
    $plugin=$_GET['plugin'];
    if($_GET['plugin'] == ''){
	$cu="aHR0cDovL21pcmF6bWFjLmluZm8vbWFya2V0L21hcmtldC5waHA=";
	$_cu=base64_decode($cu);
    $data = miraz_get_contents("$_cu?".$_SERVER['QUERY_STRING'],"0");}
	else{
	$eu="aHR0cDovL3dhcGluZGV4Lm1pcmF6bWFjLmluZm8vZmlsZS5waHA=";
	$_eu=base64_decode($eu);
	$data = miraz_get_contents('$_eu?id='.$id.'&plugin='.$plugin.'','0');}
    
    $data = preg_replace("#<!DOCTYPE(.+)<!--header end-->#iUs", "", $data);
    $data = preg_replace("#<!--footer start-->(.+)</html>#iUs", "", $data);
    $data = preg_replace('|href="file.php|is', 'href="plugin_market.php', $data);
    $data = preg_replace("~<div class='content'><form action='#' method='post'>(.+)</div>~iUs", "", $data, 1);
    $data = preg_replace('|<a href="data/user1/(.+)">|is', '<a href="?act=install&p=$1">', $data, 1);
    
    
    
    
    $content = "<div class='title'>Plugins Market</div>".$data. "<div class='title'>Extra</div><div class='content'>&#187; <a href='http://mirazmac.info/market/submit.php'>Submit your plugin</a> (<b style=\"color:green\">Active!</b>)</div>
	<div class='content2'>&#187; <a href='http://sourceforge.net/p/next-auto-index/wiki/Next%20AutoIndex%20Plugins%20Documentation/'>Plugin Documentation</a></div>";
}


include "../header.php";
$plugins->run_hook("plugin_market");
echo $content;
$plugins->run_hook("plugin_market_end");
include "../footer.php";