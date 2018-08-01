<?
//====================================================
// Функции для работы с базой данных
// Last update: 13.09.2004
//====================================================

// данные для подключения к серверу с базой данных

//$db_server="192.168.0.1";
$db_server="localhost";
$db_user="ruscableru";
$db_password="7o4hcdv3ef";
$db_database="ruscableru";
/*
$db_server="localhost";
$db_user="";
$db_password="";
$db_database="ruscable";
*/
// функция подключения к базе данных
function db_connect()
{
	global $db_server, $db_user, $db_password, $db_database;
	static $connected=FALSE;
	if($connected) return; // уже подключены

	$connected=mysql_pconnect($db_server, $db_user, $db_password) && mysql_select_db($db_database);
	if(!$connected) die("Невозможно подключиться к базе данных");
}

// Получение данных из базы данных по запросу
function GetDB($query){
	$result=mysql_query($query);
	if(mysql_errno()!=0)
	{
		echo "<p><font color=\"#ff0000\">Ошибка : ".mysql_error()." : ".mysql_errno()."</font>";
	}
	else
	{
		for ($i=0; $row=mysql_fetch_array($result); $i++)
		{
			$rez[$i]=$row;
		}
	}
	return @$rez;
}

// правильно добавляет слеши перед помещением в базу
function true_addslashes($a_string='',$is_like=FALSE)
{
	if($is_like){
		$a_string=str_replace('\\','\\\\\\\\',$a_string);
	}
	else{
		$a_string=str_replace('\\','\\\\',$a_string);
	}
	$a_string=str_replace('\'','\\\'',$a_string);

	return $a_string;
}


?>
