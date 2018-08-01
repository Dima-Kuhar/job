<?
//====================================================
// Конфигурационный файл для административного модуля
// Last update: 29.10.2004
//====================================================

// название сайта
$site_name='Job.RusCable.Ru';
// URL сайта
$site_url='http://job.ruscable.ru/';
// меню административного модуля
$site_menu=array();
$site_menu[]=array('name'=>'Вакансии',		'url'=>'',											'level'=>1,	'show'=>'nourl');
$site_menu[]=array('name'=>'Вакансии',		'url'=>'/'.$document_admin.'/vacancie/',			'level'=>2,	'show'=>'url');
$site_menu[]=array('name'=>'Пользователи',	'url'=>'/'.$document_admin.'/vacancie/users.php',	'level'=>2,	'show'=>'url');

$site_menu[]=array('name'=>'Резюме',		'url'=>'',											'level'=>1,	'show'=>'nourl');
$site_menu[]=array('name'=>'Резюме',		'url'=>'/'.$document_admin.'/resume/',				'level'=>2,	'show'=>'url');
$site_menu[]=array('name'=>'Пользователи',	'url'=>'/'.$document_admin.'/resume/users.php',		'level'=>2,	'show'=>'url');

$site_menu[]=array('name'=>'Общее',			'url'=>'',											'level'=>1,	'show'=>'nourl');
$site_menu[]=array('name'=>'Специальности',	'url'=>'/'.$document_admin.'/common/',				'level'=>2,	'show'=>'url');
$site_menu[]=array('name'=>'Города',		'url'=>'/'.$document_admin.'/common/citys.php',		'level'=>2,	'show'=>'url');
$site_menu[]=array('name'=>'График работы',	'url'=>'/'.$document_admin.'/common/schedules.php',	'level'=>2,	'show'=>'url');

// альтернативная навигация
$site_nav=array(
0=>array("name"=>$site_name,"url"=>$site_url),
1=>array("name"=>"Администрирование","url"=>"/".$document_admin."/")
);
// разделитель для навигации и тайтлов
$site_separator=":::";
// данные для подключения к серверу с базой данных
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
