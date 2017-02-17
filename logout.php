<?php
/*
Project Name: Next Auto Index
Project URI: http://wapindex.mirazmac.info
Project Version: 3.0
Licence: GPL v3
*/
## This is a modified version of Master Autoindex. So all source rights goes to ionutvmi ##
include "inc/settings.php";
session_start();
session_unset("adminpass");
$path_info = parse_url($set->url);
setcookie("pass", 0, time() - 3600 * 24 * 30, $path_info['path']); // delete

header("Location: ".$_SERVER["HTTP_REFERER"]);