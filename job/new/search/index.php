<?
if(!strstr($_SERVER['HTTP_REFERER'],"ruscable.ru")){
	header("Location: /");
	exit;
}

if($_POST['what']==1){
	$k=$_POST['q'];
	header("Location: /findresume.html?keywords=$k&schedule_id=1&pay=&sex=0&age_min=&age_max=&city_id=0&lastdate=0&submit=+++%CF%EE%E8%F1%EA+++&action=search");
	exit;
}

if($_POST['what']==2){
	$k=$_POST['q'];
	header("Location: /findvacancie.html?keywords=$k&schedule_id=1&pay=&sex=a&age=&city_id=0&lastdate=0&submit=+++%CF%EE%E8%F1%EA+++&action=search");
	exit;
}

header("Location: /");
	exit;