<?
$firtLevelMenuId=300;
$menuId=302;
include_once('0-includes.inc');



$title='������������� ������';

$pagename='data-resume';


@session_start();
if(isset($_SESSION['user'])) $user_login = true;
//====================================================

// ���� ������������ �� ���������, �� �������� ��� �� �������� index.html

if(!$user_login || $_SESSION['user_type'] != 'seeker')

{

	Header("Location: index.html");

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

	// ������� ����� � �������

	case 'show_form':

		include('0-header.inc');

		// ID ������������

        $user_dbid = $_SESSION['panel_user_id'];

		$result = GetDB("SELECT id, ruscable_user_id, speciality_id, schedule_id, pay, education, experience, skill, currency FROM $db_resume WHERE ruscable_user_id = '$user_dbid' and id=$id");

		if(count($result) == 1)

		{

			$values = $result[0];

			echo '<h1 align="center">�������������� ������ �'.$id.'</h1>'."\n";

			show_form($values);

		}

		else

		{

			echo '<h1 align="center">�������������� ������ �'.$id.'</h1>'."\n";

			echo '<font color="#ff0000"><b>������:</b> ������ � ����� ������� �� ����������</font>'."\n";

		}

		include('0-footer.inc');

	break;



	// ������� ����� � �������

	case 'do_update':

		// ��������� ������

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

		if($check_form == '')

		{

			// ����� �� �������, ������������ ��������������

			$error_log = array();

			// ��������� ���� �� ��������������� �������

			if($form_vars['speciality'] != '')

			{

				$add_speciality = add_simplerows($db_specialitys, 'id', 'speciality', $form_vars['speciality']);

				if($add_speciality) $form_vars['speciality_id'] = $add_speciality;

				else $error_log[] = '�� ������� �������� ����� ������������� � �������';

			}

			// ���������

			$update_data = update_data($id, $user_dbid, $form_vars['speciality_id'], $form_vars['schedule_id'], $form_vars['pay'], $form_vars['education'], $form_vars['experience'], $form_vars['skill']);

			if(!$update_data) $error_log[] = '�� ������� �������� ���� ������';

			// ������� ������������ �����

			if(count($error_log) == 0)

			{

				$action_inform='���� ������ ���������';

				include('0-header.inc');

				echo '<h1 align="center">�������������� ������ �'.$id.'</h1>'."\n";

				show_action_inform();

				$result = GetDB("SELECT id, ruscable_user_id, speciality_id, schedule_id, pay, education, experience, skill FROM $db_resume WHERE ruscable_user_id = '$user_dbid' and id=$id");

				$values = $result[0];

				show_form($values);

				include('0-footer.inc');

			}

			else

			{

				$action_inform='��������, � ������ ������ ���������� ������ ������ ����������. ������ ����� �������� � ������� ����.';

				$to_admin = implode("\n", $error_log);

				letter_2_webmaster($to_admin);

				include('0-header.inc');

				echo '<h1 align="center">�������������� ������ �'.$id.'</h1>'."\n";

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

			echo '<h1 align="center">�������������� ������ �'.$id.'</h1>'."\n";

			show_form($values, $errors);

			include('0-footer.inc');

		}



	break;



	// ������� ����� � �������

	default:

		include('0-header.inc');

		// ID ������������

		$user_dbid = $user_dbid = $_SESSION['panel_user_id'];

		$result = GetDB("SELECT id, ruscable_user_id, speciality_id, schedule_id, pay, education, experience, skill, currency FROM $db_resume WHERE ruscable_user_id = '$user_dbid' and id=$id");

		if(count($result) == 1)

		{

			$values = $result[0];

			echo '<h1>�������������� ������ �'.$id.'</h1>'."\n";

			show_form($values);

		}

		else

		{

			echo '<h1>�������������� ������ �'.$id.'</h1>'."\n";

			echo '<font color="#ff0000"><b>������:</b> ������ � ����� ������� �� ����������</font>'."\n";

		}

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

// ������� ����� � �������

function show_form($values='', $errors='')

{

	global $db_users, $db_resume, $db_vacancie, $db_citys, $db_specialitys, $db_schedules;

	global $forms_size, $textarea_cols, $textarea_rows;



	// � ��������� ����� ���� �������� " �� &quot;

	if($values != '') $values = formdata_preedit($values);
	//print_r($values);
	?>



	<form name="updatedata_form" method="post" enctype="multipart/form-data" action="<?=$GLOBALS['SCRIPT_NAME'];?>" class=tform>



	<table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">

	<tr>

		<td valign="top" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>���&nbsp;1:</b></div></td>

		<td valign="top" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>

		<td valign="top"><div class="text3"><b>&nbsp;������ �� ������������ ��������</b></div></td>

	</tr>

	</table>



	<ul>





		�������������<sup><font color="#ff0000">*</font></sup>:<br>

		<?

		// ��������� �� ������

		if($errors!='' && isset($errors['speciality']))

			echo '<font color="#ff0000"><b>������:</b> '.$errors['speciality'].'</font><br>';

		?>

		<div class="note">(�������� ������ ��� ������������� �� ������)</div>

		<select class="ff" name="speciality_id">

		<?

		$rows = GetDB("SELECT * FROM ".$db_specialitys." ORDER BY speciality");

		echo "SELECT * FROM ".$db_specialitys." ORDER BY speciality";



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

				echo "\t\t\t".'<option value="'.$rows[$i]['id'].'">'.$rows[$i]['speciality']."\n";

			else

				echo "\t\t\t".'<option value="'.$rows[$i]['id'].'" selected>'.$rows[$i]['speciality']."\n";

		}

		?>

		</select>

		<div class="note">(���� ������ ����������� �� �����, ����� ����, �� <b>�� ����� 150 ��������</b>)</div>

		<input type="text" name="speciality" class="ff" size="<?=$forms_size;?>" maxlength="150" value="<?if($values!='' && isset($values['speciality'])) echo $values['speciality'];?>"><br>









		������ ������<sup><font color="#ff0000">*</font></sup>:<br>

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









		��������� ���������� ����� � ���.<sup><font color="#ff0000">*</font></sup>:<br>

		<?

			if($errors!='' && isset($errors['pay'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['pay'].'</font><br>';

		?>

		<div class="note">(������ ���� ������� ����� �����)</div>

		<input type="text" name="pay" class="ff" size="<?=$forms_size;?>" maxlength="10" value="<?if($values!='' && isset($values['pay'])){ if($values['currency']==0){$col=$values['pay']*30;echo $col;}else{echo $values['pay'];}}?>"><br>









		�����������<sup><font color="#ff0000">*</font></sup>:<br>

		<?

			if($errors!='' && isset($errors['education'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['education'].'</font><br>';

		?>

		<div class="note">(������� ���� �����������, ����� ��������� ������������ � �.�., �� ����� 500 ��������)</div>

		<textarea name="education" rows="<?=$textarea_rows;?>" cols="<?=$textarea_cols;?>" class="ff"><?if($values!='' && isset($values['education'])) echo $values['education'];?></textarea><br>









		���� ������<sup><font color="#ff0000">*</font></sup>:<br>

		<?

			if($errors!='' && isset($errors['experience'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['experience'].'</font><br>';

		?>

		<div class="note">(���� ������ �� ������������ ��� �������������, ���� �������, �� ����� 1000 ��������)</div>

		<textarea name="experience" rows="<?=$textarea_rows;?>" cols="<?=$textarea_cols;?>" class="ff"><?if($values!='' && isset($values['experience'])) echo $values['experience'];?></textarea><br>









		���������������� ������<sup><font color="#ff0000">*</font></sup>:<br>

		<?

			if($errors!='' && isset($errors['skill'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['skill'].'</font><br>';

		?>

		<div class="note">(�������� �� �� �����������, ������ �� ������������ ����� � �.�., �� ����� 500 ��������)</div>

		<textarea name="skill" rows="<?=$textarea_rows;?>" cols="<?=$textarea_cols;?>" class="ff"><?if($values!='' && isset($values['skill'])) echo $values['skill'];?></textarea><br>





	</ul>





	<p>

	<p><b>�����:</b> ���� ���������� ������ '<sup><font color="#ff0000">*</font></sup>' ����������� ��� ����������.

	<p><input type="hidden" name="id" value="<? echo $values['id']; ?>"><input type="hidden" name="action" value="do_update">

	<input type="submit" name="submit" value="�������� ������" class="ff">



	</form>



	<?

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

// ��������� ������

function update_data($msg_id, $user_id, $speciality_id, $schedule_id, $pay, $education, $experience, $skill)

{

	global $db_resume;



	//echo "UPDATE $db_resume SET speciality_id='$speciality_id', schedule_id='$schedule_id', pay='$pay', education='$education', experience='$experience', skill='$skill' WHERE id='$msg_id' and seeker_id='$seeker_id'";

	$update = mysql_query("UPDATE $db_resume SET speciality_id='$speciality_id', schedule_id='$schedule_id', pay='$pay', education='$education', experience='$experience', skill='$skill' WHERE id='$msg_id' and ruscable_user_id='$user_id'");

	if(!$update) return false;

	else return true;

}



//====================================================

?>