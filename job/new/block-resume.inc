<?
//====================================================
// ������� MySQL
$mysql_tablename=$db_resume;
// ����� �� ��������
$rows_onpage=7;
// ��������� ����������
$db_sort='ORDER BY date DESC, id DESC';
//====================================================
// ������� ����� ������ ������� �������
function show_last_resume()
{
	global $rows_onpage;
	global $mysql_tablename, $db_sort;

	// ����� �����
	$limit="LIMIT 0,$rows_onpage";
	// ����������� ���������� �� ����
	$query="SELECT * FROM $mysql_tablename $db_sort $limit";

	$rows=GetDB($query);

	echo '<ul>'."\n";
	for ($i=0;$i<count($rows);$i++)
	{
		// ���������� � ������������
		$user_info=get_tblrow($GLOBALS['db_users'], '*', 'ruscable_user_id', $rows[$i]['ruscable_user_id']);
		$name=$user_info['name'];
		if($user_info['sex']=='m') $sex='�������';
		elseif($user_info['sex']=='f') $sex='�������';
		$city=get_tblrow($GLOBALS['db_citys'], 'city', 'id', $user_info['city_id']);

		// �������������
		$speciality=get_tblrow($GLOBALS['db_specialitys'], 'speciality', 'id', $rows[$i]['speciality_id']);
		$speciality=ucfirst(trim($speciality));

		echo "\t".'<li><a style="font-size: 105%;" href="showresume-'.$rows[$i]['id'].'.html"><b>'.$speciality.'</b></a><br>'."\n";
		echo "\t".$sex.', '.$user_info['age'].' ���, ��������� � ������ '.$city.'<br>'."\n";

		if($rows[$i]['currency']==1){
			$val="���.";
			$col=$rows[$i]['pay'];
		}else{
			$val="���.";
			$col=$rows[$i]['pay']*30;
		}
		echo "\t".'<b>��������:</b> �� '.$col.' '.$val.'<br>'."\n";
		echo "\t".'<b>���� ����������:</b> '.convert_sql_timestamp($rows[$i]['date'],'date').'<br><br>'."\n";
	}
	echo '</ul>'."\n";
}
?>
<table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="//job.ruscable.ru/images/bg-top02-0.gif">
<tr>
	<td valign="top"><div class="text3"><b>&nbsp;��������� ������</b></div></td>
</tr>
</table>
<div style='padding: 4px 0px 0px 6px;'>
<?
db_connect();
show_last_resume();
?>
</div>