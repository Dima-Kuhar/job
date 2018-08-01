<?
//====================================================
// Административный модуль раздела 'Резюме'
// Last update: 09.12.2004
//====================================================
include("../droot.php");
// подключаем конфиг
include_once("$DOCUMENT_ROOT/$document_admin/config.php");
// подключаем функции работы с базой
include_once("$DOCUMENT_ROOT/db_connect.php");
// добавляем новый элемент в массив навигации
$site_nav[]=array("name"=>"Резюме","url"=>"/$document_admin/resume/");

//====================================================
// ПЕРЕМЕННЫЕ
//====================================================

// имя таблицы в MySQL
$mysql_tablename="job_resume";
// поля
/*
0 - fld_field    - имя поля в базе
1 - fld_type     - тип поля (через "|" прописываются дополнительные параметры (свои для каждого типа))
2 - fld_name     - название поля для отображения
3 - fld_form     - вид элемента формы (TEXT, TEXTAREA, RADIO, CHECKBOX, LISTBOX, FILE, HIDDEN)
4 - fld_fill     - обязательно для заполнения (FILL)
5 - fld_showadd  - отображать поле при добавлении (SHOW ADD)
6 - fld_showedit - отображать поле при изменении (SHOW EDIT)
7 - fld_preview  - отображать поле в общем списке записей таблицы (PREVIEW|NO PREVIEW)
8 - fld_comment  - комментарии к элементу формы
*/
$db_fields=array();
$db_fields[]=array('id',			'INT',			'ID',			'HIDDEN',	'',			'',			'SHOW EDIT',	'PREVIEW',		'');
$db_fields[]=array('seeker_id',		'INT',			'Соискатель',	'LISTBOX',	'FILL',		'SHOW ADD',	'SHOW EDIT',	'PREVIEW|LINK',	'');
$db_fields[]=array('speciality_id',	'INT',			'Специальность','LISTBOX',	'FILL',		'SHOW ADD',	'SHOW EDIT',	'PREVIEW|LINK',	'');
$db_fields[]=array('schedule_id',	'INT',			'График работы','LISTBOX',	'FILL',		'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'');
$db_fields[]=array('pay',			'INT',			'Зарплата',		'TEXT|10',	'FILL',		'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'Должно быть введено целое число');
$db_fields[]=array('education',		'TEXT|HTML',	'Образование',	'TEXTAREA',	'FILL',		'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'Допускается применение HTML-тегов');
$db_fields[]=array('experience',	'TEXT|HTML',	'Опыт работы',	'TEXTAREA',	'FILL',		'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'Допускается применение HTML-тегов');
$db_fields[]=array('skill',			'TEXT|HTML',	'Проф. навыки',	'TEXTAREA',	'FILL',		'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'Допускается применение HTML-тегов');
$db_fields[]=array('date',			'SQLTIMESTAMP',	'Дата',			'TEXT|14',	'FILL',		'SHOW ADD',	'SHOW EDIT',	'PREVIEW',		'Формат даты: ГГГГ-ММ-ДД чч:мм:сс');
$db_fields[]=array('ip',			'VARCHAR|15',	'IP',			'TEXT|15',	'FILL',		'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'Не больше 15 символов');

// Поле с ID
$db_id_field='id';
// Параметры сортировки
$db_sort='ORDER BY date DESC, id DESC';
// Количество записей на странице
$rows_onpage=30;

db_connect();
// Список для поля 'seeker_id'
$rows=GetDB("SELECT id, name FROM job_users_seeker ORDER BY name");
$list_seeker_id=array();
for($i=0;$i<count($rows);$i++)
{
	$list_seeker_id[$i]['value'] = $rows[$i]['id'];
	$list_seeker_id[$i]['name']  = $rows[$i]['name'];
}
$list_seeker_id_list=convert_listbox_arr($list_seeker_id);

// Список для поля 'speciality_id'
$rows=GetDB("SELECT id, speciality FROM job_specialitys ORDER BY speciality");
$list_speciality_id=array();
for($i=0;$i<count($rows);$i++)
{
	$list_speciality_id[$i]['value'] = $rows[$i]['id'];
	$list_speciality_id[$i]['name']  = $rows[$i]['speciality'];
}
$list_speciality_id_list=convert_listbox_arr($list_speciality_id);

// Список для поля 'schedule_id'
$rows=GetDB("SELECT id, schedule FROM job_schedules ORDER BY id");
$list_schedule_id=array();
for($i=0;$i<count($rows);$i++)
{
	$list_schedule_id[$i]['value'] = $rows[$i]['id'];
	$list_schedule_id[$i]['name']  = $rows[$i]['schedule'];
}
$list_schedule_id_list=convert_listbox_arr($list_schedule_id);


// преобразовывает список для поля listbox в одномерный массив (список)
function convert_listbox_arr($array)
{
	$new_array=array();
	for($i=0;$i<count($array);$i++)
		$new_array[$array[$i]['value']]=$array[$i]['name'];
	return $new_array;
}
//====================================================
// подключаем движок
require ("$DOCUMENT_ROOT/$document_admin/engine1a.php");

?>
