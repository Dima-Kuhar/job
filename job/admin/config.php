<?
//====================================================
// ���������������� ���� ��� ����������������� ������
// Last update: 29.10.2004
//====================================================

// �������� �����
$site_name='Job.RusCable.Ru';
// URL �����
$site_url='http://job.ruscable.ru/';
// ���� ����������������� ������
$site_menu=array();
$site_menu[]=array('name'=>'��������',		'url'=>'',											'level'=>1,	'show'=>'nourl');
$site_menu[]=array('name'=>'��������',		'url'=>'/'.$document_admin.'/vacancie/',			'level'=>2,	'show'=>'url');
$site_menu[]=array('name'=>'������������',	'url'=>'/'.$document_admin.'/vacancie/users.php',	'level'=>2,	'show'=>'url');

$site_menu[]=array('name'=>'������',		'url'=>'',											'level'=>1,	'show'=>'nourl');
$site_menu[]=array('name'=>'������',		'url'=>'/'.$document_admin.'/resume/',				'level'=>2,	'show'=>'url');
$site_menu[]=array('name'=>'������������',	'url'=>'/'.$document_admin.'/resume/users.php',		'level'=>2,	'show'=>'url');

$site_menu[]=array('name'=>'�����',			'url'=>'',											'level'=>1,	'show'=>'nourl');
$site_menu[]=array('name'=>'�������������',	'url'=>'/'.$document_admin.'/common/',				'level'=>2,	'show'=>'url');
$site_menu[]=array('name'=>'������',		'url'=>'/'.$document_admin.'/common/citys.php',		'level'=>2,	'show'=>'url');
$site_menu[]=array('name'=>'������ ������',	'url'=>'/'.$document_admin.'/common/schedules.php',	'level'=>2,	'show'=>'url');

// �������������� ���������
$site_nav=array(
0=>array("name"=>$site_name,"url"=>$site_url),
1=>array("name"=>"�����������������","url"=>"/".$document_admin."/")
);
// ����������� ��� ��������� � �������
$site_separator=":::";
// ������ ��� ����������� � ������� � ����� ������
/*
$db_server="192.168.0.1";
$db_user="ruscableru";
$db_password="123456";
$db_database="ruscableru";

$db_server="localhost";
$db_user="";
$db_password="";
$db_database="ruscable";
*/

?>
