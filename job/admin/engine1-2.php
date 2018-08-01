<?
//====================================================
// Engine file for admin module
// Last update: 28.01.2005
// Updated 28.01.2005: � SQLTIMESTAMP ���������������
//         ������������� � MySQL 3.23, ������� 4
// Updated: ����� ������� ��� SQLTIMESTAMP
//====================================================

//====================================================
// ������������� ������������ ����������
//====================================================

// ���������� ��������� ������� $db_fields
$db_fields_num=count($db_fields);
// ��������������� ������ $db_fields � ����� ��, �� � ������������� �������� ������� ������
$db_fields_assoc=db_fields_to_assoc();

//====================================================
// ������� �������
//====================================================

db_connect();

// ���� ����� �������� �� ���������, ������ ������ ��������
if(!isset($page)) $page=1;
else settype($page,"integer");

// ���� �������� �� ����������, �� ��� ��������
if(!isset($admin_action)) $admin_action="";

// ��������
switch($admin_action)
{
	// ����� ��� ���������� ������
	case 'form_add':
		include("$DOCUMENT_ROOT/$document_admin/top.php");      // ������� ������� �����
		show_menu($admin_action);                     // ������� ���� �������
		show_form("form_add");                        // ������� ����� ���������� ������
		include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // ������� ������ �����
		break;

	// ����� ��� �������������� ������
	case 'form_edit':
		include("$DOCUMENT_ROOT/$document_admin/top.php");      // ������� ������� �����
		show_menu($admin_action);                     // ������� ���� �������
		$row_values=get_row($id);                     // �������� ������ ��� ��������������
		show_form("form_edit",$row_values);           // ������� ����� ��������� ������
		include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // ������� ������ �����
		break;

	// ��������� ����� ������
	case 'do_add':
		$form_post_vars=array();
		foreach($HTTP_POST_VARS as $key=>$value)      // ��������� ������ ������ ��� ����������
			if($key!=='admin_action' && $key!=='submit')
				$form_post_vars[$key]=$value;

		$form_post_check=check_rows($form_post_vars); // ��������� ������

		if($form_post_check['error']=='')             // ��� ��! ���������!
		{
			$add_result=add_rows($form_post_check['value']);
			if(!$add_result)
			{
				$action_inform="�� ������� �������� ������ � ���� ������";

				include("$DOCUMENT_ROOT/$document_admin/top.php");      // ������� ������� �����
				show_menu($admin_action);                     // ������� ���� �������
				show_action_inform($action_inform);           // ������� ����� � ���������� ��������
				show_form("form_add",$form_post_check['value']); // ������� ����� ���������� ������
				include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // ������� ������ �����
			}
			else // ��� ������� ����������!
			{
				$action_inform="������ �$add_result ��������� � ���� ������";

				include("$DOCUMENT_ROOT/$document_admin/top.php");      // ������� ������� �����
				show_menu($admin_action);                     // ������� ���� �������
				show_action_inform($action_inform);           // ������� ����� � ���������� ��������
				show_content();                               // ������� ����� ������ ������� �������
				show_links();                                 // ������� ������ �� ������ ��������
				include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // ������� ������ �����
			}
		}
		else                                              // ���� �������� ������
		{
			// ������� ����� ���������� ������ � ���������� ����� ���������� � ����������� �� �������
			$action_inform="�� ��������� ������� ������, ��������� ���������";

			include("$DOCUMENT_ROOT/$document_admin/top.php");      // ������� ������� �����
			show_menu($admin_action);                     // ������� ���� �������
			show_action_inform($action_inform);           // ������� ����� � ���������� ��������
			show_form("form_add",$form_post_check['value'],$form_post_check['error']); // ������� ����� ���������� ������
			include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // ������� ������ �����
		}

		break;

	// ����������� ������
	case 'do_edit':
		$form_post_vars=array();
		foreach($HTTP_POST_VARS as $key=>$value)      // ��������� ������ ������ ��� ����������
			if($key!=='admin_action' && $key!=='submit')
				$form_post_vars[$key]=$value;

		$form_post_check=check_rows($form_post_vars); // ��������� ������

		if($form_post_check['error']=='')             // ��� ��! ��������!
		{
			$edit_result=edit_rows($form_post_check['value']);
			if(!$edit_result)
			{
				$action_inform="�� ������� �������� ������";

				include("$DOCUMENT_ROOT/$document_admin/top.php");      // ������� ������� �����
				show_menu($admin_action);                     // ������� ���� �������
				show_action_inform($action_inform);           // ������� ����� � ���������� ��������
				show_form("form_edit",$form_post_check['value']); // ������� ����� ��������� ������
				include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // ������� ������ �����
			}
			else // ��� ������� ����������!
			{
				$action_inform="������ �$edit_result ������� ��������";

				include("$DOCUMENT_ROOT/$document_admin/top.php");      // ������� ������� �����
				show_menu($admin_action);                     // ������� ���� �������
				show_action_inform($action_inform);           // ������� ����� � ���������� ��������
				show_content();                               // ������� ����� ������ ������� �������
				show_links();                                 // ������� ������ �� ������ ��������
				include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // ������� ������ �����
			}
		}
		else                                              // ���� �������� ������
		{
			// ������� ����� ��������� ������ � ���������� ����� ���������� � ����������� �� �������
			$action_inform="�� ��������� ������� ������, ��������� ���������";

			include("$DOCUMENT_ROOT/$document_admin/top.php");      // ������� ������� �����
			show_menu($admin_action);                     // ������� ���� �������
			show_action_inform($action_inform);           // ������� ����� � ���������� ��������
			show_form("form_edit",$form_post_check['value'],$form_post_check['error']); // ������� ����� ��������� ������
			include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // ������� ������ �����
		}

		break;

	// ������� ������
	case 'do_del':
		if($confirmed=="yes")                         // �������� ������������
		{
			$del_result=del_rows($id);
			if(!$del_result)
				$action_inform="�� ������� ������� ������ �$id";
			else
				$action_inform="������ �$id ������� �� ���� ������";
		}
		include("$DOCUMENT_ROOT/$document_admin/top.php");      // ������� ������� �����
		show_menu($admin_action);                     // ������� ���� �������
		show_action_inform($action_inform);           // ������� ����� � ���������� ��������
		show_content();                               // ������� ����� ������ ������� �������
		show_links();                                 // ������� ������ �� ������ ��������
		include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // ������� ������ �����
		break;

	// ������� ������ �������
	default:
		include("$DOCUMENT_ROOT/$document_admin/top.php");      // ������� ������� �����
		show_menu($admin_action);                     // ������� ���� �������
		show_content();                               // ������� ����� ������ ������� �������
		show_links();                                 // ������� ������ �� ������ ��������
		include("$DOCUMENT_ROOT/$document_admin/bottom.php");   // ������� ������ �����
		break;
}

//====================================================
// �������
//====================================================

// ��������������� ������ $db_fields � ����� ��, �� � ������������� �������� ������� ������
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
// ������� ���� �������
function show_menu($admin_action)
{
	global $this_filename;

	if($admin_action=="form_add")
		echo "<p><font color=\"#ff0000\"><b>��������</b></font> | <a href=\"./".$this_filename."\">�������������</a>";
	elseif($admin_action=="form_edit")
		echo "<p><a href=\"./".$this_filename."?admin_action=form_add\">��������</a> | <a href=\"./".$this_filename."\">�������������</a>";
	else
		echo "<p><a href=\"./".$this_filename."?admin_action=form_add\">��������</a> | <font color=\"#ff0000\"><b>�������������</b></font>";
}
// ������� ����� � ���������� ��������
function show_action_inform($action_inform)
{
	echo "<p><font color=\"#ff0000\"><b>���������:</b> $action_inform</font>";
}
// ������� ����� ������ ������� �������
function show_content()
{
	global $page, $rows_onpage;
	global $mysql_tablename, $db_sort;
	global $db_fields_assoc, $db_fields_num, $db_id_field;

	// ����� ���� ��������
	$tables="";
	$flag=0;
	for ($i=0;$i<$db_fields_num;$i++)
	{
		if(($db_fields_assoc[$i]["fld_preview"]=="PREVIEW" || $db_fields_assoc[$i]["fld_preview"]=="PREVIEW|LINK") && $flag!==0) $tables.=", ";
		// ���� � ID ������������� ���� ���� ��� �� ���������
		if($db_fields_assoc[$i]["fld_preview"]=="PREVIEW" || $db_fields_assoc[$i]["fld_preview"]=="PREVIEW|LINK" || $db_fields_assoc[$i]["fld_field"]==$db_id_field)
		{
			$tables.=$db_fields_assoc[$i]["fld_field"];
			$flag++;
		}
	}
	// ����� �����
	$from=($page-1)*$rows_onpage;
	$limit="LIMIT $from,$rows_onpage";
	// ����������� ���������� �� ����
	$query="SELECT $tables FROM $mysql_tablename $db_sort $limit";
	//echo "<p>$query";
	$rows=GetDB($query);
	// ������� �������
	echo "\n<p>\n<table border=0 width=100% cellpadding=3 cellspacing=1 class=\"color1\">\n";
	// ������ �����
	echo "<tr class=\"color2\">\n";
	for ($i=0;$i<$db_fields_num;$i++)
	{
		if($db_fields_assoc[$i]["fld_preview"]=="PREVIEW" || $db_fields_assoc[$i]["fld_preview"]=="PREVIEW|LINK")
			echo "\t<td align=center><div class=\"fnt2\"><b>".$db_fields_assoc[$i]["fld_name"]."</b></div></td>\n";
	}
	echo "<td align=center><div class=\"fnt2\"><b>�������</b></div></td>\n";
	echo "</tr>\n";
	// ������ ������
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
		echo "<td align=center><div class=\"fnt2\"><a href=\"?admin_action=do_del&page=$page&id=".$rows[$i][$db_id_field]."\" onclick=\"return confirmLink(this, '������� ������ �".$rows[$i][$db_id_field]."?')\" class=\"made\">�������</a></div></td>\n";
		echo "</tr>\n";
	}
	echo "</table>\n";
}
// ������� ������ �� ������ ��������
function show_links()
{
	global $page, $rows_onpage;
	global $mysql_tablename;

	// ������ ����� ���������� �������
	$query="SELECT count(*) FROM $mysql_tablename";
	$result=GetDB($query);
	$rows_num=$result[0]["count(*)"];

	// ���������� �������
	$sets=ceil($rows_num/$rows_onpage);	

	// ������� ������
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
// ������� ����� ����������/��������� ������
function show_form($action,$preset_values='',$errors='')
{
	global $db_fields_assoc, $db_fields_num;

	$form_hidden='';              // ������ � ���������� �������

	if($action=='form_add') $action_type='add';
	elseif($action=='form_edit') $action_type='edit';

	echo "\n\n<form name=\"form\" method=\"post\" enctype=\"multipart/form-data\" action=\"".$GLOBALS["SCRIPT_NAME"]."\">\n";
	// ������ �������
	echo "\n<p>\n<table border=0 width=600 cellpadding=3 cellspacing=1 class=\"color1\">\n";
	for ($i=0;$i<$db_fields_num;$i++)
	{

		// ���� ��� ���� 'FILE' � ����� ��������������, �� ���� � ������� ���������� ��������������� ��� ����������
		$type_expl=explode('|',$db_fields_assoc[$i]["fld_type"]);
		if($type_expl[0]=='FILE' && $action_type=='edit')
		{
			$db_fields_assoc[$i]["fld_fill"]='';
		}

		// ���������� ������ ���� ��� ������� � ������ ���� ��������
		if($db_fields_assoc[$i]["fld_show".$action_type]=='SHOW '.strtoupper($action_type))
		{
			// ���� �������� �������� �� ��������� � � ��� ���� �������� �������� ���������
			if($preset_values!=='' && isset($preset_values[$db_fields_assoc[$i]["fld_field"]]))
				$form_value=$preset_values[$db_fields_assoc[$i]["fld_field"]];
			// ���� �������� �������� �� ��������� � � ��� ��� �������� �������� ���������
			elseif($preset_values!=='' && !isset($preset_values[$db_fields_assoc[$i]["fld_field"]]))
				$form_value='';
			// ���� �� �������� �������� �� ���������,
			// �� ��������� ���� ����� ����� ��������� �� ��������� (DATE, SQLTIMESTAMP)
			else
				$form_value=compose_form_value($db_fields_assoc[$i]["fld_type"]);

			// ���� �������� ������ � � ��� ���� ������� ��������
			if($errors!=='' && isset($errors[$db_fields_assoc[$i]["fld_field"]]))
				$bag_report="<br><font color=\"#ff0000\"><b>(</b>".$errors[$db_fields_assoc[$i]["fld_field"]]."<b>)</b></font>";
			else
				$bag_report='';

			// ���� ���� ���������, �� ��������� ��� � ������ $form_hidden, � �� ����� ������ �� �������
			if($db_fields_assoc[$i]["fld_form"]=='HIDDEN')
				$form_hidden.=compose_form_ctrl($db_fields_assoc[$i]["fld_form"], $db_fields_assoc[$i]["fld_field"], $db_fields_assoc[$i]["fld_comment"], $form_value);
			else
			{
				echo "<tr class=\"color2\">\n";
				// ������� � ����������
				echo "\t<td width=\"150\" valign=\"top\"><div class=\"fnt2\"><b>".compose_form_name($db_fields_assoc[$i]["fld_name"], $db_fields_assoc[$i]["fld_fill"])."</b></div></td>\n";
				// ������� � ������
				echo "\t<td><div class=\"fnt2\" valign=\"top\">".compose_form_ctrl($db_fields_assoc[$i]["fld_form"], $db_fields_assoc[$i]["fld_field"], $db_fields_assoc[$i]["fld_comment"], $form_value)." ".$bag_report."</div></td>\n";
				echo "</tr>\n";
			}
		}
	}
	echo "</table>\n";
	echo "<sup><font color=#ff0000>*</font></sup> &#151 ������ ���� ����������� ��� ����������\n";
	echo $form_hidden."\n";
	if($action_type=='add')
	{
		echo '<input type="hidden" name="admin_action" value="do_add">';
		echo '<p><input type="submit" name="submit" value="��������" class="ff"> &nbsp; <input type="reset" value="��������" class="ff">';
	}
	elseif($action_type=='edit')
	{
		echo '<input type="hidden" name="admin_action" value="do_edit">';
		echo '<p><input type="submit" name="submit" value="��������� ���������" class="ff"> &nbsp; <input type="reset" value="��������" class="ff">';
	}
	echo "\n</form>\n\n";
}
// ��������� �������� �������� �����
// $fld_name    - ��������
// $fld_fill    - �����������/������������� ��� ����������
function compose_form_name($fld_name,$fld_fill)
{
	$str="$fld_name";
	if($fld_fill=="FILL") $str.="<sup><font color=\"#ff0000\">*</font></sup>";
	return $str;
}
// ��������� ������� �����
// $fld_form    - ���
// $fld_field   - ��� ���� � ����
// $fld_comment - �����������
// $fld_value   - �������� ����
function compose_form_ctrl($fld_form,$fld_field,$fld_comment,$fld_value='')
{
	$fld_form_expl=explode("|",$fld_form);
	$type=$fld_form_expl[0];                 // ��� ��������
	$name=$fld_field;                        // ��� ��������

	switch($type)
	{
		case 'TEXT':
			// ������������ ���������� ������
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
			// ����������� ������ �� ������� ����� ������ $GLOBALS
			$list=$GLOBALS['list_'.$name];
			// ������ �������
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
			$str='<font color="#ff0000">��� ���� �� ���������</font>';
			break;
	}
	// ������������ �����������, ���� ����
	if($fld_comment!=='') $str.='<br><font class="fnt3note">'.$fld_comment.'</font>';
	return $str;
}
// ��������� �������� �������� �����
// $fld_type    - ���
function compose_form_value($fld_type)
{
	$fld_type_expl=explode("|",$fld_type);
	$type=$fld_type_expl[0];                 // ��� ��������

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

// ��������� ������ ����� ���������� � ����
function check_rows($form_post_vars)
{
	global $db_fields_assoc, $db_fields_num, $db_id_field;
	global $admin_action;

	$form_post_check=array();
	$error=false;

	for ($i=0;$i<$db_fields_num;$i++)
	{
		// �������� ���������� ����� �������� ����� ��� ��������
		$fld_field = $db_fields_assoc[$i]["fld_field"];  // ��� ���� � ����
		$fld_type  = $db_fields_assoc[$i]["fld_type"];   // ��� ���� (���������)
		$fld_fill  = $db_fields_assoc[$i]["fld_fill"];   // ����������� �� ���������
		$fld_type_expl = explode("|",$fld_type);
		$fld_type_main = $fld_type_expl[0];              // ������ �������� ���� ����

		// ���� ��� ���� 'FILE' � ����� ��������������, �� ���� � ������� ���������� ��������������� ��� ����������
		if($fld_type_main=='FILE' && $admin_action=='do_edit')
		{
			$fld_fill=$db_fields_assoc[$i]["fld_fill"]='';
		}

		// ���� ��� ���� � ID � ���������� �������� (������ ��� ��������������), �� ������� ��������������� ���������� � ������� $form_post_check, ����� ����� ������
		if($fld_field==$db_id_field && isset($form_post_vars[$fld_field]))
			$form_post_check[$fld_field]=$form_post_vars[$fld_field];
		// ���� ��� ���� � ID, �� ������ ��� �� ������������
		if($fld_field==$db_id_field)
		{
			if(isset($form_post_vars[$fld_field])) $form_post_check[$fld_field]=$form_post_vars[$fld_field];
			else continue;
		}
		else
		{
			// ���� ��� ���� '����'
			if($fld_type_main=='FILE')
			{
				// ���� �� �������, �� ���� ����������� � ����������
				if($GLOBALS[$fld_field]==='' && $fld_fill=='FILL')
				{
					$error_inform[$fld_field]="������ ���� ����������� ��� ����������";
					$error=true;
					continue;
				}
				// ���� �� �������, ������ ���������� ��������
				elseif($GLOBALS[$fld_field]=='')
				{
					continue;
				}
				// ��������� ����
				else
				{
					$check_file=check_file($fld_field,$fld_type);
					if($check_file['error']!=='')  // �������� �� ��������
					{
						$error_inform[$fld_field]=$check_file['error'];
						$error=true;
						continue;
					}
					else                           // �������� ��������
						$form_post_check[$fld_field]=$check_file['value'];
				}
			}
			else
			{
				// ���� ���� �� ����������, �� ����������� ��� ������ ������
				if(!isset($form_post_vars[$fld_field])) $form_post_check[$fld_field]='';
				else $form_post_check[$fld_field]=$form_post_vars[$fld_field];

				// �������� �������
				$form_post_check[$fld_field]=trim($form_post_check[$fld_field]);

				//echo "<br>$fld_field = '".$form_post_check[$fld_field]."' ; fld_fill = '".$fld_fill."'";

				// ���� ���� ������ � ������������ � ����������, �� ������
				if($form_post_check[$fld_field]==='' && $fld_fill=='FILL')
				{
					$error_inform[$fld_field]="������ ���� ����������� ��� ����������";
					$error=true;
					continue;
				}

				// ��������� � ������������ ������������ �������� ���� ��� ����
				$check_type=check_type($form_post_check[$fld_field],$fld_type);
				if($check_type['error']!=='')  // �������� �� ��������
				{
					$error_inform[$fld_field]=$check_type['error'];
					$error=true;
					continue;
				}
				else                           // �������� ��������
					$form_post_check[$fld_field]=$check_type['value'];

				// ��������� �������� �� ������ ����, �.�. ��������� ����� ������ ���������
				if($form_post_check[$fld_field]=='' && $fld_fill=='FILL')
				{
					$error_inform[$fld_field]="������ ���� ����������� ��� ����������";
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
// ��������� � ������������ ������������ �������� ���� ��� ����
// ��� ����� ���� �����, ����� FILE, ��� ��� ������� check_file()
function check_type($value,$type)
{
	$type_expl=explode("|",$type);
	$type_main=$type_expl[0];
	$error='';

	switch($type_main)
	{
		case 'INT':
			// ������, �� ������� ��������� ��� integer
			if(is_numeric($value))
			{
				if(strpos($value,'.')!==false) $q='non integer';
				else $q='integer';
			}
			else $q='non integer';
			if($q=='integer') settype($value,"integer");
			else $error='���� ������ ��������� ������������� ��������';

			break;

		case 'VARCHAR':
			$varchar_length=$type_expl[1];                       // ������������ ���������� ��������
			if(!isset($type_expl[2])) $varchar_html='NO HTML';   // ������ HTML
			else $varchar_html=$type_expl[2];

			if($varchar_html=='HTML') strip_tags($value);        // ������� ����, ���� ����
			//$value=true_addslashes($value);                      // ��������� ����� ����� �������� ���������
			if(strlen($value)>$varchar_length)
				$error='���� ������ ��������� �� <b>'.(strlen($value)-$varchar_length).'</b> �������� ������';

			break;

		case 'TEXT':
			if(!isset($type_expl[1])) $text_html='NO HTML';      // ������ HTML
			else $text_html=$type_expl[1];

			if($text_html=='HTML') strip_tags($value);           // ������� ����, ���� ����
			//$value=true_addslashes$value);                      // ��������� ����� ����� �������� ���������

			break;

		case 'DATE':
			$is_date_format=ereg("([[:digit:]]{4})-([[:digit:]]{2})-([[:digit:]]{2})",$value,$matches);
			if(!$is_date_format) $error='������� ������� ����';
			else if(!checkdate($matches[2],$matches[3],$matches[1])) $error='���� '.$value.' �� ����������';

			break;

		case 'SQLTIMESTAMP':
			//$is_date_format = ereg("([[:digit:]]{4})([[:digit:]]{2})([[:digit:]]{2})([[:digit:]]{2})([[:digit:]]{2})([[:digit:]]{2})", $value, $matches); // MySQL 3.23
			$is_date_format=ereg("([[:digit:]]{4})-([[:digit:]]{2})-([[:digit:]]{2}) ([[:digit:]]{2}):([[:digit:]]{2}):([[:digit:]]{2})", $value, $matches); // MySQL 4
			if(!$is_date_format) $error='������� ������� ����';
			else if(!checkdate($matches[2],$matches[3],$matches[1]) || ($matches[4]<0 || $matches[4]>23) || ($matches[5]<0 || $matches[5]>60) || ($matches[6]<0 || $matches[6]>60)) $error='���� '.$value.' �� ����������';

			break;

		default:
			$error='������� ����� ��� ����';
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
// ��������� � ������������ ������������ �������� ���� ��� ����
// $name - ��� ���������� (�� ���� ��� fld_field - ��� ���� � ����)
// $type - ��� ����������
// �� ������ ������ �������������� ��� ����� ��� ��������� � ���� ������
function check_file($name,$type)
{
//	global $admin_action;

	$type_expl=explode("|",$type);
	$type_main=$type_expl[1];      // $type_expl[0] - ������ 'FILE'
	$error='';
	$value='';

	// ���������� ��������� � ���������� ������
	$f      = $GLOBALS[$name];         // ���� � ����� �� �������
	$f_name = $GLOBALS[$name."_name"]; // ��� �����
	$f_size = $GLOBALS[$name."_size"]; // ������ �����
	$f_type = $GLOBALS[$name."_type"]; // ��� �����

	switch($type_main)
	{
		case 'FOTO':
			$name_length=$type_expl[2];   // ������������ ���������� ��������
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
					$error='���� ������ ���� � ������� JPEG';
			}
			else
				$error='���������� ����������� ���� �� ������';
			break;

		case 'ECSV':
			$name_length=$type_expl[2];   // ������������ ���������� ��������
			if(file_exists($f))
			{
				$value=generate_rndname('htm',$name_length,$type_main);
			}
			else
				$error='���������� ����������� ���� �� ������';
			break;

		default:
			$error='�������� ������ �������� ���� �����';
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

// ���������� ��� �����
// $ext         - ���������� �����
// $name_length - ���������� ������ � ����� �����
// $type        - ��� �����, ����� ����� � ����� ����������� ��������
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
// ������� �� ����������� ����������� ����� � �������� � �����. ����������
function do_small_copy($oldimg,$newimg,$maxX,$maxY)
{
	$xy=GetImageSize($oldimg);
	$x=$xy[0];		// ������
	$y=$xy[1];		// ������

	$newx=$maxX;
	$scale=$x/$newx;
	$newy=round($y/$scale);
	if($newy>$maxY) // ������������ ������������ ��������
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

// �������� ������
function get_row($id)
{
	global $mysql_tablename, $db_id_field;

	$query="SELECT * FROM $mysql_tablename WHERE $db_id_field='$id'";
	$rows=GetDB($query);

	// ��������� �������� ������
	foreach($rows[0] as $key => $value) $result[$key]=$value;

	return $result;
}

// ������� ������
function del_rows($id)
{
	global $mysql_tablename, $db_id_field;
	global $file_dir, $data_dir, $DOCUMENT_ROOT;
	global $db_fields_assoc, $db_fields_num;

	// ���� ��� ���� 'FILE', �� ������� ����
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
// ��������� ������
function add_rows($form_post_vars)
{
	global $mysql_tablename;
	global $db_fields_assoc, $db_fields_num, $db_id_field;
	global $file_dir, $data_dir, $DOCUMENT_ROOT;

	// ��������� ������ � ������������� ������� ��� �������
	$str_values='';
	$str_compare='';
	for ($i=0;$i<$db_fields_num;$i++)
	{
		// ���� ��� ���� 'FILE', �� ��� �������� ���� � ���������� ����������
		$type_expl=explode('|',$db_fields_assoc[$i]["fld_type"]);
		if($type_expl[0]=='FILE' && $GLOBALS[$db_fields_assoc[$i]["fld_field"]]!='')
		{
			if($type_expl[1]=='FOTO')
			{
				@$c=copy($GLOBALS[$db_fields_assoc[$i]["fld_field"]], $DOCUMENT_ROOT.$file_dir.$form_post_vars[$db_fields_assoc[$i]["fld_field"]]);
				if(!$c) echo "������ ��� ����������� �����";
				// ���� ��� 'FOTO' � ���� ��������� ����������� �����
				if(@$type_expl[3]=='SMALL')
				{
					@$s=do_small_copy($GLOBALS[$db_fields_assoc[$i]["fld_field"]], $DOCUMENT_ROOT.$file_dir.'small/'.$form_post_vars[$db_fields_assoc[$i]["fld_field"]], 150, 150);
					if(!$s) echo "������ ��� �������� ����������� ����� �����";
				}
			}
			elseif($type_expl[1]=='ECSV')
			{
				$filename=$form_post_vars[$db_fields_assoc[$i]["fld_field"]];
				$filename2=explode(".",$filename);
				$csv_filename=$filename2[0].".csv";

				@$c=copy($GLOBALS[$db_fields_assoc[$i]["fld_field"]], $DOCUMENT_ROOT.$data_dir.'ecsv/'.$csv_filename);
				if(!$c) echo "������ ��� ����������� ECSV �����";

				ecsv2html($DOCUMENT_ROOT.$data_dir.'ecsv/'.$csv_filename,true);
			}
		}
		// ���� ��� ���� � ID, �� ��������� NULL
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

	// ��������� � ����
	$query='INSERT INTO '.$mysql_tablename.' VALUES ('.$str_values.')';
	//echo "<br>$query";
	$result=mysql_query($query);
	if(!$result) return false;
	// ������ ID (��� ���������� �� ������ ��������� ����������� ID, � � ������������� ����������)
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
// �������� ������
function edit_rows($form_post_vars)
{
	global $mysql_tablename;
	global $db_fields_assoc, $db_fields_num, $db_id_field;
	global $file_dir, $data_dir, $DOCUMENT_ROOT;

	// ���� ��� ���� 'FILE', �� �������� ���� �� ����� � ����������� � $form_post_vars ����� ����� �������� �� ����
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
				if(!$c) echo "������ ��� ����������� �����";
				// ���� ��� 'FOTO' � ���� ��������� ����������� �����
				if(@$type_expl[3]=='SMALL')
				{
					@$s=do_small_copy($GLOBALS[$db_fields_assoc[$i]["fld_field"]], $DOCUMENT_ROOT.$file_dir.'small/'.$filename, 150, 150);
					if(!$s) echo "������ ��� �������� ����������� ����� �����";
				}
			}
			if($type_expl[1]=='ECSV')
			{
				$filename2=explode(".",$filename);
				$csv_filename=$filename2[0].".csv";

				@$c=copy($GLOBALS[$db_fields_assoc[$i]["fld_field"]], $DOCUMENT_ROOT.$data_dir.'ecsv/'.$csv_filename);
				if(!$c) echo "������ ��� ����������� �����";

				ecsv2html($DOCUMENT_ROOT.$data_dir.'ecsv/'.$csv_filename,true);
			}
		}
	}

	// ��������� ������ � ������������� ������� ��� �������
	$set_values='';
	$flag=0;
	foreach($form_post_vars as $key => $value)
	{
		// ���� ��� ���� � ID, �� ����������
		if($key==$db_id_field) continue;
		else
		{
			if($flag!==0) $set_values.=', ';
			$set_values.="$key='".true_addslashes($value)."'";
			$flag++;
		}
	}

	// ��������
	$query="UPDATE ".$mysql_tablename." SET ".$set_values." WHERE ".$db_id_field."='".$form_post_vars[$db_id_field]."'";
	//echo "<br>$query";
	$result=mysql_query($query);
	if(!$result) return false;
	else return $form_post_vars[$db_id_field];
}





// ������������ ECSV ���� � HTML-������
// �� �����:  $file              - ���� � �����
// �� �����:  $create_html_file  - ��������� ��� ��� ����� ���� .htm
function ecsv2html($file,$create_html_file=false)
{
	// �������������� �������
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

	// �������������� ������
	$s_start   = "\n".'<p><b>';
	$s_stop    = '</b>'."\n";


	$html='';           // ���������� ����� � html �������
	$ct_running=false;  // ����, ����� �� ����� �������

//	echo "<p>��� �����: '<b>$file</b>'<br>\n";
	$f=file($file);

//	for($i=0;$i<count($f);$i++)
//		echo "<br>{$f[$i]}";

	// ������������ ��������� ���������� ����
	for($i=0;$i<count($f);$i++)
	{
		// ������� ������� �������� ������
		$f[$i]=str_replace("\n","",$f[$i]);
		$f[$i]=str_replace("\r","",$f[$i]);

		// ���� ������ �� �������� ��������, ���������� �
		if(strlen($f[$i])<1)
		{
//			echo "<br>--".strlen($f[$i])."\n";
			continue;
		}
		// ���� ������ ���������� �� ^s, �� ��� ������� ������
		elseif(substr($f[$i],0,2)=='^s')
		{
//			echo "<br>^s".strlen($f[$i])."\n";
			// ���� ������� ����� �������, �� ��������� ���
			if($ct_running)
			{
				$html.=$tbl_stop;
				$ct_running=false;
			}
			// ������� ������
			$s=eregi("^\^s\"(.*)\"",$f[$i],$s_matches);
			$s=str_replace('""','"',$s_matches[1]);
			$html.=$s_start.$s.$s_stop;
		}
		// ���� ������ ���������� �� ^h, �� ��� ��������� �������
		elseif(substr($f[$i],0,2)=='^h')
		{
//			echo "<br>^h".strlen($f[$i])."\n";
//			echo "<br><b>".$f[$i]."</b>\n";

			// �������� '^h'
			$s=eregi_replace("^\^h","",$f[$i]);

//			echo "<br><b>".$s."</b>\n";

			// ���� ����� � ������� �� �����, �� ��������
			if(!$ct_running)
			{
				$html.=$tbl_start;
				$ct_running=true;
			}

			$html.=$tr_h_start;

			$tr1=str_replace('""','&quot;',$s);
			$tr2 = preg_match_all("/(?:\"[^\"]+\")|(?:[^;]+)|(?:;{2,})|(?:;+$)|(?:^;+)/i", $tr1, $tr2_matches, PREG_PATTERN_ORDER);

			// ������� �������������� ������, ������ ��-� �������� - ������ �������
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
			// ������ ������
			for($j=0;$j<count($res_matches);$j++)
			{
				// ������� �����
				if(preg_match("/^\^r(\d+):/",$res_matches[$j],$im_matches))
				{
					if($im_matches[1]>1)
						$td_h_start_new=str_replace('>',' rowspan="'.$im_matches[1].'">',$td_h_start);
					else
						$td_h_start_new=$td_h_start;
					// �������� '^r2:'
					$res_matches[$j]=eregi_replace("^\^r".$im_matches[1].":","",$res_matches[$j]);
				}
				// ������� ��������
				elseif(preg_match("/^\^c(\d+):/",$res_matches[$j],$im_matches))
				{
					if($im_matches[1]>1)
						$td_h_start_new=str_replace('>',' colspan="'.$im_matches[1].'">',$td_h_start);
					else
						$td_h_start_new=$td_h_start;
					// �������� '^c2:'
					$res_matches[$j]=eregi_replace("^\^c".$im_matches[1].":","",$res_matches[$j]);
				}
				// ������ ������
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
		// ����� ��� ������� ������
		else
		{
//			echo "<br>������� ������".strlen($f[$i])."\n";
//			echo "<br><b>".$f[$i]."</b>\n";
			// ���� ����� � ������� �� �����, �� ��������
			if(!$ct_running)
			{
				$html.=$tbl_start;
				$ct_running=true;
			}
			$html.=$tr_start;
			// ���� � ������ ������������ ������ '"', �� ����� ������� ���������
			if(strpos($f[$i],'"')!==false)
			{
				$tr1=str_replace('""','&quot;',$f[$i]);
				$tr2 =preg_match_all("/(?:\"[^\"]+\")|(?:[^;]+)|(?:;{2,})|(?:;+$)|(?:^;+)/i", $tr1, $tr2_matches, PREG_PATTERN_ORDER);

				// ������� �������������� ������, ������ ��-� �������� - ������ �������
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
				// ������ ������
				for($j=0;$j<count($res_matches);$j++)
				{
					if($res_matches[$j]=='') $res_matches[$j]='&nbsp;';
					$html.=$td_start.$res_matches[$j].$td_stop;
				}
			}
			// ����� ������ ��������� ������ �� ';'
			// ��� ��� ��������� ������ �������, �.�. ����������� ������ ����� ������ � ���� �������
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
	// ���� ����� � ������� �� ��������, �� �����������
	if($ct_running)
	{
		$html.=$tbl_stop;
		$ct_running=false;
	}

	// ������ ���������
	if($create_html_file)
	{
		// ������� ����� ���� � ��� �� ������, �� ����������� .htm
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

