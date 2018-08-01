<?
//====================================================
// Административный модуль раздела 'Резюме - Пользователи'
// Last update: 09.12.2004
//====================================================
include("../droot.php");
// подключаем конфиг
include_once("$DOCUMENT_ROOT/$document_admin/config.php");
// подключаем функции работы с базой
include_once("$DOCUMENT_ROOT/db_connect.php");
// добавляем новый элемент в массив навигации
$site_nav[]=array("name"=>"Резюме - Пользователи","url"=>"/$document_admin/resume/users.php");

//====================================================
// ПЕРЕМЕННЫЕ
//====================================================

// имя таблицы в MySQL
$mysql_tablename="job_users_seeker";
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
$db_fields[]=array('id',		'INT',			'ID',		'HIDDEN',	'',		'',			'SHOW EDIT',	'PREVIEW',		'');
$db_fields[]=array('login',		'VARCHAR|25',	'Логин',	'TEXT|25',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'Не больше 25 символов');
$db_fields[]=array('pass',		'VARCHAR|25',	'Пароль',	'TEXT|25',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'Не больше 25 символов');
$db_fields[]=array('name',		'VARCHAR|100',	'Ф.И.О.',	'TEXT|100',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'PREVIEW|LINK',	'Не больше 100 символов');
$db_fields[]=array('sex',		'VARCHAR|1',	'Пол',		'LISTBOX',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'');
$db_fields[]=array('age',		'INT',			'Возраст',	'TEXT|3',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'Должно быть введено целое число');
$db_fields[]=array('city_id',	'INT',			'Город',	'LISTBOX',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'PREVIEW',		'');
$db_fields[]=array('phone',		'VARCHAR|100',	'Телефон',	'TEXT|100',	'',		'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'Не больше 100 символов');
$db_fields[]=array('email',		'VARCHAR|150',	'E-mail',	'TEXT|150',	'',		'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'Не больше 150 символов');

// Поле с ID
$db_id_field='id';
// Параметры сортировки
$db_sort='ORDER BY name';
// Количество записей на странице
$rows_onpage=30;
// Имя этого файла
$this_filename='users.php';

db_connect();
// Список для поля 'sex'
$list_sex[0]['value'] = 'm';
$list_sex[0]['name']  = 'мужчина';
$list_sex[1]['value'] = 'f';
$list_sex[1]['name']  = 'женщина';
$list_sex_list=convert_listbox_arr($list_sex);

// Список для поля 'city_id'
$rows=GetDB("SELECT id, city FROM job_citys ORDER BY city");
$list_city_id=array();
for($i=0;$i<count($rows);$i++)
{
	$list_city_id[$i]['value'] = $rows[$i]['id'];
	$list_city_id[$i]['name']  = $rows[$i]['city'];
}
$list_city_id_list=convert_listbox_arr($list_city_id);


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
