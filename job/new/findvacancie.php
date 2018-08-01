<?
$firtLevelMenuId=100;
$menuId=100;
$fvac=1;
include_once('0-includes.inc');



$title='Найти вакансию';

$pagename='findvacancie';



//====================================================

// ссылок на странице

$rowsonpage=10;

$linkblocksonpage=10;

// имя файлов в ссылках

$link_filename='findvacancie';

// если номер страницы не определен, значит первая страница

if(!isset($page)) $page=1;

else settype($page,"integer");

//====================================================

// если действие не определено, то нет действия

if(!isset($action)) $action='';

// пока никаких отчетов о действиях не было

$action_inform='';

//====================================================



db_connect();



include('0-header.inc');

// действия

switch($action)

{

	// выводим форму для запроса

	case 'show_search_form':

		show_search_form();

	break;



	// ищем

	case 'search':

		// принимаем данные

		$form_vars['keywords']      = trim(strip_tags(mysql_real_escape_string($HTTP_GET_VARS['keywords'])));

		$form_vars['schedule_id']   = trim(strip_tags(mysql_real_escape_string($HTTP_GET_VARS['schedule_id'])));

		$form_vars['pay']           = intval(trim(strip_tags(mysql_real_escape_string($HTTP_GET_VARS['pay']))));

		$form_vars['sex']           = trim(strip_tags(mysql_real_escape_string($HTTP_GET_VARS['sex'])));

		$form_vars['age']           = trim(strip_tags(mysql_real_escape_string($HTTP_GET_VARS['age'])));

		$form_vars['city_id']       = intval(trim(strip_tags(mysql_real_escape_string($HTTP_GET_VARS['city_id']))));

		$form_vars['lastdate']      = trim(strip_tags(mysql_real_escape_string($HTTP_GET_VARS['lastdate'])));



		// проверяем данные

		$errors_arr = array();

		$values_arr = array();

		$check_form = check_vars($form_vars);



		// данные верны

		if($check_form == '')

		{

			// составляем запрос

			$query           = prepare_query($form_vars);


			$res             = GetDB($query);

			$q_parts         = prepare_query($form_vars, 'inparts');

			$mysql_tablename = $q_parts['tables'];

			$count_where     = " WHERE ".$q_parts['condition'];

			$q_string        = preg_replace("~^page=\d+&~", "", $_SERVER["QUERY_STRING"]);

			$links           = get_links($page, $link_filename, false, 'page', $q_string);

			// что-то нашли

			if(count($res)>0)

			{

				echo '<h1>ПОИСК ВАКАНСИЙ</h1>'."\n";

				?>

				<table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">

				<tr>

					<td valign="middle" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>Вакансии:</b></div></td>

					<td valign="middle" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>

					<td valign="middle"><div class="text3"><b>&nbsp;<?echo $links;?></b></div></td>

				</tr>

				</table>
				<div style='padding: 6px 0px 0px 6px;'>
				<table width=100%><tr><td width=50% valign=top style='padding-right: 10px;'>
				<?

				show_results($res);

				?>
				</td><td width=50% valign=top style='padding: 10px 0px 0px 10px;'><div style='min-height:500px;'>
				<!--iframe frameBorder=no name="preview" align=right
				style='max-width:450px; width:450px; min-height:600px; height=100%;'
				scrolling="auto" src="/blank.html"></iframe-->
				</div>
				</td></tr></table>
				</div>
				<table border="0" width="100%" height="25" cellpadding="4" cellspacing="0" background="/images/bg-top02-0.gif">

				<tr>

					<td valign="middle" width="120" background="/images/bg-top02-0.gif"><div class="text2"><b>Вакансии:</b></div></td>

					<td valign="middle" width="2" background="/images/bg-top02-0.gif"><img src="/images/empty.gif" width="2" height="1" border="0" alt=""></td>

					<td valign="middle"><div class="text3"><b>&nbsp;<?echo $links;?></b></div></td>

				</tr>

				</table>

				<?

				echo '<br><p><a style="font-size: 105%;" href="findvacancie.html">Новый поиск</a>';

			}

			// ничего не найдено

			else

			{

				echo '<h1>ПОИСК ВАКАНСИЙ</h1>'."\n";

				echo '<p><font color="#ff0000"><b>Извините, но объявлений с указанными Вами параметрами не найдено.</b></font>';

				echo '<p><a href="findvacancie.html">Попробуйте еще раз</a>';

			}

		}

		else

		{

			$action_inform='Неправильно введены данные';

			if($check_form=='')

				$check_form=array();

			$errors = $check_form;

			$values = $form_vars;

			show_search_form($values, $errors);

		}

	break;



	// выводим форму для запроса

	default:

		show_search_form();

	break;

}

include('0-footer.inc');



//====================================================

// ФУНКЦИИ

//====================================================

// выводим форму для запроса

function show_search_form($values='', $errors='')

{

	global $db_users_seeker, $db_users_employer, $db_resume, $db_vacancie, $db_citys, $db_specialitys, $db_schedules;

	global $forms_size, $textarea_cols, $textarea_rows;



	?>

	<h1>ПОИСК ВАКАНСИЙ</h1>



	<form name="search_form" method="get" enctype="multipart/form-data" action="<?=$GLOBALS['SCRIPT_NAME'];?>" class=tform>





		Ключевые слова:<br>

		<?

			if($errors!='' && isset($errors['keywords'])) echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['keywords'].'</font><br>';

		?>

		<div class="note">(не более 150 символов)</div>

		<input type="text" name="keywords" class="ff" size="<?=$forms_size;?>" maxlength="150" value="<?if($values!='' && isset($values['pay'])) echo $values['keywords'];?>"><br>









		График работы:<br>

		<?

			if($errors!='' && isset($errors['schedule_id'])) echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['schedule_id'].'</font><br>';

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

			$cheked = 1;



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









		Ожидаемая заработная плата в руб., не менее:<br>

		<?

			if($errors!='' && isset($errors['pay'])) echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['pay'].'</font><br>';

		?>

		<div class="note">(должно быть введено целое число)</div>

		<input type="text" name="pay" class="ff" size="<?=$forms_size;?>" maxlength="10" value="<?if($values!='' && isset($values['pay'])) echo $values['pay'];?>"><br>









		Пол:<br>

		<?

			if($errors!='' && isset($errors['sex'])) echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['sex'].'</font><br>';

		?>

		<select class="ff" name="sex">

		<?

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



			echo "\t\t\t".'<option value="a" '.$sex_a.'>не важно'."\n";

			echo "\t\t\t".'<option value="m" '.$sex_m.'>мужской'."\n";

			echo "\t\t\t".'<option value="f" '.$sex_f.'>женский'."\n";

		?>

		</select>

		<br>









		Возраст:<br>

		<?

			if($errors!='' && isset($errors['age'])) echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['age'].'</font><br>';

		?>

		<div class="note">(должно быть введено целое число)</div>

		<input type="text" name="age" class="ff" size="<?=$forms_size;?>" maxlength="3" value="<?if($values!='' && isset($values['age'])) echo $values['age'];?>"><br>









		Город:<br>

		<?

			if($errors!='' && isset($errors['city_id'])) echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['city_id'].'</font><br>';

		?>

		<div class="note">(выберите Ваш город из списка)</div>

		<select class="ff" name="city_id">

		<?

		$rows = GetDB("SELECT * FROM ".$db_citys." where id not in(82,524) ORDER BY city");



		// была ошибка, выставляем то, что было выбрано ранее

		if($values!='' && isset($values['city_id']))

			$cheked = $values['city_id'];

		else

			$cheked = '';



		if($cheked == '' || $cheked == 0)

			echo "\t\t\t".'<option value="0" selected>не важно'."\n";
			echo  "<option value=82 "; if($cheked==82){echo " selected";} echo ">Москва</option>";
		echo  "<option value=524 "; if($cheked==524){echo " selected";} echo ">Санкт-Петербург</option>";
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









		<br>Предложения:<br>

		<?

			if($errors!='' && isset($errors['lastdate'])) echo '<font color="#ff0000"><b>Ошибка:</b> '.$errors['lastdate'].'</font><br>';

		?>

		<select class="ff" name="lastdate">

		<?

		$lastdate_0 = '';

		$lastdate_168 = '';

		$lastdate_336 = '';

		$lastdate_720 = '';

		// была ошибка, выставляем то, что было выбрано ранее

		if($values!='' && isset($values['lastdate']))

		{

			$var='lastdate_'.$values['sex'];

			$$var= 'selected';

		}

		else

			$sex_0 = 'selected';



			echo "\t\t\t".'<option value="0" '.$lastdate_0.'>все'."\n";

			echo "\t\t\t".'<option value="168" '.$lastdate_168.'>за последнюю неделю'."\n";

			echo "\t\t\t".'<option value="336" '.$lastdate_336.'>за последние 2 недели'."\n";

			echo "\t\t\t".'<option value="720" '.$lastdate_720.'>за последний месяц'."\n";

		?>

		</select>





		<br><br><br><input type="submit" name="submit" value="   Поиск   " class="ff">

		<input type="hidden" name="action" value="search">





	</form>



	<?

}

// проверяем полученные данные

function check_vars($form_vars)

{

	$error = '';



	if(strlen($form_vars['keywords'])>150)

		$error['keywords']='Поле должно содержать на <b>'.(strlen($form_vars['keywords'])-150).'</b> символов меньше';



	if(!check_tblrow($GLOBALS['db_schedules'], 'id', $form_vars['schedule_id']))

		$error['schedule_id']='Переданы недопустимые данные';



	if($form_vars['pay']!='' && !check_integer($form_vars['pay'], true) || $form_vars['pay']>9999999999)

		$error['pay']='Введена некорректная величина заработной платы';



	if($form_vars['sex']!='m' && $form_vars['sex']!='f' && $form_vars['sex']!='a')

		$error['sex']='Вы не указали свой пол';



	if($form_vars['age']!='' && !check_integer($form_vars['age'], true) || $form_vars['age']>100)

		$error['age']='Указан некорректный возраст';



	if(!check_tblrow($GLOBALS['db_citys'], 'id', $form_vars['city_id']) && $form_vars['city_id']!=0)

		$error['city_id']='Переданы недопустимые данные';



	if($form_vars['lastdate']!='0' && $form_vars['lastdate']!='168' && $form_vars['lastdate']!='336' && $form_vars['lastdate']!='720')

		$error['lastdate']='Вы не указали нужное количество объявлений';



	return $error;

}

// составляем запрос

function prepare_query($form_vars, $inparts='')

{

	global $db_users, $db_vacancie;

	global $db_citys, $db_specialitys;

	global $page, $rowsonpage;

	$fields    = "$db_vacancie.id, $db_specialitys.speciality, $db_users.name, $db_citys.city, $db_vacancie.pay, $db_vacancie.date, $db_vacancie.currency";
	$tables    = "$db_vacancie, $db_users, $db_citys, $db_specialitys";
	$condition = "$db_vacancie.ruscable_user_id = $db_users.ruscable_user_id and $db_vacancie.speciality_id = $db_specialitys.id and $db_users.city_id = $db_citys.id";

	// лимит

	$from  = ($page-1)*$rowsonpage;

	$limit = "$from,$rowsonpage";



	// ключевые слова

	if($form_vars['keywords'] != '')

	{

		$words = explode(' ', $form_vars['keywords']);

		$condition .= " and (";

		for($i=0; $i<count($words); $i++)

		{

			$words[$i] = addslashes($words[$i]);

			if($i != 0) $condition .= " or ";

			$condition .= "$db_specialitys.speciality LIKE '%".$words[$i]."%'";

			$condition .= " or $db_vacancie.requirements LIKE '%".$words[$i]."%'";

		}

		$condition .= ")";

	}

	// график

	if($form_vars['schedule_id'] != 1)

		$condition .= " and ($db_vacancie.schedule_id='".$form_vars['schedule_id']."' or $db_vacancie.schedule_id='1')";

	// з/п

	if($form_vars['pay'] != '')

		if($form_vars['pay']==0)

			$condition .= " and $db_vacancie.pay>'".$form_vars['pay']."'";

				else

			$condition .= " and $db_vacancie.pay>='".$form_vars['pay']."'";

	// пол

	if($form_vars['sex'] != 'a')

		$condition .= " and ($db_vacancie.sex='".$form_vars['sex']."' or $db_vacancie.sex='a')";

	// возраст

	if($form_vars['age'] != '')

		$condition .= " and $db_vacancie.age_min<='".$form_vars['age']."' and $db_vacancie.age_max>='".$form_vars['age']."'";

	// город

	if($form_vars['city_id'] != 0)

		$condition .= " and $db_users.city_id='".$form_vars['city_id']."'";

	// срок

	if($form_vars['lastdate'] != 0)

		$condition .= " and $db_vacancie.date>'".date("Y-m-d 00:00:00", (time()-$form_vars['lastdate']*60*60))."'";



	if($inparts == 'inparts')

	{

		$query['fields']    = $fields;

		$query['tables']    = $tables;

		$query['condition'] = $condition;

		$query['limit']     = $limit;

	}

	else

		$query = "SELECT $fields FROM $tables WHERE $condition ORDER BY date DESC LIMIT $limit";



	return $query;

}

// выводим результат запроса

function show_results($rows)

{

	global $page, $rowsonpage;



	$from  = ($page-1)*$rowsonpage;

	echo '<ol start='.($from+1).'>'."\n";

	for ($i=0;$i<count($rows);$i++)

	{

		echo "\t".'<li><a style="font-size: 105%;" href="showvacancie-'.$rows[$i]['id'].'.html"><b>'.ucfirst($rows[$i]['speciality']).'</b></a><br>'."\n";

		echo "\t".$rows[$i]['name'].', город '.$rows[$i]['city'].'<br>'."\n";



		if ($rows[$i]['pay']>0){
			if($rows[$i]['currency']==1){
				$col=$rows[$i]['pay'];
			}else{
				$col=$rows[$i]['pay']*30;
			}

		 echo "\t".'<b>Зарплата:</b> от '.$col.' руб.<br>'."\n";
		}else echo "\t".'<b>Зарплата:</b> по результатам собеседования<br>'."\n";

		echo "\t".'<b>Дата размещения:</b> '.convert_sql_timestamp($rows[$i]['date']).'<br><br>'."\n";

	}

	echo '</ol>'."\n";

}

?>