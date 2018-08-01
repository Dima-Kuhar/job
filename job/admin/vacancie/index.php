<?
//====================================================
// ���������������� ������ ������� '��������'
// Last update: 09.12.2004
//====================================================
include("../droot.php");
// ���������� ������
include_once("$DOCUMENT_ROOT/$document_admin/config.php");
// ���������� ������� ������ � �����
include_once("$DOCUMENT_ROOT/db_connect.php");
// ��������� ����� ������� � ������ ���������
$site_nav[]=array("name"=>"��������","url"=>"/$document_admin/vacancie/");

//====================================================
// ����������
//====================================================

// ��� ������� � MySQL
$mysql_tablename="job_vacancie";
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
$db_fields[]=array('id',			'INT',			'ID',			'HIDDEN',	'',		'',			'SHOW EDIT',	'PREVIEW',		'');
$db_fields[]=array('employer_id',	'INT',			'������������',	'LISTBOX',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'PREVIEW|LINK',	'');
$db_fields[]=array('speciality_id',	'INT',			'�������������','LISTBOX',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'PREVIEW|LINK',	'');
$db_fields[]=array('sex',			'VARCHAR|1',	'���',			'LISTBOX',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'');
$db_fields[]=array('age_min',		'INT',			'�������, ��',	'TEXT|3',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'������ ���� ������� ����� �����');
$db_fields[]=array('age_max',		'INT',			'�������, ��',	'TEXT|3',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'������ ���� ������� ����� �����');
$db_fields[]=array('schedule_id',	'INT',			'������ ������','LISTBOX',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'');
$db_fields[]=array('pay',			'INT',			'��������',		'TEXT|10',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'������ ���� ������� ����� �����');
$db_fields[]=array('requirements',	'TEXT|HTML',	'����������',	'TEXTAREA',	'',		'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'����������� ���������� HTML-�����');
$db_fields[]=array('date',			'SQLTIMESTAMP',	'����',			'TEXT|14',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'PREVIEW',		'������ ����: ����-��-�� ��:��:��');
$db_fields[]=array('ip',			'VARCHAR|15',	'IP',			'TEXT|15',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'�� ������ 15 ��������');

// ���� � ID
$db_id_field='id';
// ��������� ����������
$db_sort='ORDER BY id DESC';
// ���������� ������� �� ��������
$rows_onpage=30;

db_connect();
// ������ ��� ���� 'employer_id'
$rows=GetDB("SELECT id, name FROM job_users_employer ORDER BY name");
$list_employer_id=array();
for($i=0;$i<count($rows);$i++)
{
	$list_employer_id[$i]['value'] = $rows[$i]['id'];
	$list_employer_id[$i]['name']  = $rows[$i]['name'];
}
$list_employer_id_list=convert_listbox_arr($list_employer_id);

// ������ ��� ���� 'speciality_id'
$rows=GetDB("SELECT id, speciality FROM job_specialitys ORDER BY speciality");
$list_speciality_id=array();
for($i=0;$i<count($rows);$i++)
{
	$list_speciality_id[$i]['value'] = $rows[$i]['id'];
	$list_speciality_id[$i]['name']  = $rows[$i]['speciality'];
}
$list_speciality_id_list=convert_listbox_arr($list_speciality_id);

// ������ ��� ���� 'sex'
$list_sex[0]['value'] = 'a';
$list_sex[0]['name']  = '�� �����';
$list_sex[1]['value'] = 'm';
$list_sex[1]['name']  = '�������';
$list_sex[2]['value'] = 'f';
$list_sex[2]['name']  = '�������';
$list_sex_list=convert_listbox_arr($list_sex);

// ������ ��� ���� 'schedule_id'
$rows=GetDB("SELECT id, schedule FROM job_schedules ORDER BY id");
$list_schedule_id=array();
for($i=0;$i<count($rows);$i++)
{
	$list_schedule_id[$i]['value'] = $rows[$i]['id'];
	$list_schedule_id[$i]['name']  = $rows[$i]['schedule'];
}
$list_schedule_id_list=convert_listbox_arr($list_schedule_id);


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
