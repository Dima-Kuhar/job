<?
$firtLevelMenuId=200;
$menuId=201;
include_once('0-includes.inc');

$title='�������� ������';
$pagename='showallresume';

include('0-header.inc');

//====================================================
// ������ �� ��������
$rowsonpage=10;
$linkblocksonpage=10;
// ��� ������ � �������
$link_filename='showallresume.html';
// ������� MySQL
$mysql_tablename=$db_resume;
// ��������� ����������
$db_sort='ORDER BY date DESC, id DESC';
// ���� ����� �������� �� ���������, ������ ������ ��������
if(!isset($page)) $page=1;
else settype($page,"integer");
//====================================================

// ������� ����� ������ ������� �������
function show_content()
{
	global $page, $rowsonpage;
	global $mysql_tablename, $db_sort;

	// ����� �����
	$from=($page-1)*$rowsonpage;
	$limit="LIMIT $from,$rowsonpage";
	// ����������� ���������� �� ����
	$query="SELECT * FROM $mysql_tablename $db_sort $limit";
	$rows=GetDB($query);

	echo '<ol start='.($from+1).'>'."\n";
	for ($i=0;$i<count($rows);$i++)
	{
		if($i<5){
			$top="";
		}else{
			$top="#top";
		}
		// ���������� � ������������
		$user_info=get_tblrow($GLOBALS['db_users'], '*', 'ruscable_user_id', $rows[$i]['ruscable_user_id']);
		if($user_info['sex']=='m') $sex='�������';
		elseif($user_info['sex']=='f') $sex='�������';
		$city=get_tblrow($GLOBALS['db_citys'], 'city', 'id', $user_info['city_id']);

		// �������������
		$speciality=get_tblrow($GLOBALS['db_specialitys'], 'speciality', 'id', $rows[$i]['speciality_id']);
		$speciality=ucfirst(trim($speciality));
		echo "\t".'<li><a style="font-size: 105%;"  href="showresume-'.$rows[$i]['id'].'.html"><b>'.ucfirst($speciality).'</b></a><br>'."\n";
		echo "\t".$sex.', '.$user_info['age'].' ���, ��������� � ������ '.$city.'<br>'."\n";
		if($rows[$i]['currency']==1){
			$val="���.";
			$col=$rows[$i]['pay'];
		}else{
			$val="���.";
			$col=$rows[$i]['pay']*30;
		}
		echo "\t".'<b>��������:</b> �� '.$col.' '.$val.'<br>'."\n";
		echo "\t".'<b>���� ����������:</b> '.convert_sql_timestamp($rows[$i]['date']).'<br><br>'."\n";
	}
	echo '</ol>'."\n";
}
//====================================================
db_connect();
$links = get_links($page, $link_filename, true);
?>

<h1>�������� ������</h1>

<table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">
<tr>
	<td valign="middle" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>������:</b></div></td>
	<td valign="middle" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>
	<td valign="middle"><div class="text3" align=right><b style='padding-right: 45%'>&nbsp;<?echo $links;?></b></div></td>
</tr>
</table>
<div style='padding: 6px 0px 0px 6px;'>
<table width=100%><tr><td width=50% valign=top style='padding-right: 10px;'>
<?show_content();?>
</td><td width=50% valign=top style='padding: 10px 0px 0px 10px;'><div style='min-height:500px;'>
				<!--iframe name="preview" align=right style='max-width: 450px;width: 450px;' height=100% scrolling="auto" src="/blank.html"></iframe-->
				</div>
				</td></tr></table>
				</div><table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">
<tr>
	<td valign="middle" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>������:</b></div></td>
	<td valign="middle" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>
	<td valign="middle"><div class="text3" align=right><b style='padding-right: 45%'>&nbsp;<?echo $links;?></b></div></td>
</tr>
</table>

<?
include('0-footer.inc');
?>