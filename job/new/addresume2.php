<?
$firtLevelMenuId=300;
$menuId=301;
include_once('0-includes.inc');
session_start();
$title='Добавить резюме';
$pagename='addresume';

//====================================================
// если пользователь не залогинен, то отсылаем его на страницу addresume.html
if(!$user_login || $_SESSION['user_type'] != 'seeker')
{
	Header("Location: addresume.html");
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
	// форма для добавления
	case 'show_form':
		include('0-header.inc');   // выводим верхнюю шапку
		show_form();               // выводим форму добавления файла
		include('0-footer.inc');   // выводим нижнюю шапку
	break;

	// добавляем
	case 'do_add':
		// принимаем данные
		// шаг 1: Данные об интересующей вакансии
		$form_vars['speciality_id'] = trim(strip_tags($HTTP_POST_VARS['speciality_id']));
		$form_vars['speciality']    = trim(strip_tags($HTTP_POST_VARS['speciality']));
		$form_vars['schedule_id']   = trim(strip_tags($HTTP_POST_VARS['schedule_id']));
		$form_vars['pay']           = trim(strip_tags($HTTP_POST_VARS['pay']));
		$form_vars['education']     = trim(htmlspecialchars($HTTP_POST_VARS['education']));
		$form_vars['experience']    = trim(htmlspecialchars($HTTP_POST_VARS['experience']));
		$form_vars['skill']         = trim(htmlspecialchars($HTTP_POST_VARS['skill']));
		// ID пользователя
        $user_dbid = $_SESSION['panel_user_id'];

		// проверяем данные
		$errors_arr = array();
		$values_arr = array();
		$check_form = check_vars($form_vars);

		// данные верны, добавляем
		if($check_form=='')
		{
			// отчет об ошибках во время добавления вакансии, направляемый администратору
			$error_log = array();
			// добавляем инфу во вспомогательные таблицы
			if($form_vars['speciality'] != '')
			{
				$add_speciality = add_simplerows($db_specialitys, 'id', 'speciality', $form_vars['speciality']);
				if($add_speciality) $form_vars['speciality_id'] = $add_speciality;
				else $error_log[] = 'Не удалось добавить новую специальность в таблицу';
			}
			// добавляем объявление
			$date = date("YmdHis");
			$ip   = $REMOTE_ADDR;
			$add_resume = add_resume($user_dbid, $form_vars['speciality_id'], $form_vars['schedule_id'], $form_vars['pay'], $form_vars['education'], $form_vars['experience'], $form_vars['skill'], $date, $ip);
			if($add_resume) $resume_id = $add_resume;
			else $error_log[] = 'Не удалось добавить резюме в таблицу';
			// выводим пользователю отчет
			if(count($error_log) == 0)
			{
				$action_inform='Ваше резюме добавлено в базу данных Job.RusCable.Ru';
				$msg=create_letter2($user_dbid, $form_vars, date("Y/m/d H:i"), 'newresume');
				letter_2_manager($msg, 'Новое резюме');
				include('0-header.inc');
				echo '<h1>Добавление резюме</h1>'."\n";
				show_action_inform();
				echo '<p>Постоянный адрес Вашего резюме:<br>'."\n";
				echo '<a href="showresume-'.$resume_id.'.html">http://job.ruscable.ru/showresume-'.$resume_id.'.html</a>'."\n";
				echo '<p><b>Благодарим за использование нашего сервиса</b>'."\n";
				include('0-footer.inc');
			}
			else
			{
				$action_inform='Извините, в данный момент добавление Вашего резюме невозможно. Сервис будет доступен в течении часа.';
				$to_admin = implode("\n", $error_log);
				letter_2_webmaster($to_admin);
				include('0-header.inc');
				echo '<h1>Добавление резюме</h1>'."\n";
				show_action_inform();
				echo '<p>Можем предложить Вам просмотреть <a href="showallvacancie.html">вакансии организаций</a>, размещенные на нашем сайте.'."\n";
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
			show_form($values, $errors);
			include('0-footer.inc');
		}

	break;

	// выводим форму для добавления
	default:
		include('0-header.inc');
		show_form();
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
// выводим форму добавления
function show_form($values='', $errors='')
{
	global $db_users_seeker, $db_users_employer, $db_resume, $db_vacancie, $db_citys, $db_specialitys, $db_schedules;
	global $forms_size, $textarea_cols, $textarea_rows;

	?>
	<h1>Добавить резюме</h1>

	<form name="addresume_form" method="post" enctype="multipart/form-data" action="<?=$GLOBALS['SCRIPT_NAME'];?>" class=tform>

	<table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">
	<tr>
		<td valign="top" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>Шаг&nbsp;1:</b></div></td>
		<td valign="top" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>
		<td valign="top"><div class="text3"><b>&nbsp;Данные об интересующей вакансии</b></div></td>
	</tr>
	</table>


	<ul>




		<li>Специальность<sup><font color="#ff0000">*</font></sup>:<br>
		<?
		// сообщение об ошибке
		if($errors!='' && isset($errors['speciality']))
			echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['speciality'].'</font><br>';
		?>
		<div class="note">(выберите нужную Вам специальность из списка)</div>
		<select class="ff" name="speciality_id">
		<?
		$rows = GetDB("SELECT * FROM ".$db_specialitys." where visible=1  ORDER BY speciality");
		//echo "SELECT * FROM ".$db_specialitys." ORDER BY speciality";

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
				echo "\t\t\t".'<option value="'.$rows[$i]['id'].'">'.ucfirst($rows[$i]['speciality'])."\n";
			else
				echo "\t\t\t".'<option value="'.$rows[$i]['id'].'" selected>'.ucfirst($rows[$i]['speciality'])."\n";
		}
		?>
		</select>
		<div class="note">(если ничего подходящего не нашли, введите свою, <b>не более 150 символов</b>)</div>
		<input type="text" name="speciality" class="ff" size="<?=$forms_size;?>" maxlength="150" value="<?if($values!='' && isset($values['speciality'])) echo $values['speciality'];?>"><br>




		<li>График работы<sup><font color="#ff0000">*</font></sup>:<br>
		<?
		// сообщение об ошибке
		if($errors!='' && isset($errors['schedule_id']))
			echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['schedule_id'].'</font><br>';
		?>
		<div class="note">(выберите подходящий Вам график из списка)</div>
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




		<li>Ожидаемая заработная плата в руб.<sup><font color="#ff0000">*</font></sup>:<br>
		<?
			if($errors!='' && isset($errors['pay'])) echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['pay'].'</font><br>';
		?>
		<div class="note">(должно быть введено целое число)</div>
		<input type="text" name="pay" class="ff" size="<?=$forms_size;?>" maxlength="10" value="<?if($values!='' && isset($values['pay'])) echo $values['pay'];?>"><br>




		<li>Образование<sup><font color="#ff0000">*</font></sup>:<br>
		<?
			if($errors!='' && isset($errors['education'])) echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['education'].'</font><br>';
		?>
		<div class="note">(укажите ваше образование, курсы повышения квалификации и т.д., не более 500 символов)</div>
		<textarea name="education" rows="<?=$textarea_rows;?>" cols="<?=$textarea_cols;?>" class="ff"><?if($values!='' && isset($values['education'])) echo $values['education'];?></textarea><br>




		<li>Опыт работы<sup><font color="#ff0000">*</font></sup>:<br>
		<?
			if($errors!='' && isset($errors['experience'])) echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['experience'].'</font><br>';
		?>
		<div class="note">(опыт работы по интересующей Вас специальности, либо смежной, не более 1000 символов)</div>
		<textarea name="experience" rows="<?=$textarea_rows;?>" cols="<?=$textarea_cols;?>" class="ff"><?if($values!='' && isset($values['experience'])) echo $values['experience'];?></textarea><br>




		<li>Профессиональные навыки<sup><font color="#ff0000">*</font></sup>:<br>
		<?
			if($errors!='' && isset($errors['skill'])) echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['skill'].'</font><br>';
		?>
		<div class="note">(владеете ли Вы компьютером, имеете ли водительские права и т.д., не более 500 символов)</div>
		<textarea name="skill" rows="<?=$textarea_rows;?>" cols="<?=$textarea_cols;?>" class="ff"><?if($values!='' && isset($values['skill'])) echo $values['skill'];?></textarea><br>




	</ul>



	<p>



<p><b>Важно:</b> поля отмеченные знаком &laquo;<font color="#ff0000">*</font>&raquo; обязательны для заполнения.
	<p><input type="hidden" name="action" value="do_add">
	<input type="submit" name="submit" value="Добавить резюме" class="ff">

	</form>

	<?
	echo ''."\n";
	echo ''."\n";
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

	if(!check_tblrow($GLOBALS['db_schedules'], 'id', $form_vars['schedule_id']))
		$error['schedule_id']='Переданы недопустимые данные';

	if($form_vars['pay']=='')
		$error['pay']='Данное поле обязательно для заполнения';
	elseif(!check_integer($form_vars['pay'], true) || $form_vars['pay']>9999999999)
		$error['pay']='Введена некорректная величина заработной платы';

	if($form_vars['education']=='')
		$error['education']='Данное поле обязательно для заполнения';
	elseif(strlen($form_vars['education'])>500)
		$error['education']='Поле должно содержать на <b>'.(strlen($form_vars['education'])-500).'</b> символов меньше';

	if($form_vars['experience']=='')
		$error['experience']='Данное поле обязательно для заполнения';
	elseif(strlen($form_vars['experience'])>1000)
		$error['experience']='Поле должно содержать на <b>'.(strlen($form_vars['experience'])-1000).'</b> символов меньше';

	if($form_vars['skill']=='')
		$error['skill']='Данное поле обязательно для заполнения';
	elseif(strlen($form_vars['skill'])>500)
		$error['skill']='Поле должно содержать на <b>'.(strlen($form_vars['skill'])-500).'</b> символов меньше';

	return $error;
}
// добавляем объявление
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