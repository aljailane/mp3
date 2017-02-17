<?php
/*
Project Name: Next Auto Index
Project URI: http://wapindex.mirazmac.info
Project Version: 1.0
Licence: GPL v3
*/
## This is a modified version of Master Autoindex. So all source rights goes to ionutvmi ##

include "inc/init.php";

$links[] = mai_img("arr.gif")." $lang->TOS";
include "header.php";

echo "<div class='title'>$lang->terms_of_service</div><div class='content'>".nl2br("نرجو عند النقل ذكر المصدر وشكرا لك")."</div>";

include "footer.php";