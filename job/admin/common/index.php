<?
//====================================================
// ���������������� ������ ������� '����� - �������������'
// Last update: 09.12.2004
//====================================================
include("../droot.php");
// ���������� ������
include_once("$DOCUMENT_ROOT/$document_admin/config.php");
// ���������� ������� ������ � �����
include_once("$DOCUMENT_ROOT/db_connect.php");
// ��������� ����� ������� � ������ ���������
$site_nav[]=array("name"=>"����� - �������������","url"=>"/$document_admin/common/");

//====================================================
// ����������
//====================================================

// ��� ������� � MySQL
$mysql_tablename="job_specialitys";
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
$db_fields[]=array('id',		'INT',			'ID',			'HIDDEN',	'',		'',			'SHOW EDIT',	'PREVIEW',		'');
$db_fields[]=array('speciality','VARCHAR|150',	'�������������','TEXT|150',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'PREVIEW|LINK',	'�� ������ 150 ��������');
$db_fields[]=array('visible',		'INT',			'�������',			'TEXT|1',	'',		'',			'SHOW EDIT',	'PREVIEW',		'');

// ���� � ID
$db_id_field='id';
// ��������� ����������
$db_sort='ORDER BY speciality';
// ���������� ������� �� ��������
$rows_onpage=30;

//====================================================
// ���������� ������
require ("$DOCUMENT_ROOT/$document_admin/engine.php");

?>
