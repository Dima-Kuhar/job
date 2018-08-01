<?
$firtLevelMenuId=100;
$menuId=100;
include_once('0-includes.inc');

$title='��������';
$pagename='showvacancie';

//====================================================
// ������� MySQL
$mysql_tablename=$db_vacancie;
//====================================================
db_connect();
// ���� ����� �������� �� ���������, ��� ������ ���������� ���, �� ������
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
$speciality   = get_tblrow($db_specialitys, 'speciality', 'id', $rows[0]['speciality_id']);
if($rows[0]['sex']=='m') $sex='�������';
elseif($rows[0]['sex']=='f') $sex='�������';
elseif($rows[0]['sex']=='a') $sex='�� �����';
$age_min      = $rows[0]['age_min'];
$age_max      = $rows[0]['age_max'];
$schedule     = get_tblrow($db_schedules, 'schedule', 'id', $rows[0]['schedule_id']);
$pay          = $rows[0]['pay'];
$requirements = nl2br($rows[0]['requirements']);
$date         = convert_sql_timestamp($rows[0]['date']);
$currency  	= $rows[0]['currency'];

$sadate = strtotime($rows[0]['date']);
if(intval($sadate) > 1404244800){
	$nosex_noage = 1;
}else{
	$nosex_noage = 0;
}

$user_info=get_tblrow($db_users, '*', 'ruscable_user_id', $rows[0]['ruscable_user_id']);

$user_info['city'] = get_tblrow($db_citys, 'city', 'id', $user_info['city_id']);
$speciality=ucfirst(trim($speciality));

?>

<h1><?=$speciality;?></h1>

<table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">
<tr>
	<td valign="middle" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>��������:</b></div></td>
	<td valign="middle" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>
	<td valign="middle"><div class="text3"><b>&nbsp;</b></div></td>
</tr>
</table>

<table border="0" width="" cellpadding="4" cellspacing="0">
<tr>
	<td valign="top" width="133"><div class="text">�������������:</div></td>
	<td valign="top"><div class="text"><?=$speciality;?></div></td>
</tr>
<?
if($nosex_noage==0){
?>
<tr>
	<td valign="top" width="133"><div class="text">���:</div></td>
	<td valign="top"><div class="text"><?=$sex;?></div></td>
</tr>
<tr>
	<td valign="top" width="133"><div class="text">�������:</div></td>
	<td valign="top"><div class="text">�� <?=$age_min;?> �� <?=$age_max;?> ���</div></td>
</tr>
<?
}
?>
<tr>
	<td valign="top" width="133"><div class="text">������ ������:</div></td>
	<td valign="top"><div class="text"><?=$schedule;?></div></td>
</tr>

<tr>
	<td valign="top" width="133"><div class="text">��������:</div></td>
	<td valign="top"><div class="text"><?
if($pay==0){
	echo "�� ����������� �������������";
}else{
	if($currency==0){
		$pay=intval($pay*30);
	}
	 echo "$pay ���.";
}
?></div></td>
</tr>
<tr>
	<td valign="top" width="133"><div class="text">����������:</div></td>
	<td valign="top"><div class="text"><?=$requirements;?></div></td>
</tr>
<tr>
	<td valign="top" width="133"><div class="text">���� ����������:</div></td>
	<td valign="top"><div class="text"><?=$date;?></div></td>
</tr>
</table>

<?php if($user_login) { ?>
    <table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">
    <tr>
        <td valign="middle" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>������������:</b></div></td>
        <td valign="middle" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>
        <td valign="middle"><div class="text3"><b>&nbsp;</b></div></td>
    </tr>
    </table>

    <table border="0" width="" cellpadding="4" cellspacing="0">
    <tr>
        <td valign="top" width="133"><div class="text">�����������:</div></td>
        <td valign="top"><div class="text"><?=$user_info['name'];?></div></td>
    </tr>
    <tr>
        <td valign="top" width="133"><div class="text">�����:</div></td>
        <td valign="top"><div class="text"><?=$user_info['city'];?></div></td>
    </tr>
    <tr>
        <td valign="top" width="133"><div class="text">���������� ����:</div></td>
        <td valign="top"><div class="text"><?=$user_info['contact_person'];?></div></td>
    </tr>
    <tr>
        <td valign="top" width="133"><div class="text">�������:</div></td>
        <td valign="top"><div class="text"><?=$user_info['phone'];?></div></td>
    </tr>
    <tr>
        <td valign="top" width="133"><div class="text">E-mail:</div></td>
        <td valign="top"><div class="text"><?=js_email($user_info['email']);?></div></td>
    </tr>
    </table>
<?php } else { ?>

    ���������� �������� ������ �������������� �������������

<?php } ?>


<?
if($_GET['frame']!=1){
	include('0-footer.inc');
}else{
	print "<br><b><a target=_new style='font-size: 105%;' href='".str_replace("?frame=1","",$_SERVER['REQUEST_URI'])."'>������ �� ��� ��������</a></b>
	</div></body></html>";
}
?>