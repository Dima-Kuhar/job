<?
ini_set("session.cookie_domain", ".ruscable.ru");

session_start();
include_once("/home/ruscableru/ruscableru/www/func.inc");

if(!$connected){@db_connect();}

initUser();

if(!$firtLevelMenuId){
	$firtLevelMenuId=101;
}
if(!$title_tag){
	$title_tag="Job.RusCable.Ru - Работа в электротехнической отрасли России и стран СНГ";
}
$start_time = microtime();
$start_array = explode(" ",$start_time);
$start_time = $start_array[1] + $start_array[0];

$bnbn=intval(file_get_contents("/home/ruscableru/ruscableru/www/admin2/banners/show.txt"));
if($bnbn==0){
	$showbanners = false;
}else{
	$showbanners = true;
}
?>
<!DOCTYPE html>
<html xmlns="//www.w3.org/1999/xhtml">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-P8SZK7X');</script>
    <!-- End Google Tag Manager -->
	<meta charset="windows-1251" />
	<!--[if IE]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<title><?=$title_tag?></title>
	<!-- NoRiSearch start 1 -->
	<META http-equiv="Content-language" content="RU">
	<META name="title" content="Работа для специалистов кабельной отрасли России и стран СНГ">
	<META name="page-type" content="Работа: вакансии и резюме">
	<META name="robots" content="index,follow">
	<META name="description" content="Работа для специалистов кабельной отрасли России и стран СНГ. Поиск резюме. Поиск вакансий.">
	<META name="keywords" content="работа, job, разместить, резюме, вакансия, зарплата, поиск, поиск, работа для Вас, поиск работы">
	<META name="COPYRIGHT" content="Copyright © <?=date("Y")?> RusCable.Ru">
	<META http-equiv="Expires" content="01 June 1990 GMT">
<?
$appids = array(852501414,858493176,898735516);
$rand = rand(0,2);
echo 	'	<meta name="apple-itunes-app" content="app-id='.$appids[$rand].'">
';
?>

	<?
	if( isset($_SERVER['HTTP_REFERER']) && preg_match("/yandex\.ru\/yandsearch\?text=(.*)?&/",$_SERVER['HTTP_REFERER'],$sovp) ){
		$sovp1=urldecode($sovp[1]);
		if(mb_detect_encoding($sovp1, "UTF-8, CP1251, ASCII")=="UTF-8"){
			$sovp1=iconv("UTF-8","CP1251",$sovp1);
		}
		$_GET['q']=strip_tags($sovp1);
	}else{
		$_GET['q']=strip_tags($_GET['q']);
	}
	?>

	<link href="//www.ruscable.ru/favicon.ico" rel="shortcut icon" type="image/x-icon" />

	<link rel="stylesheet" href="/style1.css" type="text/css" media="screen, projection" />
    <script type="text/javascript" src="//www.ruscable.ru/rc2012/js/jquery-1.6.1.js"></script>
    <link rel="stylesheet" type="text/css" href="//www.ruscable.ru/rc2012/js/cusel/css/cusel.css" />
    <script type="text/javascript" src="//www.ruscable.ru/rc2012/js/cusel/js/cusel.js"></script>
    <script type="text/javascript" src="//www.ruscable.ru/rc2012/js/cusel/js/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="//www.ruscable.ru/rc2012/js/cusel/js/jScrollPane.js"></script>
    <script type="text/javascript" src="//www.ruscable.ru/js/jquery.simplemodal.1.4.2.min.js"></script>

    <script type="text/javascript" src="//www.ruscable.ru/rc2012/js/jquery.form.js"></script>
    <script type="text/javascript" src="//www.ruscable.ru/rc2012/js/ruscable.js"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body style="background-color: white!important;">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P8SZK7X"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="modal_bg"></div>


<div id="mailUsDiv" class="modal_window">

    <a href="#" class="modalClose" >Закрыть</a>
        <form id="sendEmailUsForm" action="//www.ruscable.ru/doform.php" method="post">

            <p><strong>Напишите нам</strong></p>
            <div class="line"></div>
            <p><label for="nameSendUs">Ваше Имя</label></p>
            <p><input type="text" name="add[Имя отправителя]" id="nameSendUs"/></p>
            <p><label for="emailSendUs">Ваш E-Mail</label></p>
            <p><input type="text" name="add[E-mail отправителя]" id="emailSendUs"/></p>
            <p><label for="textSendUs">Текст Сообщения</label></p>
            <p><textarea name="add[Текст сообщения]" id="textSendUs"></textarea></p>
			<div class="g-recaptcha" data-sitekey="6LeZQyITAAAAALOHZTwsPUOE1w7NTJmHYQJkMlzj"></div>
            <input type="hidden" value="Обратная связь от посетителя" name="type" />
            <input type="hidden" value="fromruscable" name="name" />
            <input type="hidden" value="okpage" name="page" />
            <input type="submit" name="submit" value="Отправить" class="bigOrangeButton" />
        </form>
</div>

<?
//if($incRightBlock=="users"){
?>
<div id="callBackDiv" class="modal_window">
    <?
if(isset($_SESSION['panel_user_id']))
{
    if(!$connected){@db_connect();}
    $result=mysql_query("SELECT * FROM users WHERE id='".$_SESSION['panel_user_id']."' and activ=1 LIMIT 0,1");

   $cb_user=mysql_fetch_assoc($result);

   if($cb_user['company_id']>0)  $manager_id=ssql("SELECT manager_id FROM company WHERE id='".$cb_user['company_id']."' LIMIT 1");
   else $manager_id=35;
   if($manager_id<1)  $manager_id=35;

}

?>
    <a href="#" class="modalClose" >Закрыть</a>
        <form id="sendCallBack" action="/doform.php" method="post">

            <p><strong>Заказать обратный звонок</strong></p>
            <div class="line"></div>
            <p><label for="nameSendUs">Ваш телефон</label></p>

            <p>

            <input type="hidden" name="add[ID юзера]" value="<?=$cb_user['id']?>"/>
            <input type="hidden"  name="add[Юзер]" value="<?=$cb_user['name']?>"/>
            <input type="text" name="add[Телефон]" id="nameSendUs" value="<?=$cb_user['tel']?>"/></p>

            <input type="hidden" value="<?=$manager_id?>" name="manager_id" />
            <input type="hidden" value="Обратный звонок" name="type" />
            <input type="hidden" value="callback" name="name" />
            <input type="hidden" value="okpage" name="page" />


            <input type="submit" name="submit" value="Заказать" class="bigOrangeButton" />


        </form>
</div>
<?//}?>



<div id="wrapper">

	<header id="header"  class="wrapBodyStyle">
		<div id="headerTopMenu">
            <div id="topHeadSocial" class="aimgBlock">

                <noindex>
                    <a rel="nofollow" href="//www.facebook.com/ruscable.ru "  target="_blank" title="Наша страничка на Facebook">
                        <img src="//www.ruscable.ru/rc2012/img/socIcons/34/fb_34.png">
                    </a>
                </noindex>
                <noindex>
                    <a rel="nofollow" href="//vk.com/ruscable"  target="_blank" title="Наша страничка Вконтакте">
                        <img src="//www.ruscable.ru/rc2012/img/socIcons/34/vk_34.png">
                    </a>
                </noindex>
                <noindex>
                    <a rel="nofollow" href="//twitter.com/ruscableru" target="_blank"  title="Наша страничка в Twitter">
                        <img src="//www.ruscable.ru/rc2012/img/socIcons/34/twitter_34.png">
                    </a>
                </noindex>
                <noindex>
                    <a rel="nofollow" href="//www.youtube.com/user/mediaholdingruscable" target="_blank"  title="Канал RusCable.Ru на YouTube">
                        <img src="//www.ruscable.ru/rc2012/img/socIcons/34/youtube_34.png">
                    </a>
                </noindex>
                <noindex>
                    <a href="//instagram.com/ruscable.ru" target="_blank"  title="Мы в Instagram">
                        <img src="//www.ruscable.ru/rc2012/img/socIcons/34/instagram_34.png">
                    </a>
                </noindex>
                <noindex>
                    <a href="//telegram.me/forum_ruscable" target="_blank"  title="Telegram">
                        <img src="//www.ruscable.ru/rc2012/img/socIcons/34/telegram_34.png">
                    </a>
                </noindex>
            </div>



             <div id="topHeadLinks">

                <div id="topOrangeMenu" class="topHeadLinksItem">
                    <a href="//www.ruscable.ru/promotion/" title="Заказ рекламы на RusCable.Ru" ><span>УСЛУГИ И РЕКЛАМА</span></a>
                </div>
                <div id="topBlueMenu"  class="topHeadLinksItem">
                    <a href="//tenders.ruscable.ru/" target="_blank" title="Тендеры"><span>ТЕНДЕРЫ</span></a>
                    •
                    <a href="//sklad.ruscable.ru/" target="_blank" title="Складские остатки на RusCable.Ru"><span>СКЛАД</span></a>
                    •
                    <noindex><a href="//job.ruscable.ru/" target="_blank" rel="nofollow" title="Работа в кабельной отрасли"><span>РАБОТА</span></a></noindex>
                    •
                    <a href="//www.ruscable.ru/gallery/" title="Фотогалерея"><span>ФОТО</span></a>
                    •
                    <noindex><a href="//video.ruscable.ru/" target="_blank" rel="nofollow" title="Видео о производстве кабеля, провода, новых технологиях"><span>ВИДЕО</span></a></noindex>
                    •
                    <a href="#" class="more" id="moreServiceLink" now="close" title="Дополнительное меню"><span>ЕЩЁ</span></a>
                </div>
                <div  id="moreServiseDiv">
                    <p><a href="//www.ruscable.ru/press/insider/" title="RusCable Insider Digest"><span>INSIDER</span></a></p>
                    <p><a href="//gost.ruscable.ru/" target="_blank" title="Все ГОСТы"><span>ГОСТы</span></a></p>
                    <p><a href="//snip.ruscable.ru/" target="_blank" title="СНиП и строительная документация"><span>СНиП</span></a></p>
                    <p><noindex><a href="//top.ruscable.ru/" target="_blank" rel="nofollow" title="Рейтинг сайтов"><span>РЕЙТИНГ</span></a></noindex></p>
                    <p><a href="//www.ruscable.ru/promotion/" target="_blank" title="О портале"><span>О ПОРТАЛЕ</span></a></p>
                </div>
                <div id="topCorner"  class="topHeadLinksItem"></div>

                <div id="topMreLinks">
                    <a href="//m.ruscable.ru/"><span>Mob</span></a>
                    <a href="//www.ruscable.ru/rss/"><span>Rss</span></a>
                    <noindex><a href="//eng.ruscable.ru/" rel="nofollow"><span>Eng</span></a></noindex>
                </div>

                <div id="topSiteMap" class="aimgBlock">
                    <a href="//www.ruscable.ru/map.html" title="Карта сайта"><img src="//ruscable.ru/rc2012/img/sitemap.gif" alt="Карта сайта"/></a>
                </div>


                <div id="topSendMail" class="aimgBlock">
                    <a href="mailto:mail@ruscable.ru" title="Напишите нам!" class="writeUsLink"><img src="//ruscable.ru/rc2012/img/sendmail.gif" alt="Контакты"/></a>
                </div>

            </div>
        </div>

        <div id="topline_b" class="banner_oth">
<?
if($showbanners){
	//$zid=52;
	$zid=2;
?>
		<script type='text/javascript'>
   var m3_u = (location.protocol=='https:'?'https://ruscable.su/www/delivery/ajs.php':'http://ruscable.su/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?zoneid=<?=$zid?>");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
</script><noscript><a href='//ruscable.su/www/delivery/ck.php?n=a964c228&amp;cb=979879' target='_blank'><img src='//ruscable.su/www/delivery/avw.php?zoneid=<?=$zid?>&amp;cb=979879&amp;n=a964c228' border='0' alt='' /></a></noscript>
<? } ?>
        </div>

        <div id="topLogoAdUser">
        <div id="searchLoader">
            &nbsp;
        </div>

             <div id="topUserSearch">


                <div id="topSearch">
                    <form id="SearchForm" action="/search/" method=POST>
<?
if($fvac==1){
	$ch1="";$ch2="checked";
	$adr="/findvacancie.html";
}else{
	$ch2="";$ch1="checked";
	$adr="/findresume.html";
}
?>
<div style='margin-bottom: 5px'>
<input type=radio name=what value=1 id="rez" <?=$ch1?>> <label for="rez">поиск резюме</label>&nbsp;&nbsp;
<input type=radio name=what value=2 id="vac" <?=$ch2?>> <label for="vac">поиск вакансий</label>
</div>
<?
if($_GET['keywords']!=""){

	$sv=preg_replace("/[^а-яА-Яa-zA-Z0-9 -,.@]/","",substr(trim(strip_tags($_GET['keywords'])),0,100));
	print '<input type="text"  name="q" id="search" value="'.$sv.'" class="rcSearchInput" />';
}else{
	print '<input type="text"  name="q" id="search" value="Поиск по сайту" class="rcSearchInput" />';
}
?>

<input type="submit" value="&nbsp;" id="searchButton" class="rcSearchButton"/>
<br><br>


<center><span id=advsearch><a href="<?=$adr?>">Расширенный поиск</a></span></center>
                    </form>
<script>
$(document).ready(function(){
	$('#vac').click(function(){
		$('#advsearch').html("<a href='/findvacancie.html'>Расширенный поиск</a>");
	});
	$('#rez').click(function(){
		$('#advsearch').html("<a href='/findresume.html'>Расширенный поиск</a>");
	});
});
</script>
                </div>
            </div>


            <a href="" class="orange"></a>
<style>
#logo
{
  float: left;
  margin-top: -21px;
  position: relative;
}
</style>
            <div id="logo" class="aimgBlock">

                <a href="/"  style="width: 17px; margin-top: 5px;"><img src="//www.ruscable.ru/rc2012/img/logo-rc-job.png" alt="Работа на RusCable.Ru" /></a>
                <a href="//www.ruscable.ru"  style="z-index: 1000; margin-top: -9px;">
				<img src="//www.ruscable.ru/rc2012/img/logo-rc.png" alt="Русский Кабель"/></a>

                <div id="logoText1" style="font-size: 10px; margin: 0px; line-height: 12px;">Энергетика. Электротехника. Связь.</div>
                <div id="logoText2" style="font-size: 9px; line-height: 12px;">Первое отраслевое электронное СМИ ЭЛ № ФС77-70160<!-- ФС77-28662 --></div>
            </div>


<?
if(!$connected){db_connect();}

$result3=mysql_query("SELECT url,foto,title,text FROM baners WHERE part='3' AND visible='1' order by rand() limit 0,1");
if(mysql_num_rows($result3)==0){
?>
 <div id="topAD">
                <div class="topAdInner">
                <img src="//www.ruscable.ru/rc2012/img/top_ad_image.jpg" align="left" />
                <p class="adzag">Обновился раздел СИП и арматура</p>
                <p><a href="">Обзор арматуры ВЛИ для проводов СИП
    (ГОСТ З 52373-2005)</a></p>
                </div>
            </div>

<?
}else{
?>
<div id="topAD">
                <div class="topAdInner">
<?
while($topPageBaner=mysql_fetch_assoc($result3))
{
if (substr($topPageBaner['url'],0,7)=="http://") {
	$topPageBurl=$topPageBaner['url'];
}else{
	$topPageBurl="http://".$topPageBaner['url'];
}
?>
<img src="//www.ruscable.ru/baners/images/<?=$topPageBaner['foto']?>" align="left" width=59 height=59>
<p class="adzag"><?=$topPageBaner['title']?></p>
<p><a href="<?=$topPageBurl?>"><?=$topPageBaner['text']?></a></p>
<?
}
?>
</div>
</div>
<?
}
?>

        </div>


	</header><!-- #header-->
    <nav id="nav">
        <div id="navInner" class="wrapBodyStyle">
<?
if(isset($_SESSION['user']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'seeker'){
$menuItems[] = array(
		'title'   => 'Ваше меню',
        'url'     => 'addresume2.php',
        'class'   => 'personal',
        'num'     => '300',
        'dopmenu' => array(
            array(
                    'title' => 'Добавить резюме',
                    'url'   => 'addresume2.php',
                    'num'   => '301',
                ),
            array(
                    'title' => 'Редактировать резюме',
                    'url'   => 'data-allresume.php',
                    'num'   => '302',
                ),
            array(
                    'title' => 'Личные данные',
                    'url'   => 'data-seeker.php',
                    'num'   => '303',
                ),
          )
	);
}

if(isset($_SESSION['user']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'employer'){
$menuItems[] = array(
		'title'   => 'Ваше меню',
        'url'     => 'data-allvacancie.php',
        'class'   => 'personal',
        'num'     => '300',
        'dopmenu' => array(
            array(
                    'title' => 'Добавить вакансию',
                    'url'   => 'addvacancie2.php',
                    'num'   => '301',
                ),
            array(
                    'title' => 'Редактировать вакансии',
                    'url'   => 'data-allvacancie.php',
                    'num'   => '302',
                ),
            array(
                    'title' => 'Личные данные',
                    'url'   => 'data-employer.php',
                    'num'   => '303',
                )
          )
	);
}





$menuItems []= array(
        'title'   => 'Поиск работы',
        'url'     => 'findvacancie.php',
        'class'   => 'searchwork',
        'num'     => '100',
        'dopmenu' => array(
            array(
                    'title' => 'Показать все вакансии',
                    'url'   => 'showallvacancie.php',
                    'num'   => '101',
                ),
            array(
                    'title' => 'Найти вакансию',
                    'url'   => 'findvacancie.php',
                    'num'   => '100',
                )
          )
    );
$menuItems []= array(
        'title'   => 'Поиск сотрудников',
        'url'     => 'findresume.php',
        'class'   => 'searchstaff',
        'num'     => '200',
        'dopmenu' => array(
            array(
                    'title' => 'Показать все резюме',
                    'url'   => 'showallresume.php',
                    'num'   => '201',
                ),
            array(
                    'title' => 'Найти резюме',
                    'url'   => 'findresume.php',
                    'num'   => '200',
                ),
	 		)
	);







?>

       <ul class="menu1Level" style='width:100%;'>
    <?
    foreach($menuItems as $firsLevel){
    	print '<li class="level1 '.$firsLevel['class'].'"><a href="'.$base_url . $firsLevel['url'].'"';
        if(isset($firtLevelMenuId) && $firtLevelMenuId==$firsLevel['num']){
        	print  ' class="active"';
        }
        print '><span> '.$firsLevel['title'].' </span></a>';
        if(sizeof($firsLevel['dopmenu'])>0){
            print '<ul class="menu2Level">';
            foreach($firsLevel['dopmenu'] as $dopLevel){
                print '<li class="level2"><a href="'. $base_url . $dopLevel['url'].'"';
                if(isset($menuId) && $menuId==$dopLevel['num']){
                    print 'class="active"';
                }
                print '>'.$dopLevel['title'].'</a></li>';
			}
            print '</ul>';
        }
		print '</li>';
	}
?>
        </ul>

        </div>
    </nav>
	<section id="middle" class="wrapBodyStyle">

    	<div id="containerInner">
			<div id="contentInner">
                <div id="innerPage">
                    <div id="ajaxLoader">
                        &nbsp;
                    </div>
