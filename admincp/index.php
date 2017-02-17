<?php

## This is a modified version of Master Autoindex. So all source rights goes to ionutvmi ##
include "../inc/init.php";
$plugins->run_hook("admin_top");

$links[] = mai_img("arr.gif")." $lang->admincp";



if(((sha1($_POST['pass']) == $set->sinfo->admin_pass) && ($_POST['token'] == $_SESSION['token'])) OR is_admin()) {
	$_SESSION['token'] = '';
    
    if($_POST['r'] == 1) {
        $path_info = parse_url($set->url);
        setcookie("pass", sha1($_POST['pass']), time() + 3600 * 24 * 30, $path_info['path']); // 30 days
    }
    
	if(!$_SESSION['adminpass']){
		$_SESSION['adminpass'] = sha1($_POST['pass']);
			}
	$request_new = "(".$db->count("SELECT `id` FROM `".MAI_PREFIX."request` WHERE `reply`=''").")";
    
    include "../header.php";	
	$version = $set->version;
		$chk_v = miraz_get_contents("http://regup.ga/update_file/v.txt","0");	
	if($chk_v > $version){
		$update_av = "<div style='background: rgba(255, 239, 207, 1);padding: 6px 8px;text-align: center;margin: 5px;border: 1px solid rgba(255, 196, 94, 1);'><a style='color:red' href='http://regup.ga/'>
لديك تحديث جديد ($chk_v) نرجو التحديث فورا ويجب عليك دائما تحديث نسختگ
</a></div>";}

	$tpl->grab('admin_options.tpl','admin_options');
	$tpl->assign('password',$lang->password);
	$tpl->assign('url',$set->url);
	$tpl->assign('import_files',$lang->import_files);
	$tpl->assign('settings',$lang->settings);
	$tpl->assign('update_av',$update_av);
	$tpl->assign('login',$lang->login);
	$tpl->assign('request',$lang->request);
	$tpl->assign('request_new',$request_new);
	$tpl->assign('file_manager',$lang->file_manager);
	$tpl->assign('plugin_manager',$lang->plugin_manager);
	//New addition
	$tpl->assign('update_av',$update_av);
	$tpl->assign('scan_folders',$lang->scan_folders);
	$tpl->assign('mass_frn',$lang->mass_frn);
	$tpl->assign('tpl_editor',$lang->tpl_editor);
	$tpl->assign('plugins_market',$lang->plugins_market);
	$tpl->assign('upload_files',$lang->upload_files);
	$tpl->assign('mark',mai_img('arr.gif'));
	$tpl->assign('version',$set->version);
}else{
	$token = $_SESSION['token'] = md5(rand());
    
    include "../header.php";	
    $tpl->grab('admin_pass.tpl','admin_pass');
	$tpl->assign('password',$lang->password);
	$tpl->assign('token',$token);
	$tpl->assign('login',$lang->login);
	$tpl->assign('remember', $lang->remember);

}	
	$tpl->display();
$plugins->run_hook("admin_end");
include "../footer.php";

?>