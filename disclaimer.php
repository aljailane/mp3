<?php
/*
Project Name: Next Auto Index
Project URI: http://wapindex.mirazmac.info
Project Version: 1.0
Licence: GPL v3
*/
## This is a modified version of Master Autoindex. So all source rights goes to ionutvmi ##

include "inc/init.php";

$links[] = mai_img("arr.gif")." اخلاء المسئولية";
include "header.php";

echo "<div class='title'>إخلاء مسؤولية</div><div class='content'><img src='$set->url/tpl/style/images/gdir.gif'/>&nbsp; الرجاء قراءة إخلاء المسؤولية قبل تحميل أي شيء من $set->name</div>
<div class='content2'><img src='$set->url/tpl/style/images/gdir.gif'/>&nbsp; $set->name هو موقع مفتوح المصدر اذا لديك اي شكوى عن اي محتو ى منشور يمكنك مراسلتنا لنقوم بازالتة
<br> darhost56@gmail.com
</div>";

include "footer.php";