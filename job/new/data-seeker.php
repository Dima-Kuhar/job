<?
$firtLevelMenuId=300;
$menuId=303;
include_once('0-includes.inc');



$title='������������� ������ ������';

$pagename='data-seeker';


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

		$result = GetDB("SELECT id, name, sex, age, city_id, phone, email FROM $db_users WHERE ruscable_user_id = '".$_SESSION['panel_user_id']."'");

		$values = $result[0];

		echo '<h1>���� ������</h1>'."\n";

		show_form($values);

		include('0-footer.inc');

	break;



	// ������� ����� � �������

	case 'do_update':

		// ��������� ������

		$form_vars['name']          = trim(strip_tags($HTTP_POST_VARS['name']));

		$form_vars['sex']           = trim(strip_tags($HTTP_POST_VARS['sex']));

		$form_vars['age']           = trim(strip_tags($HTTP_POST_VARS['age']));

		$form_vars['city_id']       = trim(strip_tags($HTTP_POST_VARS['city_id']));

		$form_vars['city']          = trim(strip_tags($HTTP_POST_VARS['city']));

		$form_vars['phone']         = trim(strip_tags($HTTP_POST_VARS['phone']));

		$form_vars['email']         = trim(strip_tags($HTTP_POST_VARS['email']));

		// ID ������������

		$user_dbid = $_SESSION['panel_user_id'];



		// ��������� ������

		$errors_arr = array();

		$values_arr = array();

		$check_form = check_vars($form_vars);



		// ������ �����, ���������

		if($check_form == '')

		{

			// ����� �� ������� �� ����� ���������� ��������, ������������ ��������������

			$error_log = array();

			if($form_vars['city'] != '')

			{

				$add_city = add_simplerows($db_citys, 'id', 'city', $form_vars['city']);

				if($add_city) $form_vars['city_id'] = $add_city;

				else $error_log[] = '�� ������� �������� ����� ����� � �������';

			}

			// ���������

			$update_data = update_data($user_dbid, $form_vars['name'], $form_vars['sex'], $form_vars['age'], $form_vars['city_id'], $form_vars['phone'], $form_vars['email']);

			if(!$update_data) $error_log[] = '�� ������� �������� ���� ������';

			// ������� ������������ �����

			if(count($error_log) == 0)

			{

				$action_inform='���� ������ ���������';

				include('0-header.inc');

				echo '<h1>���� ������</h1>'."\n";

				show_action_inform();

				$result = GetDB("SELECT id, name, sex, age, city_id, phone, email FROM $db_users WHERE ruscable_user_id = '".$_SESSION['panel_user_id']."'");

				$values = $result[0];

				show_form($values);

				include('0-footer.inc');

			}

			else

			{

				$action_inform='��������, � ������ ������ ���������� ����� ������ ����������. ������ ����� �������� � ������� ����.';

				$to_admin = implode("\n", $error_log);

				letter_2_webmaster($to_admin);

				include('0-header.inc');

				echo '<h1>���� ������</h1>'."\n";

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

			echo '<h1>���� ������</h1>'."\n";

			show_form($values, $errors);

			include('0-footer.inc');

		}



	break;



	// ������� ����� � �������

	default:

		include('0-header.inc');

		$result = GetDB("SELECT id, name, sex, age, city_id, phone, email FROM $db_users WHERE ruscable_user_id = '".$_SESSION['panel_user_id']."'");

		$values = $result[0];

		echo '<h1>���� ������</h1>'."\n";

		show_form($values);

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

	?>



	<form name="updatedata_form" method="post" enctype="multipart/form-data" class="tform">



	<table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">

	<tr>

		<td valign="top" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>���&nbsp;1:</b></div></td>

		<td valign="top" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>

		<td valign="top"><div class="text3"><b>&nbsp;���� ������</b></div></td>

	</tr>

	</table>



	<ul>





		�.�.�.<sup><font color="#ff0000">*</font></sup>:<br>

		<?

			if($errors!='' && isset($errors['name'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['name'].'</font><br>';

		?>

		<div class="note">(�� ����� 100 ��������)</div>

		<input type="text" name="name" class="ff" size="<?=$forms_size;?>" maxlength="100" value="<?if($values!='' && isset($values['name'])) echo $values['name'];?>"><br>









		���<sup><font color="#ff0000">*</font></sup>:<br>

		<?

			if($errors!='' && isset($errors['sex'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['sex'].'</font><br>';

		?>

		<select class="ff" name="sex">

		<?

		$sex_0 = '';

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

			echo "\t\t\t".'<option value="m" '.$sex_m.'>�������'."\n";

			echo "\t\t\t".'<option value="f" '.$sex_f.'>�������'."\n";

		?>

		</select>

		<br>







		�������<sup><font color="#ff0000">*</font></sup>:<br>

		<?

			if($errors!='' && isset($errors['age'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['age'].'</font><br>';

		?>

		<div class="note">(������ ���� ������� ����� �����)</div>

		<input type="text" name="age" class="ff" size="<?=$forms_size;?>" maxlength="3" value="<?if($values!='' && isset($values['age'])) echo $values['age'];?>"><br>









		�����<sup><font color="#ff0000">*</font></sup>:<br>

		<?

			if($errors!='' && isset($errors['city'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['city'].'</font><br>';

		?>

		<div class="note">(�������� ��� ����� �� ������)</div>

		<select class="ff" name="city_id">

		<?

		$rows = GetDB("SELECT * FROM ".$db_citys." where id not in(82,524) ORDER BY city");



		// ���� ������, ���������� ��, ��� ���� ������� �����

		if($values!='' && isset($values['city_id']))

			$cheked = $values['city_id'];

		else

			$cheked = '';



		if($cheked == '' || $cheked == 0)

			echo "\t\t\t".'<option value="0" selected>---'."\n";
		echo  "<option value=82 "; if($cheked==82){echo " selected";} echo ">������</option>";
		echo  "<option value=524 "; if($cheked==524){echo " selected";} echo ">�����-���������</option>";
		echo  "<option value=0><hr></option>";


		for($i=0; $i<count($rows); $i++)

		{

			if($rows[$i]['id'] != $cheked)

				echo "\t\t\t".'<option value="'.$rows[$i]['id'].'">'.$rows[$i]['city']."\n";

			else

				echo "\t\t\t".'<option value="'.$rows[$i]['id'].'" selected>'.$rows[$i]['city']."\n";

		}

		?>

		</select>

		<div class="note">(���� ������ ������ � ������ ���, �� ������� ���, �� <b>�� ����� 100 ��������</b>)</div>

		<input type="text" name="city" class="ff" size="<?=$forms_size;?>" maxlength="100" value="<?if($values!='' && isset($values['city'])) echo $values['city'];?>"><br>









		�������:<br>

		<?

			if($errors!='' && isset($errors['phone'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['phone'].'</font><br>';

		?>

		<div class="note">(�� ����� 100 ��������)</div>

		<input type="text" name="phone" class="ff" size="<?=$forms_size;?>" maxlength="100" value="<?if($values!='' && isset($values['phone'])) echo $values['phone'];?>"><br>









		E-mail:<br>

		<?

			if($errors!='' && isset($errors['email'])) echo '<font color="#ff0000"><b>������:</b> '.$errors['email'].'</font><br>';

		?>

		<div class="note">(�� ����� 150 ��������)</div>

		<input type="text" name="email" class="ff" size="<?=$forms_size;?>" maxlength="150" value="<?if($values!='' && isset($values['email'])) echo $values['email'];?>"><br>





	</ul>





	<p>
<p><b>�����:</b> ���� ���������� ������ &laquo;<font color="#ff0000">*</font>&raquo; ����������� ��� ����������.

	<p><input type="hidden" name="action" value="do_update">

	<input type="submit" name="submit" value="�������� ������" class="ff">



	</form>



	<?

}



// ��������� ���������� ������

function check_vars($form_vars)

{

	$error='';



	if($form_vars['name']=='')

		$error['name']='������ ���� ����������� ��� ����������';

	elseif(strlen($form_vars['name'])>100)

		$error['name']='���� ������ ��������� �� <b>'.(strlen($form_vars['name'])-100).'</b> �������� ������';



	if($form_vars['sex']!='m' && $form_vars['sex']!='f')

		$error['sex']='�� �� ������� ���� ���';



	if($form_vars['age']=='')

		$error['age']='������ ���� ����������� ��� ����������';

	elseif(!check_integer($form_vars['age'], true) || $form_vars['age']>100)

		$error['age']='������ ������������ �������';



	if($form_vars['city']!='' && strlen($form_vars['city'])>100)

		$error['city']='���� ������ ��������� �� <b>'.(strlen($form_vars['city'])-100).'</b> �������� ������';

	elseif($form_vars['city']=='' && $form_vars['city_id']==0)

		$error['city']='������ ���� ����������� ��� ����������';

	elseif($form_vars['city']=='' && !check_tblrow($GLOBALS['db_citys'], 'id', $form_vars['city_id']))

		$error['city']='�������� ������������ ������';



	if(strlen($form_vars['phone'])>100)

		$error['phone']='���� ������ ��������� �� <b>'.(strlen($form_vars['phone'])-100).'</b> �������� ������';



	if($form_vars['email']!='' && preg_match("/^[a-zA-Z0-9\\._-]+@(?:[a-zA-Z0-9_-]+\\.)+[a-zA-Z0-9_-]{2,3}\$/", $form_vars['email'])==0)

		$error['email']='E-mail ������ �����������';



	return $error;

}

// ��������� ������

function update_data($user_id, $name, $sex, $age, $city_id, $phone, $email)

{

	global $db_users;



	//echo "UPDATE $db_users SET name='$name', sex='$sex', age='$age', city_id='$city_id', phone='$phone', email='$email' WHERE ruscable_user_id='$user_id'";

	$update = mysql_query("UPDATE $db_users SET name='$name', sex='$sex', age='$age', city_id='$city_id', phone='$phone', email='$email' WHERE ruscable_user_id='$user_id'");

	if(!$update) return false;

	else

	{

		$_SESSION['user_name'] = $name;

		return true;

	}

}



//====================================================

?>