<?
//====================================================
// ���������������� ������ ������� '������ - ������������'
// Last update: 09.12.2004
//====================================================
include("../droot.php");
// ���������� ������
include_once("$DOCUMENT_ROOT/$document_admin/config.php");
// ���������� ������� ������ � �����
include_once("$DOCUMENT_ROOT/db_connect.php");
// ��������� ����� ������� � ������ ���������
$site_nav[]=array("name"=>"������ - ������������","url"=>"/$document_admin/resume/users.php");

//====================================================
// ����������
//====================================================

// ��� ������� � MySQL
$mysql_tablename="job_users_seeker";
// ����
/*
0 - fld_field    - ��� ���� � ����
1 - fld_type     - ��� ���� (����� "|" ������������� �������������� ��������� (���� ��� ������� ����))
2 - fld_name     - �������� ���� ��� �����������
3 - fld_form     - ��� �������� ����� (TEXT, TEXTAREA, RADIO, CHECKBOX, LISTBOX, FILE, HIDDEN)
4 - fld_fill     - ����������� ��� ���������� (FILL)
5 - fld_showadd  - ���������� ���� ��� ���������� (SHOW ADD)
6 - fld_showedit - ���������� ���� ��� ��������� (SHOW EDIT)
7 - fld_preview  - ���������� ���� � ����� ������ ������� ������� (PREVIEW|NO PREVIEW)
8 - fld_comment  - ����������� � �������� �����
*/
$db_fields=array();
$db_fields[]=array('id',		'INT',			'ID',		'HIDDEN',	'',		'',			'SHOW EDIT',	'PREVIEW',		'');
$db_fields[]=array('login',		'VARCHAR|25',	'�����',	'TEXT|25',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'�� ������ 25 ��������');
$db_fields[]=array('pass',		'VARCHAR|25',	'������',	'TEXT|25',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'�� ������ 25 ��������');
$db_fields[]=array('name',		'VARCHAR|100',	'�.�.�.',	'TEXT|100',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'PREVIEW|LINK',	'�� ������ 100 ��������');
$db_fields[]=array('sex',		'VARCHAR|1',	'���',		'LISTBOX',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'');
$db_fields[]=array('age',		'INT',			'�������',	'TEXT|3',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'������ ���� ������� ����� �����');
$db_fields[]=array('city_id',	'INT',			'�����',	'LISTBOX',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'PREVIEW',		'');
$db_fields[]=array('phone',		'VARCHAR|100',	'�������',	'TEXT|100',	'',		'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'�� ������ 100 ��������');
$db_fields[]=array('email',		'VARCHAR|150',	'E-mail',	'TEXT|150',	'',		'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'�� ������ 150 ��������');

// ���� � ID
$db_id_field='id';
// ��������� ����������
$db_sort='ORDER BY name';
// ���������� ������� �� ��������
$rows_onpage=30;
// ��� ����� �����
$this_filename='users.php';

db_connect();
// ������ ��� ���� 'sex'
$list_sex[0]['value'] = 'm';
$list_sex[0]['name']  = '�������';
$list_sex[1]['value'] = 'f';
$list_sex[1]['name']  = '�������';
$list_sex_list=convert_listbox_arr($list_sex);

// ������ ��� ���� 'city_id'
$rows=GetDB("SELECT id, city FROM job_citys ORDER BY city");
$list_city_id=array();
for($i=0;$i<count($rows);$i++)
{
	$list_city_id[$i]['value'] = $rows[$i]['id'];
	$list_city_id[$i]['name']  = $rows[$i]['city'];
}
$list_city_id_list=convert_listbox_arr($list_city_id);


// ��������������� ������ ��� ���� listbox � ���������� ������ (������)
function convert_listbox_arr($array)
{
	$new_array=array();
	for($i=0;$i<count($array);$i++)
		$new_array[$array[$i]['value']]=$array[$i]['name'];
	return $new_array;
}
//====================================================
// ���������� ������
require ("$DOCUMENT_ROOT/$document_admin/engine1a.php");

?>
