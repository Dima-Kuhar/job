<?
//====================================================
// ����� �������
// Last update: 06.12.2004
//====================================================

// �������� ������ �� $len ��������, ������� �������� ����� � ����� � ������� ��� ����
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
// ������ ������ �����
function get_filesize($filename)
{
	$size=round(filesize($filename)/1000);
	//echo $size;
	return $size;
}
// � ��������� ����� ���� �������� " �� &quot;
// �� ����� - ������������� ������
function formdata_preedit($assoc_arr)
{
	foreach($assoc_arr as $key => $value)
		$assoc_arr[$key] = str_replace('"','&quot;',$value);

	return $assoc_arr;
}
//====================================================
// ��������������� ����� � ����� ������� ���
function convert_size($bytes)
{
	if($bytes<1024)
	{
		return $bytes.'&nbsp;�';
	}
	elseif($bytes>1024 && $bytes<1048576)
	{
		$kb=round($bytes/1024);
		return $kb.'&nbsp;��';
	}
	elseif($bytes>1048576)
	{
		$mb=round($bytes/1048576);
		return $mb.'&nbsp;M�';
	}
	else
	{
		return $bytes;
	}
}
// ��������������� ����� �� ������� timestamp � ����� �������
function convert_timestamp($timestamp)
{
	$date = getdate($timestamp);
	$str  = sprintf("%02d:%02d",$date['hours'],$date['minutes']);
	$str .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	$str .= sprintf("%02d/%02d/%04d",$date['mday'],$date['mon'],$date['year']);
	return $str;
}
// ��������������� ����� �� ������� sql_timestamp � ����� �������
// �������� $type ��������� ��� �����������:
// timedate - ����� ����
// date     - ������ ����
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

	$day   = $day.".".$month.".".$year." �.";
	$time  = $hour.":".$min;

	$str = '';
	switch($type)
	{
		case 'timedate':
			//$str .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$str .= $day.", � ";
			$str .= $time;
		break;

		case 'date':
			$str .= $day;
		break;

		default:
			$str .= $day.", � ";
			$str .= $time;
			//$str .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

		break;
	}
	return $str;
}
// ���������� ������������ ������ � ����������
function letter_2_webmaster($msg)
{
	global $cfg_site_name, $cfg_from_email, $cfg_webmaster_email;

	$title    = "=?windows-1251?b?".base64_encode("��������� ��������� � ����� $cfg_site_name")."?=";
	$headers  = "$cfg_site_name <$cfg_from_email>\n";
	$headers .= "Content-Type: text/plain; charset=windows-1251";

	//$title   = convert_cyr_string ($title,   'w', 'k');
	//$headers = convert_cyr_string ($headers, 'w', 'k');
	//$msg     = convert_cyr_string ($msg,     'w', 'k');
	$msg     = str_replace('�','"',$msg);
	$msg     = str_replace('�','"',$msg);
	$msg     = str_replace("\r","",$msg);

	@Mail($cfg_webmaster_email,$title,$msg,$headers);
	return true;
}
// ���������� ������ � ������������ ����������
function letter_2_manager($msg, $title='��� ����')
{
	global $cfg_site_name, $cfg_from_email, $cfg_manager_email;

	$title    = "=?windows-1251?b?".base64_encode("$cfg_site_name: $title")."?=";
	$headers  = trim("From: $cfg_site_name <$cfg_from_email>")."
Content-Type: text/plain; charset=windows-1251";

	//$title   = convert_cyr_string ($title,   'w', 'k');
	//$headers = convert_cyr_string ($headers, 'w', 'k');
	//$msg     = convert_cyr_string ($msg,     'w', 'k');
	//$msg     = str_replace('�','"',$msg);
	//$msg     = str_replace('�','"',$msg);
	//$msg     = str_replace("\r","",$msg);

	@mail($cfg_manager_email,$title,$msg,$headers);
//	@mail("manpwd@gmail.com",$title,$msg,$headers);
	return true;
}
// ���������� ������ � ������������ ������
function letter_2_user($user_email, $msg, $title='��� ����')
{
	global $cfg_site_name, $cfg_from_email;

	$title    = "=?windows-1251?b?".base64_encode("$cfg_site_name: $title")."?=";
	$headers  = trim("From: $cfg_site_name <$cfg_from_email>")."
Content-Type: text/plain; charset=windows-1251";

	//$title   = convert_cyr_string ($title,   'w', 'k');
	//$headers = convert_cyr_string ($headers, 'w', 'k');
	//$msg     = convert_cyr_string ($msg,     'w', 'k');
	//$msg     = str_replace('�','"',$msg);
	//$msg     = str_replace('�','"',$msg);
	//$msg     = str_replace("\r","",$msg);

	@Mail($user_email, $title, $msg, $headers);
	return true;
}
// ��������� ������ ����� ��� �����������
function create_user_letter($form_vars, $auth_vars, $type)
{
	global $cfg_site_name, $cfg_from_email;

	$msg = '';
	if ($type == 'seeker')
	{
		$msg .= "������������, ".$form_vars['name']."!\n\n";
		$msg .= "�� ���������� ���� ������ �� ����� $cfg_site_name.\n";
		$msg .= "��� ����������� ���������� ������ ������ �� ����� �����\n";
		$msg .= "����������� ������ ��������� ���� ��� ���������� ������:\n\n";
		$msg .= "�����:  ".$auth_vars['login']."\n";
		$msg .= "������: ".$auth_vars['pass']."\n\n";
		$msg .= "------------------------------\n";
		$msg .= "������������� $cfg_site_name\n";
		$msg .= "mailto:$cfg_from_email\n";
	}
	elseif($type == 'employer')
	{
		$msg .= "������������, ".$form_vars['contact_person']."!\n\n";
		$msg .= "�� ���������� ���� �������� �� ����� $cfg_site_name.\n";
		$msg .= "��� ����������� ���������� ������ ���������� �� ����� �����\n";
		$msg .= "����������� ������ ��������� ���� ��� ���������� ��������:\n\n";
		$msg .= "�����:  ".$auth_vars['login']."\n";
		$msg .= "������: ".$auth_vars['pass']."\n\n";
		$msg .= "------------------------------\n";
		$msg .= "������������� $cfg_site_name\n";
		$msg .= "mailto:$cfg_from_email\n";
	}

	return $msg;
}
// ��������� ������ � ������������ ����������
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
		if($form_vars['sex']=='m') $sex='�������';
		elseif($form_vars['sex']=='f') $sex='�������';
		elseif($form_vars['sex']=='a') $sex='�� �����';

		$msg .= "����� �������� ($date)\n\n";
		$msg .= "�������������: $speciality\n";
		$msg .= "���:           $sex\n";
		$msg .= "�������:       �� ".$form_vars['age_min']." �� ".$form_vars['age_max']."\n";
		$msg .= "������ ������: $schedule\n";
		$msg .= "��������, ���.: ".$form_vars['pay']."\n";
		$msg .= "����������:    \n$requirements\n";
		$msg .= "\n----------------\n";
		$msg .= "�����������:   ".$form_vars['name']."\n";
		$msg .= "�����:         $city\n";
		$msg .= "����. ����:    ".$form_vars['contact_person']."\n";
		$msg .= "�������:       ".$form_vars['phone']."\n";
		$msg .= "E-mail:        ".$form_vars['email']."\n";
	}
	elseif ($type == 'newresume')
	{
		$speciality   = get_tblrow($db_specialitys, 'speciality', 'id', $form_vars['speciality_id']);
		$schedule     = get_tblrow($db_schedules, 'schedule', 'id', $form_vars['schedule_id']);
		$city         = get_tblrow($db_citys, 'city', 'id', $form_vars['city_id']);
		if($form_vars['sex']=='m') $sex='�������';
		elseif($form_vars['sex']=='f') $sex='�������';
		elseif($form_vars['sex']=='a') $sex='�� �����';

		$msg .= "����� ������ ($date)\n\n";
		$msg .= "�������������: $speciality\n";
		$msg .= "������ ������: $schedule\n";
		$msg .= "��������, ���.: ".$form_vars['pay']."\n";
		$msg .= "�����������:   \n".$form_vars['education']."\n";
		$msg .= "���� ������:   \n".$form_vars['experience']."\n";
		$msg .= "����. ������:  \n".$form_vars['skill']."\n";
		$msg .= "\n----------------\n";
		$msg .= "�.�.�.:        ".$form_vars['name']."\n";
		$msg .= "���:           $sex\n";
		$msg .= "�������:       ".$form_vars['age']."\n";
		$msg .= "�����:         $city\n";
		$msg .= "�������:       ".$form_vars['phone']."\n";
		$msg .= "E-mail:        ".$form_vars['email']."\n";
	}
	return $msg;
}
// ��������� ������ � ������������ ����������
// ��� ����������� �������������
function create_letter2($user_dbid, $form_vars, $date, $type)
{
	global $db_specialitys, $db_schedules, $db_citys;

	$msg = '';
	if ($type == 'newvacancie')
	{
		$speciality   = get_tblrow($db_specialitys, 'speciality', 'id', $form_vars['speciality_id']);
		$schedule     = get_tblrow($db_schedules, 'schedule', 'id', $form_vars['schedule_id']);
		$requirements = wordwrap($form_vars['requirements'], 60, "\n");
		if($form_vars['sex']=='m') $sex='�������';
		elseif($form_vars['sex']=='f') $sex='�������';
		elseif($form_vars['sex']=='a') $sex='�� �����';

		$msg .= "����� �������� ($date)\n\n";
		$msg .= "�������������: $speciality\n";
		$msg .= "���:           $sex\n";
		$msg .= "�������:       �� ".$form_vars['age_min']." �� ".$form_vars['age_max']."\n";
		$msg .= "������ ������: $schedule\n";
		$msg .= "��������, ���.: ".$form_vars['pay']."\n";
		$msg .= "����������:    \n$requirements\n";
		$msg .= "\n----------------\n";
		$msg .= "������������������ ������������\n";
		$msg .= "ID:            ".$user_dbid."\n";
		$msg .= "Login:         ".$_SESSION['user']."\n";
		$msg .= "�����������:   ".$_SESSION['user_name']."\n";
	}
	elseif ($type == 'newresume')
	{
		$speciality   = get_tblrow($db_specialitys, 'speciality', 'id', $form_vars['speciality_id']);
		$schedule     = get_tblrow($db_schedules, 'schedule', 'id', $form_vars['schedule_id']);

		$msg .= "����� ������ ($date)\n\n";
		$msg .= "�������������: $speciality\n";
		$msg .= "������ ������: $schedule\n";
		$msg .= "��������, ���.: ".$form_vars['pay']."\n";
		$msg .= "�����������:   \n".$form_vars['education']."\n";
		$msg .= "���� ������:   \n".$form_vars['experience']."\n";
		$msg .= "����. ������:  \n".$form_vars['skill']."\n";
		$msg .= "\n----------------\n";
		$msg .= "������������������ ������������\n";
		$msg .= "ID:            ".$user_dbid."\n";
		$msg .= "Login:         ".$_SESSION['user']."\n";
		$msg .= "���:           ".$_SESSION['user_name']."\n";
	}
	return $msg;
}
// ��������� ���� �� ��������������� �������
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
// �������� ������������� ������ � ��������� ���������� � �������
//    $table - ��� �������
//    $col   - ��� �������
//    $row   - ������ � ������ �������
function check_tblrow($table, $col, $row)
{
	$res = GetDB("SELECT $col FROM `$table` WHERE $col='$row'");
	if(count($res)>0) return true;
	else return false;
}
// �������� ������ � ��������� ���������� �� �������
//    $table     - ��� �������
//    $col       - ��� �������� ������� (����� ��������� �������� '*',
//                 ����� ����� ��������� ������)
//    $known_col - ��� ���������� �������
//    $row       - ������ � ��������� �������
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
// ��������� �� ���������������, �������� �� ��������
// ���� $positive = true, �� ����� ������ ���� ��� � �� �������������
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
// ������� ���� ���-��������
function js_email($email)
{
	if($email == '') return $email;

	$email_arr = explode('@', $email);
	$domen = $email_arr[1];
	$domen_arr = explode('.', $domen);

	$js_vars =  '';
	$js_vars .= 'n = "'.$email_arr[0].'"; '; // ���
	$js_vars .= 's = "@"; ';                 // @
	for($i=0; $i<count($domen_arr); $i++)    // ����� �� ��������
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
// ������� ������ �� ������ ��������
// $page         - ����� ������� ��������
// $filename     - ��� �����
// $mod_rewrite  - ������������� mod_rewrite
// $pagevar_name - ��� ���������� �� ���������
// $q_string     - �������������� ���������� (���� ����������), ��� $mod_rewrite=true �� ������������
function get_links($page, $filename, $mod_rewrite=false, $pagevar_name='page', $q_string='')
{
	global $rowsonpage, $linkblocksonpage;
	global $mysql_tablename;
	global $count_where;

	// ������ ����� ���������� �������
	$result=GetDB("SELECT count(*) FROM $mysql_tablename $count_where");
	$rows_num=$result[0]["count(*)"];

	// ���������� �������
	$sets = ceil($rows_num/$rowsonpage);
	//echo "$sets = ceil($rows_num/$rowsonpage)<br>";
	// ���������� ������ ������ �� ��������
	$link_blocks = ceil($sets/$linkblocksonpage);
	// ������� ����
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
		// ��������� ������ ����� � ������
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
		// ����� ������ ����
		if($block == 1)
		{
			$prev = '';
			if($link_blocks == 1) $next = '';
		}
		// ����� ��������� ����
		elseif($block == $link_blocks)
		{
			if($link_blocks == 1) $prev = '';
			$next = '';
		}

		// ��������� ������ ������
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
//====================================================
?>