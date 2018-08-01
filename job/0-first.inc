<?

//====================================================

// Ётот файл всегда загружаетс€ самым первым, т.о.

// здесь наход€тс€ функции, которые должны быть выполнены

// самыми первыми, а также об€вл€ютс€ константы

// Last update: 17.02.2005

//====================================================



// задаем локаль

setlocale(LC_ALL, "ru_RU.CP1251");

// провер€ем существование переменной JOBSESID, и если есть, то запускаем сессию

// и по фиг если ее вбили вручную, главное, что робот ее не вобъет

$user_login = false;

//if(isset($JOBSESID))

//{

	session_name('JOBSESID');

	session_start();

	//echo $JOBSESID."<br>";

	//echo $_SESSION['user']."<br>";

	//echo $_SESSION['user_name']."<br>";

	//echo $_SESSION['user_type']."<br>";

	//echo $_SESSION['user_id']."<br>";

	//if(isset($_SESSION['user']) && $_SESSION['user_id'] == md5($_SERVER['HTTP_USER_AGENT'].$_SERVER["REMOTE_ADDR"]))
    if(isset($_SESSION['user']))
	{

		$user_login = true;

	}

//}

//else echo "нет идентификатора сессии";



?>