<?
//====================================================
// Engine file for admin module
// Last update: 28.01.2005
// Updated 28.01.2005: В SQLTIMESTAMP закомментировал
//         совместимость в MySQL 3.23, оставил 4
// Updated: Можно ставить тип SQLTIMESTAMP
//====================================================

//====================================================
// АВТОМАТИЧЕСКИ ГЕНЕРИРУЕМЫЕ ПЕРЕМЕННЫЕ
//====================================================

// Количество элементов массива $db_fields
$db_fields_num=count($db_fields);
// Преобразовываем массив $db_fields в такой же, но с ассоциативным массивом второго уровня
$db_fields_assoc=db_fields_to_assoc();

//====================================================
// РАБОЧАЯ ОБЛАСТЬ
//====================================================

db_connect();

// если номер страницы не определен, значит первая страница
if(!isset($page)) $page=1;
else settype($page,"integer");

// если действие не определено, то нет действия
if(!isset($admin_action)) $admin_action="";

// действия
switch($admin_action)
{
	// форма для добавления записи
	case 'form_add':
		include("$DOCUMENT_ROOT/$document_admin/top.php");      // выводим верхнюю шапку
		show_menu($admin_action);                     // выводим меню раздела
		show_form("form_add");                        // выводим форму добавления записи
		include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // выводим нижнюю шапку
		break;

	// форма для редактирования записи
	case 'form_edit':
		include("$DOCUMENT_ROOT/$document_admin/top.php");      // выводим верхнюю шапку
		show_menu($admin_action);                     // выводим меню раздела
		$row_values=get_row($id);                     // получаем запись для редактирования
		show_form("form_edit",$row_values);           // выводим форму изменения записи
		include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // выводим нижнюю шапку
		break;

	// добавляем новую запись
	case 'do_add':
		$form_post_vars=array();
		foreach($HTTP_POST_VARS as $key=>$value)      // оставляем только данные для добавления
			if($key!=='admin_action' && $key!=='submit')
				$form_post_vars[$key]=$value;

		$form_post_check=check_rows($form_post_vars); // проверяем данные

		if($form_post_check['error']=='')             // все ОК! добавляем!
		{
			$add_result=add_rows($form_post_check['value']);
			if(!$add_result)
			{
				$action_inform="не удалось добавить запись в базу данных";

				include("$DOCUMENT_ROOT/$document_admin/top.php");      // выводим верхнюю шапку
				show_menu($admin_action);                     // выводим меню раздела
				show_action_inform($action_inform);           // выводим отчет о выполнении операции
				show_form("form_add",$form_post_check['value']); // выводим форму добавления записи
				include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // выводим нижнюю шапку
			}
			else // все отлично добавилось!
			{
				$action_inform="запись №$add_result добавлена в базу данных";

				include("$DOCUMENT_ROOT/$document_admin/top.php");      // выводим верхнюю шапку
				show_menu($admin_action);                     // выводим меню раздела
				show_action_inform($action_inform);           // выводим отчет о выполнении операции
				show_content();                               // выводим общий список записей таблицы
				show_links();                                 // выводим ссылки на другие страницы
				include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // выводим нижнюю шапку
			}
		}
		else                                              // есть неверные данные
		{
			// выводим форму добавления записи с введенными ранее значениями и сообщениями об ошибках
			$action_inform="не правильно введены данные, требуется коррекция";

			include("$DOCUMENT_ROOT/$document_admin/top.php");      // выводим верхнюю шапку
			show_menu($admin_action);                     // выводим меню раздела
			show_action_inform($action_inform);           // выводим отчет о выполнении операции
			show_form("form_add",$form_post_check['value'],$form_post_check['error']); // выводим форму добавления записи
			include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // выводим нижнюю шапку
		}

		break;

	// редактируем запись
	case 'do_edit':
		$form_post_vars=array();
		foreach($HTTP_POST_VARS as $key=>$value)      // оставляем только данные для добавления
			if($key!=='admin_action' && $key!=='submit')
				$form_post_vars[$key]=$value;

		$form_post_check=check_rows($form_post_vars); // проверяем данные

		if($form_post_check['error']=='')             // все ОК! изменяем!
		{
			$edit_result=edit_rows($form_post_check['value']);
			if(!$edit_result)
			{
				$action_inform="не удалось изменить запись";

				include("$DOCUMENT_ROOT/$document_admin/top.php");      // выводим верхнюю шапку
				show_menu($admin_action);                     // выводим меню раздела
				show_action_inform($action_inform);           // выводим отчет о выполнении операции
				show_form("form_edit",$form_post_check['value']); // выводим форму изменения записи
				include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // выводим нижнюю шапку
			}
			else // все отлично добавилось!
			{
				$action_inform="запись №$edit_result успешно изменена";

				include("$DOCUMENT_ROOT/$document_admin/top.php");      // выводим верхнюю шапку
				show_menu($admin_action);                     // выводим меню раздела
				show_action_inform($action_inform);           // выводим отчет о выполнении операции
				show_content();                               // выводим общий список записей таблицы
				show_links();                                 // выводим ссылки на другие страницы
				include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // выводим нижнюю шапку
			}
		}
		else                                              // есть неверные данные
		{
			// выводим форму изменения записи с введенными ранее значениями и сообщениями об ошибках
			$action_inform="не правильно введены данные, требуется коррекция";

			include("$DOCUMENT_ROOT/$document_admin/top.php");      // выводим верхнюю шапку
			show_menu($admin_action);                     // выводим меню раздела
			show_action_inform($action_inform);           // выводим отчет о выполнении операции
			show_form("form_edit",$form_post_check['value'],$form_post_check['error']); // выводим форму изменения записи
			include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // выводим нижнюю шапку
		}

		break;

	// удаляем запись
	case 'do_del':
		if($confirmed=="yes")                         // удаление подтверждено
		{
			$del_result=del_rows($id);
			if(!$del_result)
				$action_inform="не удалось удалить запись №$id";
			else
				$action_inform="запись №$id удалена из базы данных";
		}
		include("$DOCUMENT_ROOT/$document_admin/top.php");      // выводим верхнюю шапку
		show_menu($admin_action);                     // выводим меню раздела
		show_action_inform($action_inform);           // выводим отчет о выполнении операции
		show_content();                               // выводим общий список записей таблицы
		show_links();                                 // выводим ссылки на другие страницы
		include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // выводим нижнюю шапку
		break;

	// выводим список записей
	default:
		include("$DOCUMENT_ROOT/$document_admin/top.php");      // выводим верхнюю шапку
		show_menu($admin_action);                     // выводим меню раздела
		show_content();                               // выводим общий список записей таблицы
		show_links();                                 // выводим ссылки на другие страницы
		include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // выводим нижнюю шапку
		break;
}

//====================================================
// ФУНКЦИИ
//====================================================

// преобразовываем массив $db_fields в такой же, но с ассоциативным массивом второго уровня
function db_fields_to_assoc()
{
	global $db_fields;

	$db_fields_assoc=array();

	for ($i=0;$i<count($db_fields);$i++)
	{
		$db_fields_assoc[$i]["fld_field"]    = $db_fields[$i][0];
		$db_fields_assoc[$i]["fld_type"]     = $db_fields[$i][1];
		$db_fields_assoc[$i]["fld_name"]     = $db_fields[$i][2];
		$db_fields_assoc[$i]["fld_form"]     = $db_fields[$i][3];
		$db_fields_assoc[$i]["fld_fill"]     = $db_fields[$i][4];
		$db_fields_assoc[$i]["fld_showadd"]  = $db_fields[$i][5];
		$db_fields_assoc[$i]["fld_showedit"] = $db_fields[$i][6];
		$db_fields_assoc[$i]["fld_preview"]  = $db_fields[$i][7];
		$db_fields_assoc[$i]["fld_comment"]  = $db_fields[$i][8];
	}
	return $db_fields_assoc;
}
// выводим меню раздела
function show_menu($admin_action)
{
	global $this_filename;

	if($admin_action=="form_add")
		echo "<p><font color=\"#ff0000\"><b>ДОБАВИТЬ</b></font> | <a href=\"./".$this_filename."\">РЕДАКТИРОВАТЬ</a>";
	elseif($admin_action=="form_edit")
		echo "<p><a href=\"./".$this_filename."?admin_action=form_add\">ДОБАВИТЬ</a> | <a href=\"./".$this_filename."\">РЕДАКТИРОВАТЬ</a>";
	else
		echo "<p><a href=\"./".$this_filename."?admin_action=form_add\">ДОБАВИТЬ</a> | <font color=\"#ff0000\"><b>РЕДАКТИРОВАТЬ</b></font>";
}
// выводит отчет о выполнении операции
function show_action_inform($action_inform)
{
	echo "<p><font color=\"#ff0000\"><b>Результат:</b> $action_inform</font>";
}
// выводим общий список записей таблицы
function show_content()
{
	global $page, $rows_onpage;
	global $mysql_tablename, $db_sort;
	global $db_fields_assoc, $db_fields_num, $db_id_field;

	// какие поля выводить
	$tables="";
	$flag=0;
	for ($i=0;$i<$db_fields_num;$i++)
	{
		if(($db_fields_assoc[$i]["fld_preview"]=="PREVIEW" || $db_fields_assoc[$i]["fld_preview"]=="PREVIEW|LINK") && $flag!==0) $tables.=", ";
		// поле с ID запрашивается даже если оно не выводится
		if($db_fields_assoc[$i]["fld_preview"]=="PREVIEW" || $db_fields_assoc[$i]["fld_preview"]=="PREVIEW|LINK" || $db_fields_assoc[$i]["fld_field"]==$db_id_field)
		{
			$tables.=$db_fields_assoc[$i]["fld_field"];
			$flag++;
		}
	}
	// какой лимит
	$from=($page-1)*$rows_onpage;
	$limit="LIMIT $from,$rows_onpage";
	// запрашиваем информацию из базы
	$query="SELECT $tables FROM $mysql_tablename $db_sort $limit";
	//echo "<p>$query";
	$rows=GetDB($query);
	// выводим таблицу
	echo "\n<p>\n<table border=0 width=100% cellpadding=3 cellspacing=1 class=\"color1\">\n";
	// рисуем шапку
	echo "<tr class=\"color2\">\n";
	for ($i=0;$i<$db_fields_num;$i++)
	{
		if($db_fields_assoc[$i]["fld_preview"]=="PREVIEW" || $db_fields_assoc[$i]["fld_preview"]=="PREVIEW|LINK")
			echo "\t<td align=center><div class=\"fnt2\"><b>".$db_fields_assoc[$i]["fld_name"]."</b></div></td>\n";
	}
	echo "<td align=center><div class=\"fnt2\"><b>Удалить</b></div></td>\n";
	echo "</tr>\n";
	// рисуем строки
	for ($i=0;$i<count($rows);$i++)
	{
		echo "<tr class=\"color4\">\n";
		for ($j=0;$j<$db_fields_num;$j++)
		{
			if($db_fields_assoc[$j]["fld_preview"]=="PREVIEW")
				echo "\t<td><div class=\"fnt2\">".$rows[$i][$db_fields_assoc[$j]["fld_field"]]."</div></td>\n";
			elseif($db_fields_assoc[$j]["fld_preview"]=="PREVIEW|LINK")
				echo "\t<td><div class=\"fnt2\"><a href=\"?admin_action=form_edit&page=$page&id=".$rows[$i][$db_id_field]."\">".$rows[$i][$db_fields_assoc[$j]["fld_field"]]."</a></div></td>\n";
		}
		echo "<td align=center><div class=\"fnt2\"><a href=\"?admin_action=do_del&page=$page&id=".$rows[$i][$db_id_field]."\" onclick=\"return confirmLink(this, 'Удалить запись №".$rows[$i][$db_id_field]."?')\" class=\"made\">удалить</a></div></td>\n";
		echo "</tr>\n";
	}
	echo "</table>\n";
}
// выводим ссылки на другие страницы
function show_links()
{
	global $page, $rows_onpage;
	global $mysql_tablename;

	// узнаем общее количество записей
	$query="SELECT count(*) FROM $mysql_tablename";
	$result=GetDB($query);
	$rows_num=$result[0]["count(*)"];

	// количество страниц
	$sets=ceil($rows_num/$rows_onpage);	

	// выводим ссылки
	echo "<p>";
	for($i=1;$i<=$sets;$i++)
	{
		$start=($i-1)*$rows_onpage+1;
		$end=$start+$rows_onpage-1;
		if($i==$sets) $end=$end-abs($sets*$rows_onpage-$rows_num);
		if($i!==$page)
			echo " <a href='?page=$i'>[$start-$end]</a> ";
		else
			echo " <font color=\"#ff0000\"><b>[$start-$end]</b></font> ";
	}

}
// выводим форму добавления/изменения записи
function show_form($action,$preset_values='',$errors='')
{
	global $db_fields_assoc, $db_fields_num;

	$form_hidden='';              // строка с невидимыми формами

	if($action=='form_add') $action_type='add';
	elseif($action=='form_edit') $action_type='edit';

	echo "\n\n<form name=\"form\" method=\"post\" enctype=\"multipart/form-data\" action=\"".$GLOBALS["SCRIPT_NAME"]."\">\n";
	// рисуем таблицу
	echo "\n<p>\n<table border=0 width=600 cellpadding=3 cellspacing=1 class=\"color1\">\n";
	for ($i=0;$i<$db_fields_num;$i++)
	{

		// если тип поля 'FILE' и режим редактирования, то поля с файлами становятся необязательными для заполнения
		$type_expl=explode('|',$db_fields_assoc[$i]["fld_type"]);
		if($type_expl[0]=='FILE' && $action_type=='edit')
		{
			$db_fields_assoc[$i]["fld_fill"]='';
		}

		// отображаем только если это указано в данном типе операции
		if($db_fields_assoc[$i]["fld_show".$action_type]=='SHOW '.strtoupper($action_type))
		{
			// если переданы значения по умолчанию и в них есть значение текущего параметра
			if($preset_values!=='' && isset($preset_values[$db_fields_assoc[$i]["fld_field"]]))
				$form_value=$preset_values[$db_fields_assoc[$i]["fld_field"]];
			// если переданы значения по умолчанию и в них нет значения текущего параметра
			elseif($preset_values!=='' && !isset($preset_values[$db_fields_assoc[$i]["fld_field"]]))
				$form_value='';
			// если не переданы значения по умолчанию,
			// то некоторые типы полей имеют установки по умолчанию (DATE, SQLTIMESTAMP)
			else
				$form_value=compose_form_value($db_fields_assoc[$i]["fld_type"]);

			// если переданы ошибки и в них есть текущий параметр
			if($errors!=='' && isset($errors[$db_fields_assoc[$i]["fld_field"]]))
				$bag_report="<br><font color=\"#ff0000\"><b>(</b>".$errors[$db_fields_assoc[$i]["fld_field"]]."<b>)</b></font>";
			else
				$bag_report='';

			// если поле невидимое, то добавляем его в строку $form_hidden, а на экран ничего не выводим
			if($db_fields_assoc[$i]["fld_form"]=='HIDDEN')
				$form_hidden.=compose_form_ctrl($db_fields_assoc[$i]["fld_form"], $db_fields_assoc[$i]["fld_field"], $db_fields_assoc[$i]["fld_comment"], $form_value);
			else
			{
				echo "<tr class=\"color2\">\n";
				// колонка с названиями
				echo "\t<td width=\"150\" valign=\"top\"><div class=\"fnt2\"><b>".compose_form_name($db_fields_assoc[$i]["fld_name"], $db_fields_assoc[$i]["fld_fill"])."</b></div></td>\n";
				// колонка с полями
				echo "\t<td><div class=\"fnt2\" valign=\"top\">".compose_form_ctrl($db_fields_assoc[$i]["fld_form"], $db_fields_assoc[$i]["fld_field"], $db_fields_assoc[$i]["fld_comment"], $form_value)." ".$bag_report."</div></td>\n";
				echo "</tr>\n";
			}
		}
	}
	echo "</table>\n";
	echo "<sup><font color=#ff0000>*</font></sup> &#151 данные поля обязательны для заполнения\n";
	echo $form_hidden."\n";
	if($action_type=='add')
	{
		echo '<input type="hidden" name="admin_action" value="do_add">';
		echo '<p><input type="submit" name="submit" value="Добавить" class="ff"> &nbsp; <input type="reset" value="Очистить" class="ff">';
	}
	elseif($action_type=='edit')
	{
		echo '<input type="hidden" name="admin_action" value="do_edit">';
		echo '<p><input type="submit" name="submit" value="Применить изменения" class="ff"> &nbsp; <input type="reset" value="Очистить" class="ff">';
	}
	echo "\n</form>\n\n";
}
// формируем название элемента формы
// $fld_name    - название
// $fld_fill    - обязательно/необязательно для заполнения
function compose_form_name($fld_name,$fld_fill)
{
	$str="$fld_name";
	if($fld_fill=="FILL") $str.="<sup><font color=\"#ff0000\">*</font></sup>";
	return $str;
}
// формируем элемент формы
// $fld_form    - тип
// $fld_field   - имя поля в базе
// $fld_comment - комментарии
// $fld_value   - значение поля
function compose_form_ctrl($fld_form,$fld_field,$fld_comment,$fld_value='')
{
	$fld_form_expl=explode("|",$fld_form);
	$type=$fld_form_expl[0];                 // тип элемента
	$name=$fld_field;                        // имя элемента

	switch($type)
	{
		case 'TEXT':
			// максимальное количество знаков
			if(!isset($fld_form_expl[1])) $fld_form_expl[1]='*';
			if($fld_form_expl[1]=='*') $text_maxlength='';
			else $text_maxlength='maxlength="'.$fld_form_expl[1].'"';

			$str='<input type="text" name="'.$name.'" class="ff" size="64" '.$text_maxlength.' value="'.$fld_value.'">';
			break;

		case 'TEXTAREA':
			$str='<textarea name="'.$name.'" rows="10" cols="66" class="ff">'.$fld_value.'</textarea>';
			break;

		case 'RICHTEXT':
			$str='<textarea name="'.$name.'" rows="10" cols="66" class="ff">'.$fld_value.'</textarea>';
			$str.="<script language=\"JavaScript1.2\" defer> \n editor_generate('".$name."',config); \n </script>";
			break;

		case 'RADIO':
			$str='RADIO';
			break;

		case 'CHECKBOX':
			$str='CHECKBOX';
			break;

		case 'LISTBOX':
			// вытаскиваем массив со списком через массив $GLOBALS
			$list=$GLOBALS['list_'.$name];
			// рисуем элемент
			$str='<select class="ff" name="'.$name.'">';
			for($i=0;$i<count($list);$i++)
			{
				if($list[$i]['value']==$fld_value)
					$str.='<option value="'.$list[$i]['value'].'" selected>'.$list[$i]['name'];
				else
					$str.='<option value="'.$list[$i]['value'].'">'.$list[$i]['name'];
			}
			$str.='</select>';
			break;

		case 'FILE':
			$str='<input type="file" name="'.$name.'" size="51" class="ff">';
			break;

		case 'HIDDEN':
			$str='<input type="hidden" name="'.$name.'" value="'.$fld_value.'">';
			break;

		default:
			$str='<font color="#ff0000">Тип поля не определен</font>';
			break;
	}
	// прикручиваем комментарий, если есть
	if($fld_comment!=='') $str.='<br><font class="fnt3note">'.$fld_comment.'</font>';
	return $str;
}
// формируем значение элемента формы
// $fld_type    - тип
function compose_form_value($fld_type)
{
	$fld_type_expl=explode("|",$fld_type);
	$type=$fld_type_expl[0];                 // тип элемента

	switch($type)
	{
		case 'DATE':
			$str=date("Y-m-d");
			break;

		case 'SQLTIMESTAMP':
			//$str=date("YmdHis");      // MySQL 3.23
			$str=date("Y-m-d H:i:s"); // MySQL 4
			break;

		default:
			$str='';
			break;
	}
	return $str;
}

// проверяем данные перед помещением в базу
function check_rows($form_post_vars)
{
	global $db_fields_assoc, $db_fields_num, $db_id_field;
	global $admin_action;

	$form_post_check=array();
	$error=false;

	for ($i=0;$i<$db_fields_num;$i++)
	{
		// присвоим переменным более короткие имена для удобства
		$fld_field = $db_fields_assoc[$i]["fld_field"];  // имя поля в базе
		$fld_type  = $db_fields_assoc[$i]["fld_type"];   // тип поля (полностью)
		$fld_fill  = $db_fields_assoc[$i]["fld_fill"];   // обязательно ли заполнять
		$fld_type_expl = explode("|",$fld_type);
		$fld_type_main = $fld_type_expl[0];              // только название типа поля

		// если тип поля 'FILE' и режим редактирования, то поля с файлами становятся необязательными для заполнения
		if($fld_type_main=='FILE' && $admin_action=='do_edit')
		{
			$fld_fill=$db_fields_assoc[$i]["fld_fill"]='';
		}

		// если это поле с ID и переменная передана (бывает при редактировании), то создаем соответствующую переменную в массиве $form_post_check, иначе будет ошибка
		if($fld_field==$db_id_field && isset($form_post_vars[$fld_field]))
			$form_post_check[$fld_field]=$form_post_vars[$fld_field];
		// если это поле с ID, то дальше его не обрабатываем
		if($fld_field==$db_id_field)
		{
			if(isset($form_post_vars[$fld_field])) $form_post_check[$fld_field]=$form_post_vars[$fld_field];
			else continue;
		}
		else
		{
			// если тип поля 'файл'
			if($fld_type_main=='FILE')
			{
				// файл не передан, но поле обязательно к заполнению
				if($GLOBALS[$fld_field]==='' && $fld_fill=='FILL')
				{
					$error_inform[$fld_field]="Данное поле обязательно для заполнения";
					$error=true;
					continue;
				}
				// файл не передан, значит пропускаем итерацию
				elseif($GLOBALS[$fld_field]=='')
				{
					continue;
				}
				// проверяем файл
				else
				{
					$check_file=check_file($fld_field,$fld_type);
					if($check_file['error']!=='')  // проверка не пройдена
					{
						$error_inform[$fld_field]=$check_file['error'];
						$error=true;
						continue;
					}
					else                           // проверка пройдена
						$form_post_check[$fld_field]=$check_file['value'];
				}
			}
			else
			{
				// если поле не определено, то присваиваем ему пустую строку
				if(!isset($form_post_vars[$fld_field])) $form_post_check[$fld_field]='';
				else $form_post_check[$fld_field]=$form_post_vars[$fld_field];

				// обрезаем пробелы
				$form_post_check[$fld_field]=trim($form_post_check[$fld_field]);

				//echo "<br>$fld_field = '".$form_post_check[$fld_field]."' ; fld_fill = '".$fld_fill."'";

				// если поле пустое и обязательное к заполнению, то ошибка
				if($form_post_check[$fld_field]==='' && $fld_fill=='FILL')
				{
					$error_inform[$fld_field]="Данное поле обязательно для заполнения";
					$error=true;
					continue;
				}

				// проверяем и корректируем соответствие значения поля его типу
				$check_type=check_type($form_post_check[$fld_field],$fld_type);
				if($check_type['error']!=='')  // проверка не пройдена
				{
					$error_inform[$fld_field]=$check_type['error'];
					$error=true;
					continue;
				}
				else                           // проверка пройдена
					$form_post_check[$fld_field]=$check_type['value'];

				// повторная проверка на пустое поле, т.к. коррекция могла внести изменения
				if($form_post_check[$fld_field]=='' && $fld_fill=='FILL')
				{
					$error_inform[$fld_field]="Данное поле обязательно для заполнения";
					$error=true;
					continue;
				}
			}
		}
	}

	if($error)
	{
		$result['error']=$error_inform;
		$result['value']=$form_post_check;
	}
	else
	{
		$result['error']='';
		$result['value']=$form_post_check;
	}

	return $result;
}
// проверяем и корректируем соответствие значения поля его типу
// для полей всех типов, кроме FILE, для них функция check_file()
function check_type($value,$type)
{
	$type_expl=explode("|",$type);
	$type_main=$type_expl[0];
	$error='';

	switch($type_main)
	{
		case 'INT':
			// сложно, но надежно проверяем тип integer
			if(is_numeric($value))
			{
				if(strpos($value,'.')!==false) $q='non integer';
				else $q='integer';
			}
			else $q='non integer';
			if($q=='integer') settype($value,"integer");
			else $error='поле должно содержать целочисленное значение';

			break;

		case 'VARCHAR':
			$varchar_length=$type_expl[1];                       // максимальное количество символов
			if(!isset($type_expl[2])) $varchar_html='NO HTML';   // формат HTML
			else $varchar_html=$type_expl[2];

			if($varchar_html=='HTML') strip_tags($value);        // удаляем теги, если надо
			//$value=true_addslashes($value);                      // добавляем слеши перед опасными символами
			if(strlen($value)>$varchar_length)
				$error='поле должно содержать на <b>'.(strlen($value)-$varchar_length).'</b> символов меньше';

			break;

		case 'TEXT':
			if(!isset($type_expl[1])) $text_html='NO HTML';      // формат HTML
			else $text_html=$type_expl[1];

			if($text_html=='HTML') strip_tags($value);           // удаляем теги, если надо
			//$value=true_addslashes$value);                      // добавляем слеши перед опасными символами

			break;

		case 'DATE':
			$is_date_format=ereg("([[:digit:]]{4})-([[:digit:]]{2})-([[:digit:]]{2})",$value,$matches);
			if(!$is_date_format) $error='неверно введена дата';
			else if(!checkdate($matches[2],$matches[3],$matches[1])) $error='даты '.$value.' не существует';

			break;

		case 'SQLTIMESTAMP':
			//$is_date_format = ereg("([[:digit:]]{4})([[:digit:]]{2})([[:digit:]]{2})([[:digit:]]{2})([[:digit:]]{2})([[:digit:]]{2})", $value, $matches); // MySQL 3.23
			$is_date_format=ereg("([[:digit:]]{4})-([[:digit:]]{2})-([[:digit:]]{2}) ([[:digit:]]{2}):([[:digit:]]{2}):([[:digit:]]{2})", $value, $matches); // MySQL 4
			if(!$is_date_format) $error='неверно введена дата';
			else if(!checkdate($matches[2],$matches[3],$matches[1]) || ($matches[4]<0 || $matches[4]>23) || ($matches[5]<0 || $matches[5]>60) || ($matches[6]<0 || $matches[6]>60)) $error='даты '.$value.' не существует';

			break;

		default:
			$error='неверно задан тип поля';
			break;
	}

	if($error!=='')
	{
		$result['error']=$error;
		$result['value']='';
	}
	else
	{
		$result['error']='';
		$result['value']=$value;
	}

	return $result;
}
// проверяем и корректируем соответствие значения поля его типу
// $name - имя переменной (по сути это fld_field - имя поля в базе)
// $type - тип переменной
// на выходе отдаем сформированное имя файла для помещения в базу данных
function check_file($name,$type)
{
//	global $admin_action;

	$type_expl=explode("|",$type);
	$type_main=$type_expl[1];      // $type_expl[0] - всегда 'FILE'
	$error='';
	$value='';

	// переменные связанные с переданным файлом
	$f      = $GLOBALS[$name];         // путь к файлу на сервере
	$f_name = $GLOBALS[$name."_name"]; // имя файла
	$f_size = $GLOBALS[$name."_size"]; // размер файла
	$f_type = $GLOBALS[$name."_type"]; // тип файла

	switch($type_main)
	{
		case 'FOTO':
			$name_length=$type_expl[2];   // максимальное количество символов
			if(file_exists($f))
			{
				if($f_type=="image/pjpeg" || $f_type=="image/jpeg")
				{
//					if($admin_action!=='do_edit')
						$value=generate_rndname('jpg',$name_length,$type_main);
//					else
//						$value='old';
				}
				else
					$error='Файл должен быть в формате JPEG';
			}
			else
				$error='невозможно скопировать файл на сервер';
			break;

		case 'ECSV':
			$name_length=$type_expl[2];   // максимальное количество символов
			if(file_exists($f))
			{
				$value=generate_rndname('htm',$name_length,$type_main);
			}
			else
				$error='невозможно скопировать файл на сервер';
			break;

		default:
			$error='неверный формат описания типа файла';
			break;
	}

	if($error!=='')
	{
		$result['error']=$error;
		$result['value']='';
	}
	else
	{
		$result['error']='';
		$result['value']=$value;
	}

	return $result;
}

// генерируем имя файла
// $ext         - расширение файла
// $name_length - количество знаков в имени файла
// $type        - тип файла, чтобы знать с какой директорией работать
function generate_rndname($ext,$name_length,$type)
{
	global $file_dir, $data_dir, $DOCUMENT_ROOT;

	$non_ext_length=$name_length-strlen($ext)-1;
	$min=pow(10,($non_ext_length-1));
	$max=9;
	for($i=1;$i<$non_ext_length;$i++) $max+=pow(10,$i)*9;

	if($non_ext_length<=1)
	{
		$min=1;
		$max=9;
	}

	if($type=='FOTO')
	{
		do $rndname=rand($min,$max).'.'.$ext;
		while(file_exists($DOCUMENT_ROOT.$file_dir.$rndname));	
	}
	elseif($type=='ECSV')
	{
		do $rndname=rand($min,$max).'.'.$ext;
		while(file_exists($DOCUMENT_ROOT.$data_dir.'escv/'.$rndname));	
	}

	return $rndname;
}
// создает из изображения уменьшенную копию и копирует в соотв. директорию
function do_small_copy($oldimg,$newimg,$maxX,$maxY)
{
	$xy=GetImageSize($oldimg);
	$x=$xy[0];		// ширина
	$y=$xy[1];		// высота

	$newx=$maxX;
	$scale=$x/$newx;
	$newy=round($y/$scale);
	if($newy>$maxY) // вертикальное расположение картинки
	{
		$newy=$maxY;
		$scale=$y/$newy;
		$newx=round($x/$scale);
	}

	$oldimage=imageCreateFromJpeg($oldimg);

	$newimage=imageCreate($newx,$newy);
	imageCopyResized($newimage,$oldimage,0,0,0,0,$newx,$newy,$x,$y);

	imageJpeg($newimage,$newimg);

	clearstatcache();
	if(file_exists($newimg)) return true;
	else return false;
}

// получаем запись
function get_row($id)
{
	global $mysql_tablename, $db_id_field;

	$query="SELECT * FROM $mysql_tablename WHERE $db_id_field='$id'";
	$rows=GetDB($query);

	// формируем выходной массив
	foreach($rows[0] as $key => $value) $result[$key]=$value;

	return $result;
}

// удаляет запись
function del_rows($id)
{
	global $mysql_tablename, $db_id_field;
	global $file_dir, $data_dir, $DOCUMENT_ROOT;
	global $db_fields_assoc, $db_fields_num;

	// если тип поля 'FILE', то удаляем файл
	for ($i=0;$i<$db_fields_num;$i++)
	{
		$type_expl=explode('|',$db_fields_assoc[$i]["fld_type"]);
		if($type_expl[0]=='FILE')
		{
			$row=get_row($id);
			if($type_expl[1]=='FOTO')
			{
				if(file_exists($DOCUMENT_ROOT.$file_dir.$row[$db_fields_assoc[$i]["fld_field"]]))
					@unlink($DOCUMENT_ROOT.$file_dir.$row[$db_fields_assoc[$i]["fld_field"]]);
				if(file_exists($DOCUMENT_ROOT.$file_dir.'small/'.$row[$db_fields_assoc[$i]["fld_field"]]))
					@unlink($DOCUMENT_ROOT.$file_dir.'small/'.$row[$db_fields_assoc[$i]["fld_field"]]);
			}
			elseif($type_expl[1]=='ECSV')
			{
				$filename=$row[$db_fields_assoc[$i]["fld_field"]];
				$filename2=explode(".",$filename);
				$csv_filename=$filename2[0].".csv";

				if(file_exists($DOCUMENT_ROOT.$data_dir.'ecsv/'.$filename))
					@unlink($DOCUMENT_ROOT.$data_dir.'ecsv/'.$filename);
				if(file_exists($DOCUMENT_ROOT.$data_dir.'ecsv/'.$csv_filename))
					@unlink($DOCUMENT_ROOT.$data_dir.'ecsv/'.$csv_filename);
			}
		}
	}

	$query="DELETE FROM ".$mysql_tablename." WHERE $db_id_field=$id";
	$result=mysql_query($query);
	if(!$result) return false;
	else return true;
}
// добавляет запись
function add_rows($form_post_vars)
{
	global $mysql_tablename;
	global $db_fields_assoc, $db_fields_num, $db_id_field;
	global $file_dir, $data_dir, $DOCUMENT_ROOT;

	// формируем строку с передаваемыми данными для запроса
	$str_values='';
	$str_compare='';
	for ($i=0;$i<$db_fields_num;$i++)
	{
		// если тип поля 'FILE', то еще копируем файл в отведенную директорию
		$type_expl=explode('|',$db_fields_assoc[$i]["fld_type"]);
		if($type_expl[0]=='FILE' && $GLOBALS[$db_fields_assoc[$i]["fld_field"]]!='')
		{
			if($type_expl[1]=='FOTO')
			{
				@$c=copy($GLOBALS[$db_fields_assoc[$i]["fld_field"]], $DOCUMENT_ROOT.$file_dir.$form_post_vars[$db_fields_assoc[$i]["fld_field"]]);
				if(!$c) echo "Ошибка при копировании файла";
				// если тип 'FOTO' и надо создавать уменьшенную копию
				if(@$type_expl[3]=='SMALL')
				{
					@$s=do_small_copy($GLOBALS[$db_fields_assoc[$i]["fld_field"]], $DOCUMENT_ROOT.$file_dir.'small/'.$form_post_vars[$db_fields_assoc[$i]["fld_field"]], 150, 150);
					if(!$s) echo "Ошибка при создании уменьшенной копии файла";
				}
			}
			elseif($type_expl[1]=='ECSV')
			{
				$filename=$form_post_vars[$db_fields_assoc[$i]["fld_field"]];
				$filename2=explode(".",$filename);
				$csv_filename=$filename2[0].".csv";

				@$c=copy($GLOBALS[$db_fields_assoc[$i]["fld_field"]], $DOCUMENT_ROOT.$data_dir.'ecsv/'.$csv_filename);
				if(!$c) echo "Ошибка при копировании ECSV файла";

				ecsv2html($DOCUMENT_ROOT.$data_dir.'ecsv/'.$csv_filename,true);
			}
		}
		// если это поле с ID, то добавляем NULL
		if($db_fields_assoc[$i]["fld_field"]==$db_id_field) $str_values.='NULL';
		elseif($type_expl[0]=='FILE' && !isset($form_post_vars[$db_fields_assoc[$i]["fld_field"]]))
		{
			$str_values.='NULL';
			$str_compare .= $db_fields_assoc[$i]["fld_field"]." IS NULL";
		}
		else
		{
			$str_values  .= "'".true_addslashes($form_post_vars[$db_fields_assoc[$i]["fld_field"]])."'";
			$str_compare .= $db_fields_assoc[$i]["fld_field"]." = '".true_addslashes($form_post_vars[$db_fields_assoc[$i]["fld_field"]])."'";
		}
		if($i!==($db_fields_num-1))
		{
			$str_values  .= ',';
			if($db_fields_assoc[$i]["fld_field"]!==$db_id_field) $str_compare .= ' and ';
		}
	}

	// добавляем в базу
	$query='INSERT INTO '.$mysql_tablename.' VALUES ('.$str_values.')';
	//echo "<br>$query";
	$result=mysql_query($query);
	if(!$result) return false;
	// узнаем ID (для надежности не просто последний добавленный ID, а с перечислением параметров)
	$query2='SELECT '.$db_id_field.' FROM '.$mysql_tablename.' WHERE '.$str_compare;
	//echo "<br>$query2";
	$result2=mysql_query($query2);
	if(!$result2) return false;
	else
	{
		$id=mysql_result($result2, 0, $db_id_field);
		return $id;
	}
}
// изменяет запись
function edit_rows($form_post_vars)
{
	global $mysql_tablename;
	global $db_fields_assoc, $db_fields_num, $db_id_field;
	global $file_dir, $data_dir, $DOCUMENT_ROOT;

	// если тип поля 'FILE', то заменяем файл на новый и присваеваем в $form_post_vars имени файла значение из базы
	for ($i=0;$i<$db_fields_num;$i++)
	{
		$type_expl=explode('|',$db_fields_assoc[$i]["fld_type"]);
		if($type_expl[0]=='FILE' && isset($form_post_vars[$db_fields_assoc[$i]["fld_field"]]))
		{
			$row=get_row($form_post_vars[$db_id_field]);
			if($row[$db_fields_assoc[$i]["fld_field"]]=='')
				$row[$db_fields_assoc[$i]["fld_field"]]=$form_post_vars[$db_fields_assoc[$i]["fld_field"]];
			$filename=$form_post_vars[$db_fields_assoc[$i]["fld_field"]]=$row[$db_fields_assoc[$i]["fld_field"]];
			if($type_expl[1]=='FOTO')
			{
				@$c=copy($GLOBALS[$db_fields_assoc[$i]["fld_field"]], $DOCUMENT_ROOT.$file_dir.$filename);
				if(!$c) echo "Ошибка при копировании файла";
				// если тип 'FOTO' и надо создавать уменьшенную копию
				if(@$type_expl[3]=='SMALL')
				{
					@$s=do_small_copy($GLOBALS[$db_fields_assoc[$i]["fld_field"]], $DOCUMENT_ROOT.$file_dir.'small/'.$filename, 150, 150);
					if(!$s) echo "Ошибка при создании уменьшенной копии файла";
				}
			}
			if($type_expl[1]=='ECSV')
			{
				$filename2=explode(".",$filename);
				$csv_filename=$filename2[0].".csv";

				@$c=copy($GLOBALS[$db_fields_assoc[$i]["fld_field"]], $DOCUMENT_ROOT.$data_dir.'ecsv/'.$csv_filename);
				if(!$c) echo "Ошибка при копировании файла";

				ecsv2html($DOCUMENT_ROOT.$data_dir.'ecsv/'.$csv_filename,true);
			}
		}
	}

	// формируем строку с передаваемыми данными для запроса
	$set_values='';
	$flag=0;
	foreach($form_post_vars as $key => $value)
	{
		// если это поле с ID, то пропускаем
		if($key==$db_id_field) continue;
		else
		{
			if($flag!==0) $set_values.=', ';
			$set_values.="$key='".true_addslashes($value)."'";
			$flag++;
		}
	}

	// изменяем
	$query="UPDATE ".$mysql_tablename." SET ".$set_values." WHERE ".$db_id_field."='".$form_post_vars[$db_id_field]."'";
	//echo "<br>$query";
	$result=mysql_query($query);
	if(!$result) return false;
	else return $form_post_vars[$db_id_field];
}





// конвертируем ECSV файл в HTML-формат
// на входе:  $file              - путь к файлу
// на входе:  $create_html_file  - создавать или нет новый файл .htm
function ecsv2html($file,$create_html_file=false)
{
	// форматирование таблицы
	$tbl_start  = "\n".'<table border=0 width=100% cellpadding=3 cellspacing=1 class="color1">'."\n";
	$tbl_stop   = '</table>'."\n";
	$tr_start   = '<tr class="color4">'."\n";
	$tr_stop    = '</tr>'."\n";
	$td_start   = "\t".'<td align="center"><div class="fnt2">';
	$td_stop    = '</div></td>'."\n";

	$tr_h_start = '<tr class="color2">'."\n";
	$tr_h_stop  = '</tr>'."\n";
	$td_h_start = "\t".'<td align="center"><div class="fnt2"><b>';
	$td_h_stop  = '</b></div></td>'."\n";

	// форматирование строки
	$s_start   = "\n".'<p><b>';
	$s_stop    = '</b>'."\n";


	$html='';           // содержимое файла в html формате
	$ct_running=false;  // флаг, начат ли вывод таблицы

//	echo "<p>Имя файла: '<b>$file</b>'<br>\n";
	$f=file($file);

//	for($i=0;$i<count($f);$i++)
//		echo "<br>{$f[$i]}";

	// обрабатываем построчно переданный файл
	for($i=0;$i<count($f);$i++)
	{
		// удаляем символы переноса строки
		$f[$i]=str_replace("\n","",$f[$i]);
		$f[$i]=str_replace("\r","",$f[$i]);

		// если строка не содержит символов, пропускаем её
		if(strlen($f[$i])<1)
		{
//			echo "<br>--".strlen($f[$i])."\n";
			continue;
		}
		// если строка начинается на ^s, то это простая строка
		elseif(substr($f[$i],0,2)=='^s')
		{
//			echo "<br>^s".strlen($f[$i])."\n";
			// если ведется вывод таблицы, то закрываем его
			if($ct_running)
			{
				$html.=$tbl_stop;
				$ct_running=false;
			}
			// выводим строку
			$s=eregi("^\^s\"(.*)\"",$f[$i],$s_matches);
			$s=str_replace('""','"',$s_matches[1]);
			$html.=$s_start.$s.$s_stop;
		}
		// если строка начинается на ^h, то это заголовок таблицы
		elseif(substr($f[$i],0,2)=='^h')
		{
//			echo "<br>^h".strlen($f[$i])."\n";
//			echo "<br><b>".$f[$i]."</b>\n";

			// отрезаем '^h'
			$s=eregi_replace("^\^h","",$f[$i]);

//			echo "<br><b>".$s."</b>\n";

			// если вывод в таблицу не начат, то начинаем
			if(!$ct_running)
			{
				$html.=$tbl_start;
				$ct_running=true;
			}

			$html.=$tr_h_start;

			$tr1=str_replace('""','&quot;',$s);
			$tr2 = preg_match_all("/(?:\"[^\"]+\")|(?:[^;]+)|(?:;{2,})|(?:;+$)|(?:^;+)/i", $tr1, $tr2_matches, PREG_PATTERN_ORDER);

			// создаем результирующий массив, каждый эл-т которого - ячейка таблицы
			$res_matches=array();
			for($m=0;$m<count($tr2_matches[0]);$m++)
			{
				if($m==0 && preg_match("/^;+$/",$tr2_matches[0][$m]))
					for($n=0;$n<strlen($tr2_matches[0][$m]);$n++)
						$res_matches[]='';
				elseif($m==(count($tr2_matches[0])-1) && preg_match("/^;+$/",$tr2_matches[0][$m]))
					for($n=0;$n<strlen($tr2_matches[0][$m]);$n++)
						$res_matches[]='';
				elseif(preg_match("/^;+$/",$tr2_matches[0][$m]))
					for($n=0;$n<(strlen($tr2_matches[0][$m])-1);$n++)
						$res_matches[]='';
				elseif(preg_match("/\"([^\"]+)\"/",$tr2_matches[0][$m],$mm_matches))
						$res_matches[]=$mm_matches[1];
				else
					$res_matches[]=$tr2_matches[0][$m];
			}
			// рисуем строку
			for($j=0;$j<count($res_matches);$j++)
			{
				// слияние строк
				if(preg_match("/^\^r(\d+):/",$res_matches[$j],$im_matches))
				{
					if($im_matches[1]>1)
						$td_h_start_new=str_replace('>',' rowspan="'.$im_matches[1].'">',$td_h_start);
					else
						$td_h_start_new=$td_h_start;
					// отрезаем '^r2:'
					$res_matches[$j]=eregi_replace("^\^r".$im_matches[1].":","",$res_matches[$j]);
				}
				// слияние столбцов
				elseif(preg_match("/^\^c(\d+):/",$res_matches[$j],$im_matches))
				{
					if($im_matches[1]>1)
						$td_h_start_new=str_replace('>',' colspan="'.$im_matches[1].'">',$td_h_start);
					else
						$td_h_start_new=$td_h_start;
					// отрезаем '^c2:'
					$res_matches[$j]=eregi_replace("^\^c".$im_matches[1].":","",$res_matches[$j]);
				}
				// пустая строка
				elseif($res_matches[$j]=='')
				{
					$res_matches[$j]='&nbsp;';
					$td_h_start_new=$td_h_start;
				}
				else
					$td_h_start_new=$td_h_start;
				$html.=$td_h_start_new.$res_matches[$j].$td_h_stop;
			}

			$html.=$tr_h_stop;
		}
		// иначе это обычная строка
		else
		{
//			echo "<br>обычная строка".strlen($f[$i])."\n";
//			echo "<br><b>".$f[$i]."</b>\n";
			// если вывод в таблицу не начат, то начинаем
			if(!$ct_running)
			{
				$html.=$tbl_start;
				$ct_running=true;
			}
			$html.=$tr_start;
			// если в строке присутствует символ '"', то более сложная обработка
			if(strpos($f[$i],'"')!==false)
			{
				$tr1=str_replace('""','&quot;',$f[$i]);
				$tr2 =preg_match_all("/(?:\"[^\"]+\")|(?:[^;]+)|(?:;{2,})|(?:;+$)|(?:^;+)/i", $tr1, $tr2_matches, PREG_PATTERN_ORDER);

				// создаем результирующий массив, каждый эл-т которого - ячейка таблицы
				$res_matches=array();
				for($m=0;$m<count($tr2_matches[0]);$m++)
				{
					if($m==0 && preg_match("/^;+$/",$tr2_matches[0][$m]))
						for($n=0;$n<strlen($tr2_matches[0][$m]);$n++)
							$res_matches[]='';
					elseif($m==(count($tr2_matches[0])-1) && preg_match("/^;+$/",$tr2_matches[0][$m]))
						for($n=0;$n<strlen($tr2_matches[0][$m]);$n++)
							$res_matches[]='';
					elseif(preg_match("/^;+$/",$tr2_matches[0][$m]))
						for($n=0;$n<(strlen($tr2_matches[0][$m])-1);$n++)
							$res_matches[]='';
					elseif(preg_match("/\"([^\"]+)\"/",$tr2_matches[0][$m],$mm_matches))
							$res_matches[]=$mm_matches[1];
					else
						$res_matches[]=$tr2_matches[0][$m];
				}
				// рисуем строку
				for($j=0;$j<count($res_matches);$j++)
				{
					if($res_matches[$j]=='') $res_matches[$j]='&nbsp;';
					$html.=$td_start.$res_matches[$j].$td_stop;
				}
			}
			// иначе просто разбиваем строку по ';'
			// это для ускорения работы скрипта, т.к. большинство данных будет именно в этом формате
			else
			{
				$tr_expl=explode(";",$f[$i]);
				for($j=0;$j<count($tr_expl);$j++)
				{
					if($tr_expl[$j]=='') $tr_expl[$j]='&nbsp;';
					$html.=$td_start.$tr_expl[$j].$td_stop;
				}
			}
			$html.=$tr_stop;
		}
	}
	// если вывод в таблицу не закончен, то заканчиваем
	if($ct_running)
	{
		$html.=$tbl_stop;
		$ct_running=false;
	}

	// выдаем результат
	if($create_html_file)
	{
		// создаем новый файл с тем же именем, но расширением .htm
		$filename=basename($file);
		$filename=explode(".",$filename);
		$new_filename=$filename[0].".htm";
		$new_file_path=str_replace(basename($file),$new_filename,$file);

		$new_f=fopen($new_file_path,"w+");
		fwrite($new_f,$html);
		fclose($new_f);
	}
	else
		return $html;
}

