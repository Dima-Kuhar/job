<?
$firtLevelMenuId=300;
$menuId=302;
include_once('0-includes.inc');



$title='�������������� ��������';

$pagename='data-allvacancie';



db_connect();


@session_start();
if(isset($_SESSION['user'])) $user_login = true;
//====================================================

// ���� ������������ �� ���������, �� �������� ��� �� �������� index.html

if(!$user_login || $_SESSION['user_type'] != 'employer')

{

	Header("Location: index.html");

	exit;

}

//====================================================

// ������� MySQL

$mysql_tablename=$db_vacancie;

// ����� �� ��������

$rows_onpage=10;

// ��������� ����������

$db_sort='ORDER BY date DESC, id DESC';

// ��� ������ � �������

$link_filename='data-allvacancie';

// ���� ����� �������� �� ���������, ������ ������ ��������

if(!isset($page)) $page=1;

else settype($page,"integer");

// ID ������������

$user_dbid = $_SESSION['panel_user_id'];

//====================================================

// ������������ ������� ���� ��������

if(isset($del))

{

	$del_result = mysql_query("DELETE FROM $mysql_tablename WHERE id=$del and ruscable_user_id=$user_dbid");

	if(!$del_result) $action_inform = '�� ������� ������� �������� �$del';

	else $action_inform = '�������� �'.$del.' ������� �������';

}

//====================================================



include('0-header.inc');



// ������� ������ �� ������ ��������

function show_links()

{

	global $page, $rows_onpage;

	global $mysql_tablename;

	global $link_filename;

	global $user_dbid;



	// ������ ����� ���������� �������

	$query="SELECT count(*) FROM $mysql_tablename WHERE ruscable_user_id=$user_dbid";

	$result=GetDB($query);

	$rows_num=$result[0]["count(*)"];



	// ���������� �������

	$sets=ceil($rows_num/$rows_onpage);



	// ������� ������

	for($i=1;$i<=$sets;$i++)

	{

		$start=($i-1)*$rows_onpage+1;

		$end=$start+$rows_onpage-1;

		if($i==$sets) $end=$end-abs($sets*$rows_onpage-$rows_num);

		if($i!==$page)

			echo " <a href='/$link_filename-$i.html'>[$start-$end]</a> ";

			//echo " <a href='/news.html?page=$i'>[$start-$end]</a> "; // ��� ������ ��� mod_rewrite

		else

			echo " <font color=\"#ffffff\" style=\"background-color: 4574A2\"><b>&nbsp;[$start-$end]&nbsp;</b></font> ";

	}

}

// ������� ����� ������ ������� �������

function show_content()

{

	global $page, $rows_onpage;

	global $mysql_tablename, $db_sort;

	global $user_dbid;



	// ����� �����

	$from=($page-1)*$rows_onpage;

	$limit="LIMIT $from,$rows_onpage";

	// ����������� ���������� �� ����

	$query="SELECT * FROM $mysql_tablename WHERE ruscable_user_id=$user_dbid $db_sort $limit";

	$rows=GetDB($query);



	echo '<ol start='.($from+1).'>'."\n";

	for ($i=0;$i<count($rows);$i++)

	{

		// �������������

		$speciality=get_tblrow($GLOBALS['db_specialitys'], 'speciality', 'id', $rows[$i]['speciality_id']);

		$speciality=ucfirst(trim($speciality));


		echo "\t".'<li><a style="font-size: 105%;" href="showvacancie-'.$rows[$i]['id'].'.html"><b>'.$speciality.'</b></a><br>'."\n";
		if($rows[$i]['currency']==1){
			$col=$rows[$i]['pay'];
		}else{
			$col=$rows[$i]['pay']*30;
		}

		echo "\t".'<b>��������:</b> �� '.$col.' ���.<br>'."\n";

		echo "\t".'<b>���� ����������:</b> '.convert_sql_timestamp($rows[$i]['date']).'<br>'."\n";

		echo "\t".'<a href="data-vacancie-'.$rows[$i]['id'].'.html"><font color="#ff0000">�������������</font></a> | <a href="data-allvacancie-'.$page.'.html?del='.$rows[$i]['id'].'"><font color="#ff0000">�������</font></a><br><br>'."\n";

	}

	echo '</ol>'."\n";

}

// ������� ����� � ���������

function show_action_inform()

{

	global $action_inform;



	if($action_inform!='') echo '<p><font color="#ff0000"><b>���������:</b> '.$action_inform.'</font></p>';

}

//====================================================

?>



<h1>�������������� ��������</h1>



<? show_action_inform(); ?>



<table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">

<tr>

	<td valign="middle" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>���� ��������:</b></div></td>

	<td valign="middle" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>

	<td valign="middle"><div class="text3"><b>&nbsp;<?show_links();?></b></div></td>

</tr>

</table>

<div style='padding: 6px 0px 0px 6px;'>
<table width=100%><tr><td width=50% valign=top style='padding-right: 10px;'>


<?show_content();?>
</td></tr></table>
				</div>


<table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">

<tr>

	<td valign="middle" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>���� ��������:</b></div></td>

	<td valign="middle" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>

	<td valign="middle"><div class="text3"><b>&nbsp;<?show_links();?></b></div></td>

</tr>

</table>



<?

include('0-footer.inc');

?>