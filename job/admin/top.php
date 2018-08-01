<?
// формируем тайтлы и альтернативную навигацию
$site_nav_title="";
$site_nav_alt="";
for($i=0;$i<count($site_nav);$i++)
{
	$site_nav_title.=$site_nav[$i]["name"];
	if($i!==count($site_nav)-1) $site_nav_title.=" $site_separator ";

	if($i!==count($site_nav)-1)
		$site_nav_alt.="<a href=\"".$site_nav[$i]["url"]."\" class=\"menu\">".$site_nav[$i]["name"]."</a> $site_separator ";
	else
		$site_nav_alt.=$site_nav[$i]["name"];
}
?>
<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title> <?=$site_nav_title; ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta name="Author" content="RusCable.Ru">
<link rel="stylesheet" href="/<?=$document_admin;?>/style.css" type="text/css">
<script language="JavaScript">
<!--
// запрашивает подтверждение на переход по ссылке
function confirmLink(theLink, Query){
var is_confirmed = confirm(Query);
if (is_confirmed) {
	theLink.href += '&confirmed=yes';
}
return is_confirmed;
}

//-->
</script>

<script language="Javascript1.2"><!-- // load htmlarea
_editor_url = "/<?=$document_admin;?>/editor/";                     // URL to htmlarea files
var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);
if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
if (win_ie_ver >= 5.5) {
 document.write('<scr' + 'ipt src="' +_editor_url+ 'editor.js"');
 document.write(' language="Javascript1.2"></scr' + 'ipt>');  
} else { document.write('<scr'+'ipt>function editor_generate() { return false; }</scr'+'ipt>'); }

var config = new Object();    // create new config object

config.width = "100%";
config.height = "400px";
config.bodyStyle = 'background-color: #F6F5F8; color:#000000; font-family: "Verdana"; font-size: x-small;';
config.debug = 0;

// NOTE:  You can remove any of these blocks and use the default config!

config.toolbar = [
	['fontname'],
	['fontsize'],
	['forecolor','backcolor','separator'],
	['bold','italic','underline','separator'],
	['strikethrough','subscript','superscript','separator'],
	['justifyleft','justifycenter','justifyright','separator'],
	['OrderedList','UnOrderedList',/*'Outdent','Indent',*/'separator'],
	['HorizontalRule','Createlink',/*'InsertImage',*/'htmlmode'/*,'separator'*/],
];

config.fontnames = {
	"Arial":           "arial, helvetica, sans-serif",
	"Courier New":     "courier new, courier, mono",
	"Tahoma":          "Tahoma, Arial, Helvetica, sans-serif",
	"Times New Roman": "times new roman, times, serif",
	"Verdana":         "Verdana, Arial, Helvetica, sans-serif",
	"WingDings":       "WingDings"
};
config.fontsizes = {
    "1 (8 pt)":  "1",
    "2 (10 pt)": "2",
    "3 (12 pt)": "3",
    "4 (14 pt)": "4",
    "5 (18 pt)": "5",
    "6 (24 pt)": "6",
    "7 (36 pt)": "7"
  };

//config.stylesheet = "http://www.domain.com/sample.css";
  
config.fontstyles = [   // make sure classNames are defined in the page the content is being display as well in or they won't work!
  { name: "headline",     className: "headline",  classStyle: "font-family: arial black, arial; font-size: 28px; letter-spacing: -2px;" },
  { name: "arial red",    className: "headline2", classStyle: "font-family: arial black, arial; font-size: 12px; letter-spacing: -2px; color:red" },
  { name: "verdana blue", className: "headline4", classStyle: "font-family: verdana; font-size: 18px; letter-spacing: -2px; color:blue" }

// leave classStyle blank if it's defined in config.stylesheet (above), like this:
//  { name: "verdana blue", className: "headline4", classStyle: "" }  
];

// -->
</script>

</head>

<body bgcolor="#ffffff" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- top: begin -->
<table border=0 width=100% cellpadding=5 cellspacing=0>
<tr>
	<td class="color2"><div class="fnt2"><?=$site_nav_alt; ?></div></td>
</tr>
</table>
<table border=0 width=100% cellpadding=0 cellspacing=0>
<tr>
	<td class="color1" height=1><img src="/<?=$document_admin;?>/images/empty.gif" width="1" height="1" border="0"></td>
</tr>
</table>
<!-- top: end -->
<table border=0 width=100% cellpadding=0 cellspacing=0>
<tr>
	<td class="color4" width=150 valign=top>
	<table border=0 width=100% cellpadding=5 cellspacing=0>
	<tr>
		<td><div class="fnt2">
		<!-- <b>Навигатор:</b><br> -->

<?
// выводим меню
for($i=0;$i<count($site_menu);$i++)
{
	if($site_menu[$i]["level"]==1)
	{
		$l_begin='<b>';
		$l_end='</b>';
	}
	elseif($site_menu[$i]["level"]==2)
	{
		$l_begin='';
		$l_end='';
	}
	else
	{
		$l_begin='';
		$l_end='';
	}

	$spaces='';
	for($s=0;$s<($site_menu[$i]["level"]-1);$s++) $spaces.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

	if($site_menu[$i]["show"]=='no')
		continue;
	elseif($site_menu[$i]["show"]=='url')
		echo "\t".$spaces."<img src=\"/$document_admin/images/bullet.gif\" width=\"8\" height=\"10\" border=\"0\"><a href=\"".$site_menu[$i]["url"]."\">".$l_begin.$site_menu[$i]["name"].$l_end."</a><br>\n";
	elseif($site_menu[$i]["show"]=='nourl')
		echo "\t".$spaces."<img src=\"/$document_admin/images/bullet.gif\" width=\"8\" height=\"10\" border=\"0\">".$l_begin.$site_menu[$i]["name"].$l_end."<br>\n";
	elseif($site_menu[$i]["show"]=='br')
		echo "\t".$spaces."<br>\n";
}
?>
		<br><br><br><br>
		</div></td>
	</tr>
	</table>
	</td>
	<td class="color1" width=1><img src="/<?=$document_admin;?>/images/empty.gif" width="1" height="1" border="0"></td>
	<td class="color4" valign=top>
	<table border=0 width=100% cellpadding=5 cellspacing=0>
	<tr>
		<td width=10><img src="/<?=$document_admin;?>/images/empty.gif" width="10" height="1" border="0"></td>
		<td><div class="fnt2">

<h1><?=$site_nav[count($site_nav)-1]["name"]?></h1>
