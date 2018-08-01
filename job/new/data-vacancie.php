<?
$firtLevelMenuId=300;
$menuId=302;
include_once('0-includes.inc');



$title='������������� ������';

$pagename='data-vacancie';


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

		$result = GetDB("SELECT id, ruscable_user_id, speciality_id, sex, age_min, age_max, schedule_id, pay, requirements, currency FROM $db_vacancie WHERE ruscable_user_id = '$user_dbid' and id=$id");

		if(count($result) == 1)

		{

			$values = $result[0];

			echo '<h1>�������������� �������� �'.$id.'</h1>'."\n";

			show_form($values);

		}

		else

		{

			echo '<h1>�������������� �������� �'.$id.'</h1>'."\n";

			echo '<font color="#ff0000"><b>������:</b> �������� � ����� ������� �� ����������</font>'."\n";

		}

		include('0-footer.inc');

	break;



	// ������� ����� � �������

	case 'do_update':

		// ��������� ������

		$form_vars['speciality_id'] = trim(strip_tags($HTTP_POST_VARS['speciality_id']));

		$form_vars['speciality']    = trim(strip_tags($HTTP_POST_VARS['speciality']));

		$form_vars['sex']           = trim(strip_tags($HTTP_POST_VARS['sex']));

		$form_vars['age_min']       = trim(strip_tags($HTTP_POST_VARS['age_min']));

		$form_vars['age_max']       = trim(strip_tags($HTTP_POST_VARS['age_max']));

		$form_vars['schedule_id']   = trim(strip_tags($HTTP_POST_VARS['schedule_id']));

		$form_vars['pay']           = trim(strip_tags($HTTP_POST_VARS['pay']));

		$form_vars['requirements']  = trim(htmlspecialchars($HTTP_POST_VARS['requirements']));

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

			$update_data = update_data($id, $user_dbid, $form_vars['speciality_id'], $form_vars['sex'], $form_vars['age_min'], $form_vars['age_max'], $form_vars['schedule_id'], $form_vars['pay'], $form_vars['requirements']);

			if(!$update_data) $error_log[] = '�� ������� �������� ���� ��������';

			// ������� ������������ �����

			if(count($error_log) == 0)

			{

				$action_inform='���� �������� ���������';

				include('0-header.inc');

				echo '<h1>�������������� �������� �'.$id.'</h1>'."\n";

				show_action_inform();

				$result = GetDB("SELECT id, ruscable_user_id, speciality_id, sex, age_min, age_max, schedule_id, pay, requirements FROM $db_vacancie WHERE ruscable_user_id = '$user_dbid' and id=$id");

				$values = $result[0];

				show_form($values);

				include('0-footer.inc');

			}

			else

			{

				$action_inform='��������, � ������ ������ ���������� ����� �������� ����������. ������ ����� �������� � ������� ����.';

				$to_admin = implode("\n", $error_log);

				letter_2_webmaster($to_admin);

				include('0-header.inc');

				echo '<h1>�������������� �������� �'.$id.'</h1>'."\n";

				show_action_inform();

				echo '<p>����� ���������� ��� ����������� <a href="showallresume.html">������ �����������</a>, ����������� �� ����� �����.'."\n";

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

			echo '<h1>�������������� �������� �'.$id.'</h1>'."\n";

			show_form($values, $errors);

			include('0-footer.inc');

		}



	break;



	// ������� ����� � �������

	default:

		include('0-header.inc');

		// ID ������������

        $user_dbid = $_SESSION['panel_user_id'];

		$result = GetDB("SELECT id, ruscable_user_id, speciality_id, sex, age_min, age_max, schedule_id, pay, requirements FROM $db_vacancie WHERE ruscable_user_id = '$user_dbid' and id=$id");

		if(count($result) == 1)

		{

			$values = $result[0];

			echo '<h1>�������������� �������� �'.$id.'</h1>'."\n";

			show_form($values);

		}

		else

		{

			echo '<h1>�������������� �������� �'.$id.'</h1>'."\n";

			echo '<font color="#ff0000"><b>������:</b> �������� � ����� ������� �� ����������</font>'."\n";

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

	global $db_users, $db_vacancie, $db_vacancie, $db_citys, $db_specialitys, $db_schedules;

	global $forms_size, $textarea_cols, $textarea_rows;



	// � ��������� ����� ���� �������� " �� &quot;

	if($values != '') $values = formdata_preedit($values);

	?>



	<form name="updatedata_form" method="post" enctype="multipart/form-data" class=tform>



	<table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">

	<tr>

		<td valign="top" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>���&nbsp;1:</b></div></td>

		<td valign="top" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>

		<td valign="top"><div class="text3"><b>&nbsp;������ �� ������������ ����������</b></div></td>

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









		���<sup><font color="#ff0000">*</font></sup>:<br>

		<?

			if($errors!='' && isset($errors['sex'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['sex'].'</font><br>';

		?>

		<select class="ff" name="sex">

		<?

		$sex_0 = '';

		$sex_a = '';

		$sex_m = '';

		$sex_f = '';

		// ���� ������, ���������� ��, ��� ���� ������� �����

		if($values!='' && isset($values['sex']))

		{

			$var='sex_'.$values['sex'];

			$$var= 'selected';

		}

		else

			$sex_0 = 'selected';



			echo "\t\t\t".'<option value="0" '.$sex_0.'>---'."\n";

			echo "\t\t\t".'<option value="a" '.$sex_a.'>�� �����'."\n";

			echo "\t\t\t".'<option value="m" '.$sex_m.'>�������'."\n";

			echo "\t\t\t".'<option value="f" '.$sex_f.'>�������'."\n";

		?>

		</select>

		<br>









		�������, ��<sup><font color="#ff0000">*</font></sup>:<br>

		<?

			if($errors!='' && isset($errors['age_min'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['age_min'].'</font><br>';

		?>

		<div class="note">(������ ���� ������� ����� �����)</div>

		<input type="text" name="age_min" class="ff" size="<?=$forms_size;?>" maxlength="3" value="<?if($values!='' && isset($values['age_min'])) echo $values['age_min'];?>"><br>









		�������, ��<sup><font color="#ff0000">*</font></sup>:<br>

		<?

			if($errors!='' && isset($errors['age_max'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['age_max'].'</font><br>';

		?>

		<div class="note">(������ ���� ������� ����� �����)</div>

		<input type="text" name="age_max" class="ff" size="<?=$forms_size;?>" maxlength="3" value="<?if($values!='' && isset($values['age_max'])) echo $values['age_max'];?>"><br>









		������ ������<sup><font color="#ff0000">*</font></sup>:<br>

		<?

		// ��������� �� ������

		if($errors!='' && isset($errors['schedule_id']))

			echo '<font color="#ff0000"><b>������:</b> '.$errors['schedule_id'].'</font><br>';

		?>

		<div class="note">(�������� ������ ��� ������ �� ������)</div>

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









		����������� ���������� ����� � ���.<sup><font color="#ff0000">*</font></sup>:<br>

		<?

			if($errors!='' && isset($errors['pay'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['pay'].'</font><br>';

		?>

		<div class="note">(������ ���� ������� ����� �����)</div>

		<input type="text" name="pay" class="ff" size="<?=$forms_size;?>" maxlength="10" value="<?if($values!='' && isset($values['pay'])){ if($values['currency']==0){$col=$values['pay']*30;echo $col;}else{echo $values['pay'];}}?>"><br>









		����������:<br>

		<?

			if($errors!='' && isset($errors['requirements'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['requirements'].'</font><br>';

		?>

		<div class="note">(������� ���� ���������� � ����������, �� ����� 1000 ��������)</div>

		<textarea name="requirements" rows="<?=$textarea_rows;?>" cols="<?=$textarea_cols;?>" class="ff"><?if($values!='' && isset($values['requirements'])) echo $values['requirements'];?></textarea><br>





	</ul>





	<p>





	<table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">

	<tr>

		<td valign="top" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>���&nbsp;2:</b></div></td>

		<td valign="top" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>

		<td valign="top"><div class="text3"><b>&nbsp;���������� ������</b></div></td>

	</tr>

	</table>



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



	if($form_vars['sex']!='m' && $form_vars['sex']!='f' && $form_vars['sex']!='a')

		$error['sex']='������ ���� ����������� ��� ����������';



	if($form_vars['age_min']=='')

		$error['age_min']='������ ���� ����������� ��� ����������';

	elseif(!check_integer($form_vars['age_min'], true) || $form_vars['age_min']>100)

		$error['age_min']='������ ������������ �������';



	if($form_vars['age_max']=='')

		$error['age_max']='������ ���� ����������� ��� ����������';

	elseif($form_vars['age_max']<$form_vars['age_min'])

		$error['age_max']='������������ ������� �� ����� ���� ������ ������������';

	elseif(!check_integer($form_vars['age_max'], true) || $form_vars['age_max']>100)

		$error['age_max']='������ ������������ �������';



	if(!check_tblrow($GLOBALS['db_schedules'], 'id', $form_vars['schedule_id']))

		$error['schedule_id']='�������� ������������ ������';



	if($form_vars['pay']=='')

		$error['pay']='������ ���� ����������� ��� ����������';

	elseif(!check_integer($form_vars['pay'], true) || $form_vars['pay']>9999999999)

		$error['pay']='������� ������������ �������� ���������� �����';



	if(strlen($form_vars['requirements'])>1000)

		$error['requirements']='���� ������ ��������� �� <b>'.(strlen($form_vars['requirements'])-1000).'</b> �������� ������';



	return $error;

}

// ��������� ������

function update_data($msg_id, $user_id, $speciality_id, $sex, $age_min, $age_max, $schedule_id, $pay, $requirements)

{

	global $db_vacancie;



	$update = mysql_query("UPDATE $db_vacancie SET speciality_id='$speciality_id', sex='$sex', age_min='$age_min', age_max='$age_max', schedule_id='$schedule_id', pay='$pay', requirements='$requirements' WHERE id='$msg_id' and ruscable_user_id='$user_id'");

	if(!$update) return false;

	else return true;

}



//====================================================

?>