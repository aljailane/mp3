<?php
include'inc/init.php';
$links[] = mai_img("arr.gif")." Ping SiteMap to Search Engines";

include "header.php";
// SiteMap URL
$sitemap_url = "$set->url/sitemap.xml";
// Search Engine URLs
$google="http://www.google.com/webmasters/sitemaps/ping?sitemap=";
$bing="http://www.bing.com/webmaster/ping.aspx?siteMap=";

 // Lets Ping Them!
$data=miraz_get_contents("$google$sitemap_url");
echo '<div class="title">Response From Google</div><div class="content">';
if($data){
echo '
<b>إشعار خريطة الموقع ورد</b><br/>
ملف خريطة الموقع المضاف بنجاح لدينا قائمة من ملفات Sitemap الزحف. إذا كانت هذه هي المرة الأولى لك هي إخطار Google حول هذا الموقع، الرجاء إضافته عن طريق<a href="http://www.google.com/webmasters/tools/">http://www.google.com/webmasters/tools/</a> لذا يمكنك تتبع حالتها. يرجى ملاحظة أن لا نضيف قدمت جميع عناوين Url للفهرس الخاص بنا، ونحن لا تجعل أي توقعات أو ضمانات حول عندما أو إذا كانوا سوف تظهر.</div>';
}
else{
echo'فشل جوجل بينغ!';
}
echo'</div>';
$data2=miraz_get_contents("$bing$sitemap_url");
echo'<div class="title">واستجابة من بنج</div><div class="content2">';
if($data2){
echo '
Thanks for submitting your Sitemap. Join the <a href="http://bing.com/webmaster">أدوات مشرفي المواقع بنج</a> لمشاهدة ملفات Sitemap الخاصة بك مركز وأكثر تقارير بشأن كيف كنت تفعل في بنج.</div>';
}
else{
echo'فشل بنج Ping!';
}
echo'</div>';
include "footer.php";
?>