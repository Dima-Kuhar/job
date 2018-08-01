<?
//====================================================
// Общие функции
// Last update: 06.12.2004
//====================================================

// обрезает строку до $len символов, удаляет неполные слова в конце и убирает все теги
function cuttext($text,$len)
{
	$length=strlen($text);
	$txt=strip_tags($text,"<sub><sup>");
	if($length>$len)
	{
		$txt=substr($txt,0,$len);
	}
	$txt_arr=explode(" ",$txt);
	$txt_arr[(count($txt_arr)-1)]="";
	$txt=implode(" ",$txt_arr);
	$txt=trim($txt);
	if($txt=="") $txt=substr($text,0,50);
	return $txt;
}
// узнаем размер файла
function get_filesize($filename)
{
	$size=round(filesize($filename)/1000);
	//echo $size;
	return $size;
}
// в значениях полей форм заменяем " на &quot;
// на входе - ассоциативный массив
function formdata_preedit($assoc_arr)
{
	foreach($assoc_arr as $key => $value)
		$assoc_arr[$key] = str_replace('"','&quot;',$value);

	return $assoc_arr;
}
//====================================================
// преобразовывает байты в более удобный вид
function convert_size($bytes)
{
	if($bytes<1024)
	{
		return $bytes.'&nbsp;б';
	}
	elseif($bytes>1024 && $bytes<1048576)
	{
		$kb=round($bytes/1024);
		return $kb.'&nbsp;кб';
	}
	elseif($bytes>1048576)
	{
		$mb=round($bytes/1048576);
		return $mb.'&nbsp;Mб';
	}
	else
	{
		return $bytes;
	}
}
// преобразовывает время из формата timestamp в более удобный
function convert_timestamp($timestamp)
{
	$date = getdate($timestamp);
	$str  = sprintf("%02d:%02d",$date['hours'],$date['minutes']);
	$str .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	$str .= sprintf("%02d/%02d/%04d",$date['mday'],$date['mon'],$date['year']);
	return $str;
}
// преобразовывает время из формата sql_timestamp в более удобный
// параметр $type указывает тип отображения:
// timedate - время дата
// date     - только дата
function convert_sql_timestamp($sql_timestamp, $type='timedate')
{
/*	// MySQL 3.32
	$day   = substr($sql_timestamp,6,2);
	$month = substr($sql_timestamp,4,2);
	$year  = substr($sql_timestamp,0,4);

	$day   = $day."/".$month."/".$year;
	$time  = substr($sql_timestamp,8,2).":".substr($sql_timestamp,10,2);
*/	// MySQL 4
	$date1 = explode(" ", $sql_timestamp);
	$date2 = explode("-", $date1[0]);
	$date3 = explode(":", $date1[1]);

	$day   = $date2[2];
	$month = $date2[1];
	$year  = $date2[0];

	$hour  = $date3[0];
	$min   = $date3[1];
	$sec   = $date3[2];

	$day   = $day.".".$month.".".$year." г.";
	$time  = $hour.":".$min;

	$str = '';
	switch($type)
	{
		case 'timedate':
			//$str .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$str .= $day.", в ";
			$str .= $time;
		break;

		case 'date':
			$str .= $day;
		break;

		default:
			$str .= $day.", в ";
			$str .= $time;
			//$str .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

		break;
	}
	return $str;
}
// отправляет разработчику письмо с сообщением
function letter_2_webmaster($msg)
{
	global $cfg_site_name, $cfg_from_email, $cfg_webmaster_email;

	$title    = "=?windows-1251?b?".base64_encode("Системное сообщение с сайта $cfg_site_name")."?=";
	$headers  = "$cfg_site_name <$cfg_from_email>\n";
	$headers .= "Content-Type: text/plain; charset=windows-1251";

	//$title   = convert_cyr_string ($title,   'w', 'k');
	//$headers = convert_cyr_string ($headers, 'w', 'k');
	//$msg     = convert_cyr_string ($msg,     'w', 'k');
	$msg     = str_replace('«','"',$msg);
	$msg     = str_replace('»','"',$msg);
	$msg     = str_replace("\r","",$msg);

	@Mail($cfg_webmaster_email,$title,$msg,$headers);
	return true;
}
// отправляет письмо с уведомлением менеджерам
function letter_2_manager($msg, $title='без темы')
{
	global $cfg_site_name, $cfg_from_email, $cfg_manager_email;

	$title    = "=?windows-1251?b?".base64_encode("$cfg_site_name: $title")."?=";
	$headers  = trim("From: $cfg_site_name <$cfg_from_email>")."
Content-Type: text/plain; charset=windows-1251";

	//$title   = convert_cyr_string ($title,   'w', 'k');
	//$headers = convert_cyr_string ($headers, 'w', 'k');
	//$msg     = convert_cyr_string ($msg,     'w', 'k');
	//$msg     = str_replace('«','"',$msg);
	//$msg     = str_replace('»','"',$msg);
	//$msg     = str_replace("\r","",$msg);

	@mail($cfg_manager_email,$title,$msg,$headers);
//	@mail("manpwd@gmail.com",$title,$msg,$headers);
	return true;
}
// отправляет письмо с уведомлением юзерам
function letter_2_user($user_email, $msg, $title='без темы')
{
	global $cfg_site_name, $cfg_from_email;

	$title    = "=?windows-1251?b?".base64_encode("$cfg_site_name: $title")."?=";
	$headers  = trim("From: $cfg_site_name <$cfg_from_email>")."
Content-Type: text/plain; charset=windows-1251";

	//$title   = convert_cyr_string ($title,   'w', 'k');
	//$headers = convert_cyr_string ($headers, 'w', 'k');
	//$msg     = convert_cyr_string ($msg,     'w', 'k');
	//$msg     = str_replace('«','"',$msg);
	//$msg     = str_replace('»','"',$msg);
	//$msg     = str_replace("\r","",$msg);

	@Mail($user_email, $title, $msg, $headers);
	return true;
}
// формируем письмо юзеру при регистрации
function create_user_letter($form_vars, $auth_vars, $type)
{
	global $cfg_site_name, $cfg_from_email;

	$msg = '';
	if ($type == 'seeker')
	{
		$msg .= "Здравствуйте, ".$form_vars['name']."!\n\n";
		$msg .= "Вы разместили свое резюме на сайте $cfg_site_name.\n";
		$msg .= "Для дальнейшего управления Вашими резюме на нашем сайте\n";
		$msg .= "используйте данные указанные Вами при размещении резюме:\n\n";
		$msg .= "Логин:  ".$auth_vars['login']."\n";
		$msg .= "Пароль: ".$auth_vars['pass']."\n\n";
		$msg .= "------------------------------\n";
		$msg .= "Администрация $cfg_site_name\n";
		$msg .= "mailto:$cfg_from_email\n";
	}
	elseif($type == 'employer')
	{
		$msg .= "Здравствуйте, ".$form_vars['contact_person']."!\n\n";
		$msg .= "Вы разместили свою вакансию на сайте $cfg_site_name.\n";
		$msg .= "Для дальнейшего управления Вашими вакансиями на нашем сайте\n";
		$msg .= "используйте данные указанные Вами при размещении вакансии:\n\n";
		$msg .= "Логин:  ".$auth_vars['login']."\n";
		$msg .= "Пароль: ".$auth_vars['pass']."\n\n";
		$msg .= "------------------------------\n";
		$msg .= "Администрация $cfg_site_name\n";
		$msg .= "mailto:$cfg_from_email\n";
	}

	return $msg;
}
// формируем письмо с уведомлением менеджерам
function create_letter($form_vars, $date, $type)
{
	global $db_specialitys, $db_schedules, $db_citys;

	$msg = '';
	if ($type == 'newvacancie')
	{
		$speciality   = get_tblrow($db_specialitys, 'speciality', 'id', $form_vars['speciality_id']);
		$schedule     = get_tblrow($db_schedules, 'schedule', 'id', $form_vars['schedule_id']);
		$city         = get_tblrow($db_citys, 'city', 'id', $form_vars['city_id']);
		$requirements = wordwrap($form_vars['requirements'], 60, "\n");
		if($form_vars['sex']=='m') $sex='Мужчина';
		elseif($form_vars['sex']=='f') $sex='Женщина';
		elseif($form_vars['sex']=='a') $sex='Не важно';

		$msg .= "Новая вакансия ($date)\n\n";
		$msg .= "Специальность: $speciality\n";
		$msg .= "Пол:           $sex\n";
		$msg .= "Возраст:       от ".$form_vars['age_min']." до ".$form_vars['age_max']."\n";
		$msg .= "График работы: $schedule\n";
		$msg .= "Зарплата, руб.: ".$form_vars['pay']."\n";
		$msg .= "Требования:    \n$requirements\n";
		$msg .= "\n----------------\n";
		$msg .= "Организация:   ".$form_vars['name']."\n";
		$msg .= "Город:         $city\n";
		$msg .= "Конт. лицо:    ".$form_vars['contact_person']."\n";
		$msg .= "Телефон:       ".$form_vars['phone']."\n";
		$msg .= "E-mail:        ".$form_vars['email']."\n";
	}
	elseif ($type == 'newresume')
	{
		$speciality   = get_tblrow($db_specialitys, 'speciality', 'id', $form_vars['speciality_id']);
		$schedule     = get_tblrow($db_schedules, 'schedule', 'id', $form_vars['schedule_id']);
		$city         = get_tblrow($db_citys, 'city', 'id', $form_vars['city_id']);
		if($form_vars['sex']=='m') $sex='Мужчина';
		elseif($form_vars['sex']=='f') $sex='Женщина';
		elseif($form_vars['sex']=='a') $sex='Не важно';

		$msg .= "Новое резюме ($date)\n\n";
		$msg .= "Специальность: $speciality\n";
		$msg .= "График работы: $schedule\n";
		$msg .= "Зарплата, руб.: ".$form_vars['pay']."\n";
		$msg .= "Образование:   \n".$form_vars['education']."\n";
		$msg .= "Опыт работы:   \n".$form_vars['experience']."\n";
		$msg .= "Проф. навыки:  \n".$form_vars['skill']."\n";
		$msg .= "\n----------------\n";
		$msg .= "Ф.И.О.:        ".$form_vars['name']."\n";
		$msg .= "Пол:           $sex\n";
		$msg .= "Возраст:       ".$form_vars['age']."\n";
		$msg .= "Город:         $city\n";
		$msg .= "Телефон:       ".$form_vars['phone']."\n";
		$msg .= "E-mail:        ".$form_vars['email']."\n";
	}
	return $msg;
}
// фирмируем письмо с уведомлением менеджерам
// для залогиненых пользователей
function create_letter2($user_dbid, $form_vars, $date, $type)
{
	global $db_specialitys, $db_schedules, $db_citys;

	$msg = '';
	if ($type == 'newvacancie')
	{
		$speciality   = get_tblrow($db_specialitys, 'speciality', 'id', $form_vars['speciality_id']);
		$schedule     = get_tblrow($db_schedules, 'schedule', 'id', $form_vars['schedule_id']);
		$requirements = wordwrap($form_vars['requirements'], 60, "\n");
		if($form_vars['sex']=='m') $sex='Мужчина';
		elseif($form_vars['sex']=='f') $sex='Женщина';
		elseif($form_vars['sex']=='a') $sex='Не важно';

		$msg .= "Новая вакансия ($date)\n\n";
		$msg .= "Специальность: $speciality\n";
		$msg .= "Пол:           $sex\n";
		$msg .= "Возраст:       от ".$form_vars['age_min']." до ".$form_vars['age_max']."\n";
		$msg .= "График работы: $schedule\n";
		$msg .= "Зарплата, руб.: ".$form_vars['pay']."\n";
		$msg .= "Требования:    \n$requirements\n";
		$msg .= "\n----------------\n";
		$msg .= "Зарегистрированный пользователь\n";
		$msg .= "ID:            ".$user_dbid."\n";
		$msg .= "Login:         ".$_SESSION['user']."\n";
		$msg .= "Организация:   ".$_SESSION['user_name']."\n";
	}
	elseif ($type == 'newresume')
	{
		$speciality   = get_tblrow($db_specialitys, 'speciality', 'id', $form_vars['speciality_id']);
		$schedule     = get_tblrow($db_schedules, 'schedule', 'id', $form_vars['schedule_id']);

		$msg .= "Новое резюме ($date)\n\n";
		$msg .= "Специальность: $speciality\n";
		$msg .= "График работы: $schedule\n";
		$msg .= "Зарплата, руб.: ".$form_vars['pay']."\n";
		$msg .= "Образование:   \n".$form_vars['education']."\n";
		$msg .= "Опыт работы:   \n".$form_vars['experience']."\n";
		$msg .= "Проф. навыки:  \n".$form_vars['skill']."\n";
		$msg .= "\n----------------\n";
		$msg .= "Зарегистрированный пользователь\n";
		$msg .= "ID:            ".$user_dbid."\n";
		$msg .= "Login:         ".$_SESSION['user']."\n";
		$msg .= "Имя:           ".$_SESSION['user_name']."\n";
	}
	return $msg;
}
// добавляем инфу во вспомогательные таблицы
function add_simplerows($table, $id_col, $col, $row)
{
	$res = GetDB("SELECT $id_col FROM `$table` WHERE $col='$row'");
	if(count($res)>0)
	{
		$id = $res[0][$id_col];
		return $id;
	}
	else
	{
		if($table=="job_specialitys"){
			$add = mysql_query("INSERT INTO `$table` VALUES (NULL, '$row', 0)");
		}else{
			$add = mysql_query("INSERT INTO `$table` VALUES (NULL, '$row')");
		}
		if(!$add) return false;
		$res2 = GetDB("SELECT $id_col FROM `$table` WHERE $col='$row'");
		if(count($res2)>0)
		{
			$id = $res2[0][$id_col];
			return $id;
		}
		else
		{
			return false;
		}
	}
}
// проверка существования записи с указанным параметром в таблице
//    $table - имя таблицы
//    $col   - имя столбца
//    $row   - строка в данном столбце
function check_tblrow($table, $col, $row)
{
	$res = GetDB("SELECT $col FROM `$table` WHERE $col='$row'");
	if(count($res)>0) return true;
	else return false;
}
// получаем запись с указанным параметром из таблицы
//    $table     - имя таблицы
//    $col       - имя искомого столбца (может принимать значение '*',
//                 тогда будет возвращен массив)
//    $known_col - имя известного столбца
//    $row       - строка в известном столбце
function get_tblrow($table, $col, $known_col, $row)
{
	$res = GetDB("SELECT $col FROM `$table` WHERE $known_col='$row'");
	if(count($res)>0)
	{
		if($col == '*')
			return $res[0];
		else
			return $res[0][$col];
	}
	else return false;
}
// проверяет на целочисленность, работает со строками
// если $positive = true, то число должно быть еще и не отрицательным
function check_integer($val, $positive=false)
{
	if(is_numeric($val) && strpos($val, '.')==false)
		if(!$positive)
			return true;
		elseif($positive && $val>=0)
			return true;
		else
			return false;
	else
		return false;
}
// выводим мыло ява-скриптом
function js_email($email)
{
	if($email == '') return $email;

	$email_arr = explode('@', $email);
	$domen = $email_arr[1];
	$domen_arr = explode('.', $domen);

	$js_vars =  '';
	$js_vars .= 'n = "'.$email_arr[0].'"; '; // имя
	$js_vars .= 's = "@"; ';                 // @
	for($i=0; $i<count($domen_arr); $i++)    // домен по кусочкам
	{
		$js_vars .= 'd'.$i.' = "'.$domen_arr[$i].'"; ';
	}
	$js_mail = 'm=n+s';
	for($i=0; $i<count($domen_arr); $i++)
	{
		$js_mail .= '+d'.$i;
		if($i != (count($domen_arr)-1)) $js_mail .= '+"."';
	}

	$str =  "\n";
	$str .= '<script language="JavaScript">'."\n";
	$str .= '<!--'."\n";
	$str .= $js_vars."\n";
	$str .= $js_mail."\n";
	$str .= 'document.write("<a href=\"")'."\n";
	$str .= 'document.write("m"+"a"+"i"+"l"+"t"+"o"+":"+m)'."\n";
	$str .= 'document.write("\">"+m+"</a>")'."\n";
	$str .= '//-->'."\n";
	$str .= '</script>'."\n";

	return $str;
}
// выводим ссылки на другие страницы
// $page         - номер текущей страницы
// $filename     - имя файла
// $mod_rewrite  - использование mod_rewrite
// $pagevar_name - имя переменной со страницей
// $q_string     - дополнительные переменные (если необходимо), при $mod_rewrite=true не используется
function get_links($page, $filename, $mod_rewrite=false, $pagevar_name='page', $q_string='')
{
	global $rowsonpage, $linkblocksonpage;
	global $mysql_tablename;
	global $count_where;

	// узнаем общее количество записей
	$result=GetDB("SELECT count(*) FROM $mysql_tablename $count_where");
	$rows_num=$result[0]["count(*)"];

	// количество страниц
	$sets = ceil($rows_num/$rowsonpage);
	//echo "$sets = ceil($rows_num/$rowsonpage)<br>";
	// количество блоков ссылок на страницы
	$link_blocks = ceil($sets/$linkblocksonpage);
	// текущий блок
	$block = ceil($page/$linkblocksonpage);

	if($mod_rewrite)
	{
		$f_arr  = explode('.',$filename);
		$f_name = $f_arr[0];
		$f_ext  = $f_arr[1];
	}

	$str = '';
	if($sets>1)
	{
		//$str .= '<p align="center">';
		// формируем ссылки назад и дальше
		$prev_page = ($block-1)*$linkblocksonpage;
		$next_page = $block*$linkblocksonpage+1;
		if($mod_rewrite)
		{
			$prev = '<a href="'.$f_name.'-'.$prev_page.'.'.$f_ext.'">&lt;&lt;&lt;</a> ... ';
			$next = ' ... <a href="'.$f_name.'-'.$next_page.'.'.$f_ext.'">&gt;&gt;&gt;</a>';
		}
		elseif(!$mod_rewrite && $q_string!='')
		{
			$prev = '<a href="'.$filename.'?'.$pagevar_name.'='.$prev_page.'&'.$q_string.'">&lt;&lt;&lt;</a> ... ';
			$next = ' ... <a href="'.$filename.'?'.$pagevar_name.'='.$next_page.'&'.$q_string.'">&gt;&gt;&gt;</a>';
		}
		elseif(!$mod_rewrite && $q_string='')
		{
			$prev = '<a href="'.$filename.'?'.$pagevar_name.'='.$prev_page.'">&lt;&lt;&lt;</a> ... ';
			$next = ' ... <a href="'.$filename.'?'.$pagevar_name.'='.$next_page.'">&gt;&gt;&gt;</a>';
		}
		// самый первый блок
		if($block == 1)
		{
			$prev = '';
			if($link_blocks == 1) $next = '';
		}
		// самый последний блок
		elseif($block == $link_blocks)
		{
			if($link_blocks == 1) $prev = '';
			$next = '';
		}

		// формируем строку ссылок
		$str .= $prev;
		$for_min = ($block-1)*$linkblocksonpage+1;
		$for_max = $block*$linkblocksonpage;

		for($i = $for_min; $i <= $for_max; $i ++)
		{
			//echo "$i > $sets<br>";
			if($i > $sets) continue;
			//$start=($i-1)*$rowsonpage+1;
			//$end=$start+$rowsonpage-1;
			if($i==$sets) $end=$rows_num;
			if($i!=$page && $mod_rewrite)
				$str .= ' <a href="'.$f_name.'-'.$i.'.'.$f_ext.'">['.$i.']</a> ';
			elseif($i!=$page && !$mod_rewrite && $q_string!='')
				$str .= ' <a href="'.$filename.'?'.$pagevar_name.'='.$i.'&'.$q_string.'">['.$i.']</a> ';
			elseif($i!=$page && !$mod_rewrite && $q_string=='')
				$str .= ' <a href="'.$filename.'?'.$pagevar_name.'='.$i.'">['.$i.']</a> ';
			else
				$str .= " <font color=\"#ff0000\"><b>[$i]</b></font> ";
		}
		$str .= $next;
	}
	return $str;
}

function getJobUser(){

    global $db_users;
    $result = false;

    $query = mysql_query("SELECT type FROM ".$db_users." WHERE ruscable_user_id=".$_SESSION['panel_user_id'].";");
    if(mysql_num_rows($query) > 0){
        $result = mysql_fetch_array($query);
    }

    return $result;
}

function insertJobUser(){
    global $db_users;
    $sql = "INSERT INTO `".$db_users."` SET ruscable_user_id=".$_SESSION['panel_user_id'].", type='".$_SESSION['user_type']."';";
    mysql_query($sql);

    return true;
}

function initUser()
{
    if(!isset($_SESSION['login']))
        return false;

    $jobUser = getJobUser();
    if($jobUser)
        $_SESSION['user_type'] = $jobUser['type'];
    else
        insertJobUser();
}


//====================================================
?>