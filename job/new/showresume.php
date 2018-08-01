<?
$firtLevelMenuId=200;
$menuId=201;
include_once('0-includes.inc');

$title='Резюме';
$pagename='showresume';

//====================================================
// таблица MySQL
$mysql_tablename=$db_resume;
//====================================================
db_connect();
// если номер страницы не определен, или такого объявления нет, то ошибка
if(!isset($id) || !check_tblrow($mysql_tablename, 'id', $id))
	Header("Location: error.html");
else
	settype($id,"integer");
//====================================================
if($_GET['frame']!=1){
	include('0-header.inc');
}else{
	print '<html>
	<head>
	<link rel="stylesheet" href="/style1.css" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="/style.css" type="text/css" media="screen, projection" />
	<style>
	h1{
		padding-bottom: 10px;
	}
	</style>
	</head>
	<body>
	<a name=top></a>
	<div style="padding: 20px;border: 1px solid #c5dbeb;">

	';
}
$rows=GetDB("SELECT * FROM $mysql_tablename WHERE id='$id'");
//$user_id    = $rows[0]['seeker_id'];
$speciality = get_tblrow($db_specialitys, 'speciality', 'id', $rows[0]['speciality_id']);
$schedule   = get_tblrow($db_schedules, 'schedule', 'id', $rows[0]['schedule_id']);
$pay        = $rows[0]['pay'];
$education  = nl2br($rows[0]['education']);
$experience = nl2br($rows[0]['experience']);
$skill      = nl2br($rows[0]['skill']);
$date       = convert_sql_timestamp($rows[0]['date']);
$currency  	= $rows[0]['currency'];
$user_info=get_tblrow($db_users, '*', 'ruscable_user_id', $rows[0]['ruscable_user_id']);
if($user_info['sex']=='m') $user_info['sex']='Мужчина';
elseif($user_info['sex']=='f') $user_info['sex']='Женщина';
$user_info['city'] = get_tblrow($db_citys, 'city', 'id', $user_info['city_id']);
$speciality=ucfirst(trim($speciality));
?>
<h1><?=$speciality;?></h1>

<table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">
<tr>
	<td valign="middle" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>Резюме:</b></div></td>
	<td valign="middle" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>
	<td valign="middle"><div class="text3"><b>&nbsp;</b></div></td>
</tr>
</table>

<table border="0" width="" cellpadding="4" cellspacing="0">
<tr>
	<td valign="top" width="133"><div class="text">Специальность:</div></td>
	<td valign="top"><div class="text"><?=$speciality;?></div></td>
</tr>
<tr>
	<td valign="top" width="133"><div class="text">График работы:</div></td>
	<td valign="top"><div class="text"><?=$schedule;?></div></td>
</tr>
<tr>
	<td valign="top" width="133"><div class="text">Зарплата:</div></td>
<?
if($currency==0){
	$col=$rows[$i]['pay']*30;
}
?>
	<td valign="top"><div class="text"><?=$pay;?> руб.</div></td>
</tr>
<tr>
	<td valign="top" width="133"><div class="text">Образование:</div></td>
	<td valign="top"><div class="text"><?=$education;?></div></td>
</tr>
<tr>
	<td valign="top" width="133"><div class="text">Опыт работы:</div></td>
	<td valign="top"><div class="text"><?=$experience;?></div></td>
</tr>
<tr>
	<td valign="top" width="133"><div class="text">Профессиональные навыки:</div></td>
	<td valign="top"><div class="text"><?=$skill;?></div></td>
</tr>
<tr>
	<td valign="top" width="133"><div class="text">Дата добавления:</div></td>
	<td valign="top"><div class="text"><?=$date;?></div></td>
</tr>
</table>

<?php if($user_login) { ?>
    <table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">
    <tr>
        <td valign="middle" width="120" background="/images/bg-top02-0"><div class="text2"><b>Автор:</b></div></td>
        <td valign="middle" width="2" background="/images/bg-top02-0"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>
        <td valign="middle"><div class="text3"><b>&nbsp;</b></div></td>
    </tr>
    </table>


    <table border="0" width="" cellpadding="4" cellspacing="0">
    <tr>
        <td valign="top" width="133"><div class="text">Ф.И.О.:</div></td>
        <td valign="top"><div class="text"><?=$user_info['name'];?></div></td>
    </tr>
    <tr>
        <td valign="top" width="133"><div class="text">Пол:</div></td>
        <td valign="top"><div class="text"><?=$user_info['sex'];?></div></td>
    </tr>
    <tr>
        <td valign="top" width="133"><div class="text">Возраст:</div></td>
        <td valign="top"><div class="text"><?=$user_info['age'];?></div></td>
    </tr>
    <tr>
        <td valign="top" width="133"><div class="text">Город:</div></td>
        <td valign="top"><div class="text"><?=$user_info['city'];?></div></td>
    </tr>
    <tr>
        <td valign="top" width="133"><div class="text">Телефон:</div></td>
        <td valign="top"><div class="text"><?=$user_info['phone'];?></div></td>
    </tr>
    <tr>
        <td valign="top" width="133"><div class="text">E-mail:</div></td>
        <td valign="top"><div class="text"><?=js_email($user_info['email']);?></div></td>
    </tr>
    </table>
<?php } else { ?>

    Информация доступна только авторизованным пользователям

<?php } ?>


<?
if($_GET['frame']!=1){
	include('0-footer.inc');
}else{
	print "<br><b><a target=_new style='font-size: 105%;' href='".str_replace("?frame=1","",$_SERVER['REQUEST_URI'])."'>Ссылка на это резюме</a></b>
	</div></body></html>";
}
?>