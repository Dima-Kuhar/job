<?
ini_set("session.cookie_domain", ".ruscable.ru");

session_name('JOBSESID');
session_start();
include_once("/home/ruscableru/ruscableru/www/func.inc");
if(!$firtLevelMenuId){
	$firtLevelMenuId=101;
}
if(!$title_tag){
	$title_tag="Job.RusCable.Ru - ������ � ������������������ ������� ������ � ����� ���";
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
	<META name="page-type" content="������: �������� � ������">
	<META name="robots" content="index,follow">
    <?if(!$description){
    $description = "������ ��� ������������ ��������� ������� ������ � ����� ���. ����� ������. ����� ��������.";?>
    <META name="description" content="<?=$description?>">
    <?}else{?>
    <META name="description" content="<?=$description?>">
    <?}?>
    
	<META name="keywords" content="������, job, ����������, ������, ��������, ��������, �����, �����, ������ ��� ���, ����� ������">
	<META name="COPYRIGHT" content="Copyright � <?=date("Y")?> RusCable.Ru">
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
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P8SZK7X"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="modal_bg"></div>


<div id="mailUsDiv" class="modal_window">

    <a href="#" class="modalClose" >�������</a>
        <form id="sendEmailUsForm" action="//www.ruscable.ru/doform.php" method="post">

            <p><strong>�������� ���</strong></p>
            <div class="line"></div>
            <p><label for="nameSendUs">���� ���</label></p>
            <p><input type="text" name="add[��� �����������]" id="nameSendUs"/></p>
            <p><label for="emailSendUs">��� E-Mail</label></p>
            <p><input type="text" name="add[E-mail �����������]" id="emailSendUs"/></p>
            <p><label for="textSendUs">����� ���������</label></p>
            <p><textarea name="add[����� ���������]" id="textSendUs"></textarea></p>
<?/*            <p><?
print '<img id="cptimage" src="//www.ruscable.ru/captcha/show.php?'.session_name()."=".session_id().'">';
print "<a     onclick=\"document.getElementById('cptimage').src='//www.ruscable.ru/captcha/show.php?".session_name()."='+Math.random()\"><img src=//www.ruscable.ru/i/rf.gif alt=\"�������� �������\" title=\"�������� �������\" border=0 width=20 height=20></a>";
            ?></p>
            <p>�������� ������� � �������� <input id=captcha type="text" name="keystring" size="10" maxlength="6"></p>
*/?>
			<div class="g-recaptcha" data-sitekey="6LeZQyITAAAAALOHZTwsPUOE1w7NTJmHYQJkMlzj"></div>
            <input type="hidden" value="�������� ����� �� ����������" name="type" />
            <input type="hidden" value="fromruscable" name="name" />
            <input type="hidden" value="okpage" name="page" />


            <input type="submit" name="submit" value="���������" class="bigOrangeButton" />


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
    <a href="#" class="modalClose" >�������</a>
        <form id="sendCallBack" action="/doform.php" method="post">

            <p><strong>�������� �������� ������</strong></p>
            <div class="line"></div>
            <p><label for="nameSendUs">��� �������</label></p>

            <p>

            <input type="hidden" name="add[ID �����]" value="<?=$cb_user['id']?>"/>
            <input type="hidden"  name="add[����]" value="<?=$cb_user['name']?>"/>
            <input type="text" name="add[�������]" id="nameSendUs" value="<?=$cb_user['tel']?>"/></p>

            <input type="hidden" value="<?=$manager_id?>" name="manager_id" />
            <input type="hidden" value="�������� ������" name="type" />
            <input type="hidden" value="callback" name="name" />
            <input type="hidden" value="okpage" name="page" />


            <input type="submit" name="submit" value="��������" class="bigOrangeButton" />


        </form>
</div>
<?//}?>



<div id="wrapper">

	<header id="header"  class="wrapBodyStyle">
		<div id="headerTopMenu">
            <div id="topHeadSocial" class="aimgBlock">

                <noindex>
                    <a rel="nofollow" href="//www.facebook.com/ruscable.ru "  target="_blank" title="���� ��������� �� Facebook">
                        <img src="//www.ruscable.ru/rc2012/img/socIcons/34/fb_34.png">
                    </a>
                </noindex>
                <noindex>
                    <a rel="nofollow" href="//vk.com/ruscable"  target="_blank" title="���� ��������� ���������">
                        <img src="//www.ruscable.ru/rc2012/img/socIcons/34/vk_34.png">
                    </a>
                </noindex>
                <noindex>
                    <a rel="nofollow" href="//twitter.com/ruscableru" target="_blank"  title="���� ��������� � Twitter">
                        <img src="//www.ruscable.ru/rc2012/img/socIcons/34/twitter_34.png">
                    </a>
                </noindex>
                <noindex>
                    <a rel="nofollow" href="//www.youtube.com/user/mediaholdingruscable" target="_blank"  title="����� RusCable.Ru �� YouTube">
                        <img src="//www.ruscable.ru/rc2012/img/socIcons/34/youtube_34.png">
                    </a>
                </noindex>
                <noindex>
                    <a href="//instagram.com/ruscable.ru" target="_blank"  title="�� � Instagram">
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
                    <a href="//www.ruscable.ru/promotion/" title="����� ������� �� RusCable.Ru" ><span>������ � �������</span></a>
                </div>
                <div id="topBlueMenu"  class="topHeadLinksItem">
                    <a href="//tenders.ruscable.ru/" target="_blank" title="�������"><span>�������</span></a>
                    �
                    <a href="//sklad.ruscable.ru/" target="_blank" title="��������� ������� �� RusCable.Ru"><span>�����</span></a>
                    �
                    <noindex><a href="//job.ruscable.ru/" target="_blank" rel="nofollow" title="������ � ��������� �������"><span>������</span></a></noindex>
                    �
                    <a href="//www.ruscable.ru/gallery/" title="�����������"><span>����</span></a>
                    �
                    <noindex><a href="//video.ruscable.ru/" target="_blank" rel="nofollow" title="����� � ������������ ������, �������, ����� �����������"><span>�����</span></a></noindex>
                    �
                    <a href="#" class="more" id="moreServiceLink" now="close" title="�������������� ����"><span>�٨</span></a>
                </div>
                <div  id="moreServiseDiv">
                    <p><a href="//www.ruscable.ru/press/insider/" title="RusCable Insider Digest"><span>INSIDER</span></a></p>
                    <p><a href="//gost.ruscable.ru/" target="_blank" title="��� �����"><span>�����</span></a></p>
                    <p><a href="//snip.ruscable.ru/" target="_blank" title="���� � ������������ ������������"><span>����</span></a></p>
                    <p><noindex><a href="//top.ruscable.ru/" target="_blank" rel="nofollow" title="������� ������"><span>�������</span></a></noindex></p>
                    <p><a href="//www.ruscable.ru/promotion/" target="_blank" title="� �������"><span>� �������</span></a></p>
                </div>
                <div id="topCorner"  class="topHeadLinksItem"></div>

                <div id="topMreLinks">
                    <a href="//m.ruscable.ru/"><span>Mob</span></a>
                    <a href="//www.ruscable.ru/rss/"><span>Rss</span></a>
                    <noindex><a href="//eng.ruscable.ru/" rel="nofollow"><span>Eng</span></a></noindex>
                </div>

                <div id="topSiteMap" class="aimgBlock">
                    <a href="//www.ruscable.ru/map.html" title="����� �����"><img src="//ruscable.ru/rc2012/img/sitemap.gif" alt="����� �����"/></a>
                </div>


                <div id="topSendMail" class="aimgBlock">
                    <a href="mailto:mail@ruscable.ru" title="�������� ���!" class="writeUsLink"><img src="//ruscable.ru/rc2012/img/sendmail.gif" alt="��������"/></a>
                </div>

            </div>
        </div>

        <div id="topline_b" class="banner_oth">            
<?
if($showbanners){
	//$zid=52;
	$zid=2;
?>
    <iframe id='a964c228' name='a964c228' src='//ruscable.su/www/delivery/afr.php?zoneid=178&amp;cb=979879' frameborder='0' scrolling='no' width='100%' height='70'>
            <a href='//ruscable.su/www/delivery/ck.php?n=a964c228&amp;cb=979879' target='_blank'><img src='//ruscable.su/www/delivery/avw.php?zoneid=2&amp;cb=979879&amp;n=a964c228' border='0' alt='' /></a>
        </iframe>
	
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
<input type=radio name=what value=1 id="rez" <?=$ch1?>> <label for="rez">����� ������</label>&nbsp;&nbsp;
<input type=radio name=what value=2 id="vac" <?=$ch2?>> <label for="vac">����� ��������</label>
</div>
<?
if($_GET['keywords']!=""){

	$sv=preg_replace("/[^�-��-�a-zA-Z0-9 -,.@]/","",substr(trim(strip_tags($_GET['keywords'])),0,100));
	print '<input type="text"  name="q" id="search" value="'.$sv.'" class="rcSearchInput" />';
}else{
	print '<input type="text"  name="q" id="search" value="����� �� �����" class="rcSearchInput" />';
}
?>

<input type="submit" value="&nbsp;" id="searchButton" class="rcSearchButton"/>
<br><br>


<center><span id=advsearch><a href="<?=$adr?>">����������� �����</a></span></center>
                    </form>
<script>
$(document).ready(function(){
	$('#vac').click(function(){
		$('#advsearch').html("<a href='/findvacancie.html'>����������� �����</a>");
	});
	$('#rez').click(function(){
		$('#advsearch').html("<a href='/findresume.html'>����������� �����</a>");
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

                <a href="/"  style="width: 17px; margin-top: 5px;"><img src="//www.ruscable.ru/rc2012/img/logo-rc-job.png" alt="������ �� RusCable.Ru" /></a>
                <a href="//www.ruscable.ru"  style="z-index: 1000; margin-top: -9px;">
				<img src="//www.ruscable.ru/rc2012/img/logo-rc.png" alt="������� ������"/></a>

                <div id="logoText1" style="font-size: 10px; margin: 0px; line-height: 12px;">����������. ��������������. �����.</div>
                <div id="logoText2" style="font-size: 9px; line-height: 12px;">������ ���������� ����������� ��� �� � ��77-70160<!-- ��77-28662 --></div>
            </div>


<?
if(!$connected){db_connect();}

$result3=mysql_query("SELECT url,foto,title,text FROM baners WHERE part='3' AND visible='1' order by rand() limit 0,1");
if(mysql_num_rows($result3)==0){
?>
 <div id="topAD">
                <div class="topAdInner">
                <img src="//www.ruscable.ru/rc2012/img/top_ad_image.jpg" align="left" />
                <p class="adzag">��������� ������ ��� � ��������</p>
                <p><a href="">����� �������� ��� ��� �������� ���
    (���� � 52373-2005)</a></p>
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
if (substr($topPageBaner['url'],0,8)=="https://") {
	$topPageBurl=$topPageBaner['url'];
}else{
	$topPageBurl="http://".$topPageBaner['url'];
}
?>
<img src="https://www.ruscable.ru/baners/images/<?=$topPageBaner['foto']?>" align="left" width=59 height=59>
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
		'title'   => '���� ����',
        'url'     => '/addresume2.html',
        'class'   => 'personal',
        'num'     => '300',
        'dopmenu' => array(
            array(
                    'title' => '�������� ������',
                    'url'   => '/addresume2.html',
                    'num'   => '301',
                ),
            array(
                    'title' => '������������� ������',
                    'url'   => '/data-allresume.html',
                    'num'   => '302',
                ),
            array(
                    'title' => '������ ������',
                    'url'   => '/data-seeker.html',
                    'num'   => '303',
                ),
            array(
                    'title' => '�������� ������',
                    'url'   => '/changepass.html',
                    'num'   => '304',
                )
          )
	);
}

if(isset($_SESSION['user']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'employer'){
$menuItems[] = array(
		'title'   => '���� ����',
        'url'     => '/data-allvacancie.html',
        'class'   => 'personal',
        'num'     => '300',
        'dopmenu' => array(
            array(
                    'title' => '�������� ��������',
                    'url'   => '/addvacancie2.html',
                    'num'   => '301',
                ),
            array(
                    'title' => '������������� ��������',
                    'url'   => '/data-allvacancie.html',
                    'num'   => '302',
                ),
            array(
                    'title' => '������ ������',
                    'url'   => '/data-employer.html',
                    'num'   => '303',
                ),
            array(
                    'title' => '�������� ������',
                    'url'   => '/changepass.html',
                    'num'   => '304',
                )
          )
	);
}





$menuItems []= array(
        'title'   => '����� ������',
        'url'     => '/findvacancie.html',
        'class'   => 'searchwork',
        'num'     => '100',
        'dopmenu' => array(
            array(
                    'title' => '�������� ��� ��������',
                    'url'   => '/showallvacancie.html',
                    'num'   => '101',
                ),
            array(
                    'title' => '����� ��������',
                    'url'   => '/findvacancie.html',
                    'num'   => '100',
                ),
            array(
                    'title' => '�������� ������',
                    'url'   => '/addresume.html',
                    'num'   => '102',
                )
          )
    );
$menuItems []= array(
        'title'   => '����� �����������',
        'url'     => '/findresume.html',
        'class'   => 'searchstaff',
        'num'     => '200',
        'dopmenu' => array(
            array(
                    'title' => '�������� ��� ������',
                    'url'   => '/showallresume.html',
                    'num'   => '201',
                ),
            array(
                    'title' => '����� ������',
                    'url'   => '/findresume.html',
                    'num'   => '200',
                ),
            array(
                    'title' => '�������� ��������',
                    'url'   => '/addvacancie.html',
                    'num'   => '202',
                )
	 		)
	);







?>

       <ul class="menu1Level" style='width:100%;'>
    <?
    foreach($menuItems as $firsLevel){
    	print '<li class="level1 '.$firsLevel['class'].'"><a href="'.$firsLevel['url'].'"';
        if(isset($firtLevelMenuId) && $firtLevelMenuId==$firsLevel['num']){
        	print  ' class="active"';
        }
        print '><span> '.$firsLevel['title'].' </span></a>';
        if(sizeof($firsLevel['dopmenu'])>0){
            print '<ul class="menu2Level">';
            foreach($firsLevel['dopmenu'] as $dopLevel){
                print '<li class="level2"><a href="'.$dopLevel['url'].'"';
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
