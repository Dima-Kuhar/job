<?
$firtLevelMenuId=300;
$menuId=302;
include_once('0-includes.inc');



$title='Редактировать резюме';

$pagename='data-vacancie';


@session_start();
if(isset($_SESSION['user'])) $user_login = true;


//====================================================

// если пользователь не залогинен, то отсылаем его на страницу index.html

if(!$user_login || $_SESSION['user_type'] != 'employer')

{

	Header("Location: index.html");

	exit;

}

//====================================================

// если действие не определено, то нет действия

if(!isset($action)) $action='';

// пока никаких отчетов о действиях не было

$action_inform='';

//====================================================



db_connect();



// действия

switch($action)

{

	// выводим форму с данными

	case 'show_form':

		include('0-header.inc');

		// ID пользователя

        $user_dbid = $_SESSION['panel_user_id'];

		$result = GetDB("SELECT id, ruscable_user_id, speciality_id, sex, age_min, age_max, schedule_id, pay, requirements, currency FROM $db_vacancie WHERE ruscable_user_id = '$user_dbid' and id=$id");

		if(count($result) == 1)

		{

			$values = $result[0];

			echo '<h1>Редактирование вакансии №'.$id.'</h1>'."\n";

			show_form($values);

		}

		else

		{

			echo '<h1>Редактирование вакансии №'.$id.'</h1>'."\n";

			echo '<font color="#ff0000"><b>Ошибка:</b> вакансии с таким номером не существует</font>'."\n";

		}

		include('0-footer.inc');

	break;



	// выводим форму с данными

	case 'do_update':

		// принимаем данные

		$form_vars['speciality_id'] = trim(strip_tags($HTTP_POST_VARS['speciality_id']));

		$form_vars['speciality']    = trim(strip_tags($HTTP_POST_VARS['speciality']));

		$form_vars['sex']           = trim(strip_tags($HTTP_POST_VARS['sex']));

		$form_vars['age_min']       = trim(strip_tags($HTTP_POST_VARS['age_min']));

		$form_vars['age_max']       = trim(strip_tags($HTTP_POST_VARS['age_max']));

		$form_vars['schedule_id']   = trim(strip_tags($HTTP_POST_VARS['schedule_id']));

		$form_vars['pay']           = trim(strip_tags($HTTP_POST_VARS['pay']));

		$form_vars['requirements']  = trim(htmlspecialchars($HTTP_POST_VARS['requirements']));

		// ID пользователя

        $user_dbid = $_SESSION['panel_user_id'];



		// проверяем данные

		$errors_arr = array();

		$values_arr = array();

		$check_form = check_vars($form_vars);



		// данные верны, добавляем

		if($check_form == '')

		{

			// отчет об ошибках, направляемый администратору

			$error_log = array();

			// добавляем инфу во вспомогательные таблицы

			if($form_vars['speciality'] != '')

			{

				$add_speciality = add_simplerows($db_specialitys, 'id', 'speciality', $form_vars['speciality']);

				if($add_speciality) $form_vars['speciality_id'] = $add_speciality;

				else $error_log[] = 'Не удалось добавить новую специальность в таблицу';

			}

			// обновляем

			$update_data = update_data($id, $user_dbid, $form_vars['speciality_id'], $form_vars['sex'], $form_vars['age_min'], $form_vars['age_max'], $form_vars['schedule_id'], $form_vars['pay'], $form_vars['requirements']);

			if(!$update_data) $error_log[] = 'Не удалось обновить Вашу вакансию';

			// выводим пользователю отчет

			if(count($error_log) == 0)

			{

				$action_inform='Ваша вакансия обновлена';

				include('0-header.inc');

				echo '<h1>Редактирование вакансии №'.$id.'</h1>'."\n";

				show_action_inform();

				$result = GetDB("SELECT id, ruscable_user_id, speciality_id, sex, age_min, age_max, schedule_id, pay, requirements FROM $db_vacancie WHERE ruscable_user_id = '$user_dbid' and id=$id");

				$values = $result[0];

				show_form($values);

				include('0-footer.inc');

			}

			else

			{

				$action_inform='Извините, в данный момент обновление Вашей вакансии невозможно. Сервис будет доступен в течении часа.';

				$to_admin = implode("\n", $error_log);

				letter_2_webmaster($to_admin);

				include('0-header.inc');

				echo '<h1>Редактирование вакансии №'.$id.'</h1>'."\n";

				show_action_inform();

				echo '<p>Можем предложить Вам просмотреть <a href="showallresume.html">резюме соискателей</a>, размещенные на нашем сайте.'."\n";

				echo '<p><b>Благодарим за использование нашего сервиса</b>'."\n";

				include('0-footer.inc');

			}

		}

		else

		{

			$action_inform='Неправильно введены данные';

			if($check_form=='')

				$check_form=array();

			$errors = $check_form;

			$values = $form_vars;

			include('0-header.inc');

			echo '<h1>Редактирование вакансии №'.$id.'</h1>'."\n";

			show_form($values, $errors);

			include('0-footer.inc');

		}



	break;



	// выводим форму с данными

	default:

		include('0-header.inc');

		// ID пользователя

        $user_dbid = $_SESSION['panel_user_id'];

		$result = GetDB("SELECT id, ruscable_user_id, speciality_id, sex, age_min, age_max, schedule_id, pay, requirements FROM $db_vacancie WHERE ruscable_user_id = '$user_dbid' and id=$id");

		if(count($result) == 1)

		{

			$values = $result[0];

			echo '<h1>Редактирование вакансии №'.$id.'</h1>'."\n";

			show_form($values);

		}

		else

		{

			echo '<h1>Редактирование вакансии №'.$id.'</h1>'."\n";

			echo '<font color="#ff0000"><b>Ошибка:</b> вакансии с таким номером не существует</font>'."\n";

		}

		include('0-footer.inc');

	break;

}



//====================================================

// ФУНКЦИИ

//====================================================

// выводим отчет о действиях

function show_action_inform()

{

	global $action_inform;



	if($action_inform!='') echo '<p><font color="#ff0000"><b>Результат:</b> '.$action_inform.'</font>';

}

// выводим форму с данными

function show_form($values='', $errors='')

{

	global $db_users, $db_vacancie, $db_vacancie, $db_citys, $db_specialitys, $db_schedules;

	global $forms_size, $textarea_cols, $textarea_rows;



	// в значениях полей форм заменяем " на &quot;

	if($values != '') $values = formdata_preedit($values);

	?>



	<form name="updatedata_form" method="post" enctype="multipart/form-data" class=tform>



	<table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">

	<tr>

		<td valign="top" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>Шаг&nbsp;1:</b></div></td>

		<td valign="top" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>

		<td valign="top"><div class="text3"><b>&nbsp;Данные об интересующем соискателе</b></div></td>

	</tr>

	</table>



	<ul>





		Специальность<sup><font color="#ff0000">*</font></sup>:<br>

		<?

		// сообщение об ошибке

		if($errors!='' && isset($errors['speciality']))

			echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['speciality'].'</font><br>';

		?>

		<div class="note">(выберите нужную Вам специальность из списка)</div>

		<select class="ff" name="speciality_id">

		<?

		$rows = GetDB("SELECT * FROM ".$db_specialitys." ORDER BY speciality");

		echo "SELECT * FROM ".$db_specialitys." ORDER BY speciality";



		// была ошибка, выставляем то, что было выбрано ранее

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

		<div class="note">(если ничего подходящего не нашли, введи свою, но <b>не более 150 символов</b>)</div>

		<input type="text" name="speciality" class="ff" size="<?=$forms_size;?>" maxlength="150" value="<?if($values!='' && isset($values['speciality'])) echo $values['speciality'];?>"><br>









		Пол<sup><font color="#ff0000">*</font></sup>:<br>

		<?

			if($errors!='' && isset($errors['sex'])) echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['sex'].'</font><br>';

		?>

		<select class="ff" name="sex">

		<?

		$sex_0 = '';

		$sex_a = '';

		$sex_m = '';

		$sex_f = '';

		// была ошибка, выставляем то, что было выбрано ранее

		if($values!='' && isset($values['sex']))

		{

			$var='sex_'.$values['sex'];

			$$var= 'selected';

		}

		else

			$sex_0 = 'selected';



			echo "\t\t\t".'<option value="0" '.$sex_0.'>---'."\n";

			echo "\t\t\t".'<option value="a" '.$sex_a.'>не важно'."\n";

			echo "\t\t\t".'<option value="m" '.$sex_m.'>мужской'."\n";

			echo "\t\t\t".'<option value="f" '.$sex_f.'>женский'."\n";

		?>

		</select>

		<br>









		Возраст, от<sup><font color="#ff0000">*</font></sup>:<br>

		<?

			if($errors!='' && isset($errors['age_min'])) echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['age_min'].'</font><br>';

		?>

		<div class="note">(должно быть введено целое число)</div>

		<input type="text" name="age_min" class="ff" size="<?=$forms_size;?>" maxlength="3" value="<?if($values!='' && isset($values['age_min'])) echo $values['age_min'];?>"><br>









		Возраст, до<sup><font color="#ff0000">*</font></sup>:<br>

		<?

			if($errors!='' && isset($errors['age_max'])) echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['age_max'].'</font><br>';

		?>

		<div class="note">(должно быть введено целое число)</div>

		<input type="text" name="age_max" class="ff" size="<?=$forms_size;?>" maxlength="3" value="<?if($values!='' && isset($values['age_max'])) echo $values['age_max'];?>"><br>









		График работы<sup><font color="#ff0000">*</font></sup>:<br>

		<?

		// сообщение об ошибке

		if($errors!='' && isset($errors['schedule_id']))

			echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['schedule_id'].'</font><br>';

		?>

		<div class="note">(выберите нужный Вам график из списка)</div>

		<select class="ff" name="schedule_id">

		<?

		$rows = GetDB("SELECT * FROM ".$db_schedules);



		// была ошибка, выставляем то, что было выбрано ранее

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









		Минимальная заработная плата в руб.<sup><font color="#ff0000">*</font></sup>:<br>

		<?

			if($errors!='' && isset($errors['pay'])) echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['pay'].'</font><br>';

		?>

		<div class="note">(должно быть введено целое число)</div>

		<input type="text" name="pay" class="ff" size="<?=$forms_size;?>" maxlength="10" value="<?if($values!='' && isset($values['pay'])){ if($values['currency']==0){$col=$values['pay']*30;echo $col;}else{echo $values['pay'];}}?>"><br>









		Требования:<br>

		<?

			if($errors!='' && isset($errors['requirements'])) echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['requirements'].'</font><br>';

		?>

		<div class="note">(укажите Ваши требования к соискателю, не более 1000 символов)</div>

		<textarea name="requirements" rows="<?=$textarea_rows;?>" cols="<?=$textarea_cols;?>" class="ff"><?if($values!='' && isset($values['requirements'])) echo $values['requirements'];?></textarea><br>





	</ul>





	<p>





	<table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">

	<tr>

		<td valign="top" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>Шаг&nbsp;2:</b></div></td>

		<td valign="top" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>

		<td valign="top"><div class="text3"><b>&nbsp;Обновление данных</b></div></td>

	</tr>

	</table>



	<p><b>Важно:</b> поля отмеченные знаком '<sup><font color="#ff0000">*</font></sup>' обязательны для заполнения.

	<p><input type="hidden" name="id" value="<? echo $values['id']; ?>"><input type="hidden" name="action" value="do_update">

	<input type="submit" name="submit" value="Обновить данные" class="ff">



	</form>



	<?

}



// проверяем полученные данные

function check_vars($form_vars)

{

	$error='';



	if($form_vars['speciality']!='' && strlen($form_vars['speciality'])>150)

		$error['speciality']='Поле должно содержать на <b>'.(strlen($form_vars['speciality'])-150).'</b> символов меньше';

	elseif($form_vars['speciality']=='' && $form_vars['speciality_id']==0)

		$error['speciality']='Данное поле обязательно для заполнения';

	elseif($form_vars['speciality']=='' && !check_tblrow($GLOBALS['db_specialitys'], 'id', $form_vars['speciality_id']))

		$error['speciality']='Переданы недопустимые данные';



	if($form_vars['sex']!='m' && $form_vars['sex']!='f' && $form_vars['sex']!='a')

		$error['sex']='Данное поле обязательно для заполнения';



	if($form_vars['age_min']=='')

		$error['age_min']='Данное поле обязательно для заполнения';

	elseif(!check_integer($form_vars['age_min'], true) || $form_vars['age_min']>100)

		$error['age_min']='Указан некорректный возраст';



	if($form_vars['age_max']=='')

		$error['age_max']='Данное поле обязательно для заполнения';

	elseif($form_vars['age_max']<$form_vars['age_min'])

		$error['age_max']='Максимальный возраст не может быть меньше минимального';

	elseif(!check_integer($form_vars['age_max'], true) || $form_vars['age_max']>100)

		$error['age_max']='Указан некорректный возраст';



	if(!check_tblrow($GLOBALS['db_schedules'], 'id', $form_vars['schedule_id']))

		$error['schedule_id']='Переданы недопустимые данные';



	if($form_vars['pay']=='')

		$error['pay']='Данное поле обязательно для заполнения';

	elseif(!check_integer($form_vars['pay'], true) || $form_vars['pay']>9999999999)

		$error['pay']='Введена некорректная величина заработной платы';



	if(strlen($form_vars['requirements'])>1000)

		$error['requirements']='Поле должно содержать на <b>'.(strlen($form_vars['requirements'])-1000).'</b> символов меньше';



	return $error;

}

// обновляем данные

function update_data($msg_id, $user_id, $speciality_id, $sex, $age_min, $age_max, $schedule_id, $pay, $requirements)

{

	global $db_vacancie;



	$update = mysql_query("UPDATE $db_vacancie SET speciality_id='$speciality_id', sex='$sex', age_min='$age_min', age_max='$age_max', schedule_id='$schedule_id', pay='$pay', requirements='$requirements' WHERE id='$msg_id' and ruscable_user_id='$user_id'");

	if(!$update) return false;

	else return true;

}



//====================================================

?>