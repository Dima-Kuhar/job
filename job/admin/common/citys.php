<?
//====================================================
// Административный модуль раздела 'Общее - Города'
// Last update: 09.12.2004
//====================================================
include("../droot.php");
// подключаем конфиг
include_once("$DOCUMENT_ROOT/$document_admin/config.php");
// подключаем функции работы с базой
include_once("$DOCUMENT_ROOT/db_connect.php");
// добавляем новый элемент в массив навигации
$site_nav[]=array("name"=>"Общее - Города","url"=>"/$document_admin/common/citys.php");

//====================================================
// ПЕРЕМЕННЫЕ
//====================================================

// имя таблицы в MySQL
$mysql_tablename="job_citys";
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
$db_fields[]=array('id',	'INT',			'ID',	'HIDDEN',	'',		'',			'SHOW EDIT','PREVIEW',		'');
$db_fields[]=array('city',	'VARCHAR|100',	'Город','TEXT|100',	'FILL',	'SHOW ADD',	'SHOW EDIT','PREVIEW|LINK',	'Не больше 100 символов');

// Поле с ID
$db_id_field='id';
// Параметры сортировки
$db_sort='ORDER BY city';
// Количество записей на странице
$rows_onpage=30;
// Имя этого файла
$this_filename='citys.php';
//====================================================
// подключаем движок
require ("$DOCUMENT_ROOT/$document_admin/engine.php");

?>
