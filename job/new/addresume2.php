<?
$firtLevelMenuId=300;
$menuId=301;
include_once('0-includes.inc');
session_start();
$title='�������� ������';
$pagename='addresume';

//====================================================
// ���� ������������ �� ���������, �� �������� ��� �� �������� addresume.html
if(!$user_login || $_SESSION['user_type'] != 'seeker')
{
	Header("Location: addresume.html");
	exit;
}
//====================================================
// ���� �������� �� ����������, �� ��� ��������
if(!isset($action)) $action='';
// ���� ������� ������� � ��������� �� ����
$action_inform='';
//====================================================

db_connect();

// ��������
switch($action)
{
	// ����� ��� ����������
	case 'show_form':
		include('0-header.inc');   // ������� ������� �����
		show_form();               // ������� ����� ���������� �����
		include('0-footer.inc');   // ������� ������ �����
	break;

	// ���������
	case 'do_add':
		// ��������� ������
		// ��� 1: ������ �� ������������ ��������
		$form_vars['speciality_id'] = trim(strip_tags($HTTP_POST_VARS['speciality_id']));
		$form_vars['speciality']    = trim(strip_tags($HTTP_POST_VARS['speciality']));
		$form_vars['schedule_id']   = trim(strip_tags($HTTP_POST_VARS['schedule_id']));
		$form_vars['pay']           = trim(strip_tags($HTTP_POST_VARS['pay']));
		$form_vars['education']     = trim(htmlspecialchars($HTTP_POST_VARS['education']));
		$form_vars['experience']    = trim(htmlspecialchars($HTTP_POST_VARS['experience']));
		$form_vars['skill']         = trim(htmlspecialchars($HTTP_POST_VARS['skill']));
		// ID ������������
        $user_dbid = $_SESSION['panel_user_id'];

		// ��������� ������
		$errors_arr = array();
		$values_arr = array();
		$check_form = check_vars($form_vars);

		// ������ �����, ���������
		if($check_form=='')
		{
			// ����� �� ������� �� ����� ���������� ��������, ������������ ��������������
			$error_log = array();
			// ��������� ���� �� ��������������� �������
			if($form_vars['speciality'] != '')
			{
				$add_speciality = add_simplerows($db_specialitys, 'id', 'speciality', $form_vars['speciality']);
				if($add_speciality) $form_vars['speciality_id'] = $add_speciality;
				else $error_log[] = '�� ������� �������� ����� ������������� � �������';
			}
			// ��������� ����������
			$date = date("YmdHis");
			$ip   = $REMOTE_ADDR;
			$add_resume = add_resume($user_dbid, $form_vars['speciality_id'], $form_vars['schedule_id'], $form_vars['pay'], $form_vars['education'], $form_vars['experience'], $form_vars['skill'], $date, $ip);
			if($add_resume) $resume_id = $add_resume;
			else $error_log[] = '�� ������� �������� ������ � �������';
			// ������� ������������ �����
			if(count($error_log) == 0)
			{
				$action_inform='���� ������ ��������� � ���� ������ Job.RusCable.Ru';
				$msg=create_letter2($user_dbid, $form_vars, date("Y/m/d H:i"), 'newresume');
				letter_2_manager($msg, '����� ������');
				include('0-header.inc');
				echo '<h1>���������� ������</h1>'."\n";
				show_action_inform();
				echo '<p>���������� ����� ������ ������:<br>'."\n";
				echo '<a href="showresume-'.$resume_id.'.html">http://job.ruscable.ru/showresume-'.$resume_id.'.html</a>'."\n";
				echo '<p><b>���������� �� ������������� ������ �������</b>'."\n";
				include('0-footer.inc');
			}
			else
			{
				$action_inform='��������, � ������ ������ ���������� ������ ������ ����������. ������ ����� �������� � ������� ����.';
				$to_admin = implode("\n", $error_log);
				letter_2_webmaster($to_admin);
				include('0-header.inc');
				echo '<h1>���������� ������</h1>'."\n";
				show_action_inform();
				echo '<p>����� ���������� ��� ����������� <a href="showallvacancie.html">�������� �����������</a>, ����������� �� ����� �����.'."\n";
				echo '<p><b>���������� �� ������������� ������ �������</b>'."\n";
				include('0-footer.inc');
			}
		}
		else
		{
			$action_inform='����������� ������� ������';
			if($check_form=='')
				$check_form=array();
			$errors = $check_form;
			$values = $form_vars;
			include('0-header.inc');
			show_form($values, $errors);
			include('0-footer.inc');
		}

	break;

	// ������� ����� ��� ����������
	default:
		include('0-header.inc');
		show_form();
		include('0-footer.inc');
	break;
}



//====================================================
// �������
//====================================================
// ������� ����� � ���������
function show_action_inform()
{
	global $action_inform;

	if($action_inform!='') echo '<p><font color="#ff0000"><b>���������:</b> '.$action_inform.'</font>';
}
// ������� ����� ����������
function show_form($values='', $errors='')
{
	global $db_users_seeker, $db_users_employer, $db_resume, $db_vacancie, $db_citys, $db_specialitys, $db_schedules;
	global $forms_size, $textarea_cols, $textarea_rows;

	?>
	<h1>�������� ������</h1>

	<form name="addresume_form" method="post" enctype="multipart/form-data" action="<?=$GLOBALS['SCRIPT_NAME'];?>" class=tform>

	<table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">
	<tr>
		<td valign="top" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>���&nbsp;1:</b></div></td>
		<td valign="top" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>
		<td valign="top"><div class="text3"><b>&nbsp;������ �� ������������ ��������</b></div></td>
	</tr>
	</table>


	<ul>




		<li>�������������<sup><font color="#ff0000">*</font></sup>:<br>
		<?
		// ��������� �� ������
		if($errors!='' && isset($errors['speciality']))
			echo '<font color="#ff0000"><b>������:</b> '.$errors['speciality'].'</font><br>';
		?>
		<div class="note">(�������� ������ ��� ������������� �� ������)</div>
		<select class="ff" name="speciality_id">
		<?
		$rows = GetDB("SELECT * FROM ".$db_specialitys." where visible=1  ORDER BY speciality");
		//echo "SELECT * FROM ".$db_specialitys." ORDER BY speciality";

		// ���� ������, ���������� ��, ��� ���� ������� �����
		if($values!='' && isset($values['speciality_id']))
			$cheked = $values['speciality_id'];
		else
			$cheked = '';

		if($cheked == '' || $cheked == 0)
			echo "\t\t\t".'<option value="0" selected>---'."\n";

		for($i=0; $i<count($rows); $i++)
		{
			if($rows[$i]['id'] != $cheked)
				echo "\t\t\t".'<option value="'.$rows[$i]['id'].'">'.ucfirst($rows[$i]['speciality'])."\n";
			else
				echo "\t\t\t".'<option value="'.$rows[$i]['id'].'" selected>'.ucfirst($rows[$i]['speciality'])."\n";
		}
		?>
		</select>
		<div class="note">(���� ������ ����������� �� �����, ������� ����, <b>�� ����� 150 ��������</b>)</div>
		<input type="text" name="speciality" class="ff" size="<?=$forms_size;?>" maxlength="150" value="<?if($values!='' && isset($values['speciality'])) echo $values['speciality'];?>"><br>




		<li>������ ������<sup><font color="#ff0000">*</font></sup>:<br>
		<?
		// ��������� �� ������
		if($errors!='' && isset($errors['schedule_id']))
			echo '<font color="#ff0000"><b>������:</b> '.$errors['schedule_id'].'</font><br>';
		?>
		<div class="note">(�������� ���������� ��� ������ �� ������)</div>
		<select class="ff" name="schedule_id">
		<?
		$rows = GetDB("SELECT * FROM ".$db_schedules);

		// ���� ������, ���������� ��, ��� ���� ������� �����
		if($values!='' && isset($values['schedule_id']))
			$cheked = $values['schedule_id'];
		else
			$cheked = '';

		if($cheked == '' || $cheked == 0)
			echo "\t\t\t".'<option value="0" selected>---'."\n";

		for($i=0; $i<count($rows); $i++)
		{
			if($rows[$i]['id'] != $cheked)
				echo "\t\t\t".'<option value="'.$rows[$i]['id'].'">'.$rows[$i]['schedule']."\n";
			else
				echo "\t\t\t".'<option value="'.$rows[$i]['id'].'" selected>'.$rows[$i]['schedule']."\n";
		}
		?>
		</select>
		<br>




		<li>��������� ���������� ����� � ���.<sup><font color="#ff0000">*</font></sup>:<br>
		<?
			if($errors!='' && isset($errors['pay'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['pay'].'</font><br>';
		?>
		<div class="note">(������ ���� ������� ����� �����)</div>
		<input type="text" name="pay" class="ff" size="<?=$forms_size;?>" maxlength="10" value="<?if($values!='' && isset($values['pay'])) echo $values['pay'];?>"><br>




		<li>�����������<sup><font color="#ff0000">*</font></sup>:<br>
		<?
			if($errors!='' && isset($errors['education'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['education'].'</font><br>';
		?>
		<div class="note">(������� ���� �����������, ����� ��������� ������������ � �.�., �� ����� 500 ��������)</div>
		<textarea name="education" rows="<?=$textarea_rows;?>" cols="<?=$textarea_cols;?>" class="ff"><?if($values!='' && isset($values['education'])) echo $values['education'];?></textarea><br>




		<li>���� ������<sup><font color="#ff0000">*</font></sup>:<br>
		<?
			if($errors!='' && isset($errors['experience'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['experience'].'</font><br>';
		?>
		<div class="note">(���� ������ �� ������������ ��� �������������, ���� �������, �� ����� 1000 ��������)</div>
		<textarea name="experience" rows="<?=$textarea_rows;?>" cols="<?=$textarea_cols;?>" class="ff"><?if($values!='' && isset($values['experience'])) echo $values['experience'];?></textarea><br>




		<li>���������������� ������<sup><font color="#ff0000">*</font></sup>:<br>
		<?
			if($errors!='' && isset($errors['skill'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['skill'].'</font><br>';
		?>
		<div class="note">(�������� �� �� �����������, ������ �� ������������ ����� � �.�., �� ����� 500 ��������)</div>
		<textarea name="skill" rows="<?=$textarea_rows;?>" cols="<?=$textarea_cols;?>" class="ff"><?if($values!='' && isset($values['skill'])) echo $values['skill'];?></textarea><br>




	</ul>



	<p>



<p><b>�����:</b> ���� ���������� ������ &laquo;<font color="#ff0000">*</font>&raquo; ����������� ��� ����������.
	<p><input type="hidden" name="action" value="do_add">
	<input type="submit" name="submit" value="�������� ������" class="ff">

	</form>

	<?
	echo ''."\n";
	echo ''."\n";
}
// ��������� ���������� ������
function check_vars($form_vars)
{
	$error='';

	if($form_vars['speciality']!='' && strlen($form_vars['speciality'])>150)
		$error['speciality']='���� ������ ��������� �� <b>'.(strlen($form_vars['speciality'])-150).'</b> �������� ������';
	elseif($form_vars['speciality']=='' && $form_vars['speciality_id']==0)
		$error['speciality']='������ ���� ����������� ��� ����������';
	elseif($form_vars['speciality']=='' && !check_tblrow($GLOBALS['db_specialitys'], 'id', $form_vars['speciality_id']))
		$error['speciality']='�������� ������������ ������';

	if(!check_tblrow($GLOBALS['db_schedules'], 'id', $form_vars['schedule_id']))
		$error['schedule_id']='�������� ������������ ������';

	if($form_vars['pay']=='')
		$error['pay']='������ ���� ����������� ��� ����������';
	elseif(!check_integer($form_vars['pay'], true) || $form_vars['pay']>9999999999)
		$error['pay']='������� ������������ �������� ���������� �����';

	if($form_vars['education']=='')
		$error['education']='������ ���� ����������� ��� ����������';
	elseif(strlen($form_vars['education'])>500)
		$error['education']='���� ������ ��������� �� <b>'.(strlen($form_vars['education'])-500).'</b> �������� ������';

	if($form_vars['experience']=='')
		$error['experience']='������ ���� ����������� ��� ����������';
	elseif(strlen($form_vars['experience'])>1000)
		$error['experience']='���� ������ ��������� �� <b>'.(strlen($form_vars['experience'])-1000).'</b> �������� ������';

	if($form_vars['skill']=='')
		$error['skill']='������ ���� ����������� ��� ����������';
	elseif(strlen($form_vars['skill'])>500)
		$error['skill']='���� ������ ��������� �� <b>'.(strlen($form_vars['skill'])-500).'</b> �������� ������';

	return $error;
}
// ��������� ����������
function add_resume($user_id, $speciality_id, $schedule_id, $pay, $education, $experience, $skill, $date, $ip)
{
	global $db_resume;

	//echo "INSERT INTO `$db_resume` VALUES (NULL, '$user_id', '$speciality_id', '$schedule_id', '$pay', '$education', '$experience', '$skill', '$date', '$ip')";
	$add = mysql_query("INSERT INTO `$db_resume` VALUES (NULL, '$user_id', '$speciality_id', '$schedule_id', '$pay', 1, '$education', '$experience', '$skill', '$date', '$ip')");
	if(!$add) return false;
	$res = GetDB("SELECT id FROM `$db_resume` WHERE ruscable_user_id='$user_id' and speciality_id='$speciality_id' and schedule_id='$schedule_id' and pay='$pay' and education='$education' and experience='$experience' and skill='$skill' and date='$date' and ip='$ip'");
	if(count($res)>0)
	{
		$id = $res[0]['id'];
		return $id;
	}
	else
	{
		return false;
	}
}
//====================================================
?>