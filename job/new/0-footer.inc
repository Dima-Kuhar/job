</div>
</div><!-- #content-->
</div><!-- #container-->
<aside id="sideRight">
<!-- NoRiSearch start 2 -->


<div id="content" style="margin-left: 20px;width: 240px;">
    <div id="ruscableNews" class="bigBord">
        <h2 style='border-bottom: 0px;'>Вход</h2>

        <? if (isset($_SESSION['user_name'])) {
            print "<div id='topUser' style='margin-top:-13px;'>" . $_SESSION['user_name'] . "<br><br><a href='http://www.ruscable.ru/users/logout.html' class='regLink'>Выйти</a></span></div>";
            ?>


            <table>
                <tr>
                    <td valign=top>
                        <input type="radio" name="type" value="seeker"
                               id="el_1" <?php echo $_SESSION['user_type'] == 'seeker' ? 'checked' : ''; ?>>
                    </td>
                    <td valign=top>
                        <div style='height:3px;'>&nbsp;</div>
                        <label for="el_1"> Вы соискатель</label>
                    </td>
                </tr>
                <tr>
                    <td valign=top>
                        <input type="radio" name="type" value="employer"
                               id="el_2" <?php echo $_SESSION['user_type'] == 'employer' ? 'checked' : ''; ?>>
                    </td>
                    <td valign=top>
                        <div style='height:3px;'>&nbsp;</div>
                        <label for="el_2" style='margin-top:3px;'> Вы работодатель</label>
                    </td>
                </tr>
            </table>
            <br>

        <?php
        } else {
            ?>
            <!-- Блок авторизации -->
            <form name="top_auth" action="//www.ruscable.ru/users/logon.html" method="POST" action="" class=tform>
                <table width=70%>
                    <tr>
                        <td>
                            <ul class="ot4et">
                                <li>Логин:</li>
                            </ul>
                        </td>
                        <td>
                            <input type="text" class="in" id="login1" name="login" value="" style='width: 160px'/></td>
                    </tr>
                    <tr>
                        <td>
                            <ul class="ot4et">
                                <li>Пароль:</li>
                            </ul>
                        </td>
                        <td>
                            <input type="password" class="in" id="pass1" name="pass" value="" style='width: 160px'/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2 align=center>
                            <input name="submit_login" type="submit" value="Войти"></td>
                    </tr>
                    <tr>
                        <td colspan=2>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="action" value="auth">
            </form>
            <br>


        <? } ?>


    </div>
</div>
<br>


<script>
    jQuery(function () {
        $('input[type=radio][name=type]').change(function () {
            $.ajax({
                type: "GET",
                url: "changeType.php",
                data: {type: this.value}
            }).done(function() {
                    location.reload();
                });
        });

        $("#gostmainNextRCNewsBlockButton").click(function () {

            var ajx = $(this).position().left;
            var ajy = $(this).offset().top - $("#content").offset().top;
            var mainforumx = $("#mainForum").width();
            mainforumx = mainforumx * 1 + 20;
            ajx = ajx * 1 - 50 + mainforumx;
            ajy = ajy * 1 + 3;
            $("#ajaxLoader").css('left', ajx + 'px').css('top', ajy + 'px');
            $("#ajaxLoader").fadeIn('fast');


            var page = $(this).attr('page');
            if (page == 1) {
                $("#gostmainPrevRCNewsBlockButton").css('visibility', 'visible');
            }
            $(this).attr('page', (page * 1 + 1));

            $("#gostmainPrevRCNewsBlockButton").attr('page', (page * 1 - 1));
            $.ajax({
                type: "GET",
                url: "http://gost.ruscable.ru/rc2012/main_blocks/g_ruscab_news.php",
                data: {start: page, code: 'текст'}
            }).done(function (msg) {
                    $("#mainRCNewsAjaxLoad").html(msg);
                    $("#ajaxLoader").fadeOut('fast');

                });

            return false;
        });

        $("#gostmainPrevRCNewsBlockButton").click(function () {

            var ajx = $(this).position().left;
            var ajy = $(this).offset().top - $("#content").offset().top;
            var mainforumx = $("#mainForum").width();
            mainforumx = mainforumx * 1 + 20;
            ajx = ajx * 1 - 24 + mainforumx;
            ajy = ajy * 1 + 3;
            $("#ajaxLoader").css('left', ajx + 'px').css('top', ajy + 'px');
            $("#ajaxLoader").fadeIn('fast');

            var page = $(this).attr('page');
            if (page == 0) {
                $(this).css('visibility', 'hidden');
            }
            $(this).attr('page', (page * 1 - 1));
            $("#gostmainNextRCNewsBlockButton").attr('page', (page * 1 + 1));
            $.ajax({
                type: "GET",
                url: "http://gost.ruscable.ru/rc2012/main_blocks/g_ruscab_news.php",
                data: {start: page, code: 'текст'}
            }).done(function (msg) {
                    $("#mainRCNewsAjaxLoad").html(msg);
                    $("#ajaxLoader").fadeOut('fast');

                });

            return false;
        });
    });
</script>
<div id="content" style="margin-left: 20px;width: 240px;">
    <div id="ruscableNews" class="bigBord">
        <div class="jButton">
            <a class="orangeButton prev" href="javascript: void(0);" onclick="javascript: void(0);"
               id="gostmainPrevRCNewsBlockButton" page="-1">
                <span><img src="//www.ruscable.ru/rc2012/img/prev-arrow.png"/></span>
            </a>
            <a class="orangeButton next" href="javascript: void(0);" onclick="javascript: void(0);"
               id="gostmainNextRCNewsBlockButton" page="1">
                <span><img src="//www.ruscable.ru/rc2012/img/next-arrow.png"/></span>
            </a>
        </div>

        <h2>Наши события</h2>

        <div id="mainRCNewsAjaxLoad">
            <?
            include_once("/home/ruscableru/ruscableru/gost/rc2012/main_blocks/g_ruscab_news.php");

            ?>
        </div>
    </div>
</div>

<?
if ($showbanners) {
    ?>
    <div class="rightBlock bannerRight240x150">

        <script type='text/javascript'>
            var m3_u = (location.protocol == 'https:' ? 'https://ruscable.su/www/delivery/ajs.php' : 'http://ruscable.su/www/delivery/ajs.php');
            var m3_r = Math.floor(Math.random() * 99999999999);
            if (!document.MAX_used) document.MAX_used = ',';
            document.write("<scr" + "ipt type='text/javascript' src='" + m3_u);
            document.write("?zoneid=118");
            document.write('&amp;cb=' + m3_r);
            if (document.MAX_used != ',') document.write("&amp;exclude=" + document.MAX_used);
            document.write(document.charset ? '&amp;charset=' + document.charset : (document.characterSet ? '&amp;charset=' + document.characterSet : ''));
            document.write("&amp;loc=" + escape(window.location));
            if (document.referrer) document.write("&amp;referer=" + escape(document.referrer));
            if (document.context) document.write("&context=" + escape(document.context));
            if (document.mmm_fo) document.write("&amp;mmm_fo=1");
            document.write("'><\/scr" + "ipt>");
        </script>
        <noscript><a href='//ruscable.su/www/delivery/ck.php?n=a964c228&amp;cb=979879' target='_blank'>
                <img src='//ruscable.su/www/delivery/avw.php?zoneid=118&amp;cb=979879&amp;n=a964c228' border='0'
                     alt=''/></a></noscript>

    </div>
<? } ?>


<?
//}

include_once("/home/ruscableru/ruscableru/www/rc2012/rblocks/mini_blocks/facebook_job.inc");
?>


<?
if ($showbanners) {
    ?>
    <div class="rightBlock bannerRight240x150">

        <script type='text/javascript'>
            var m3_u = (location.protocol == 'https:' ? 'https://ruscable.su/www/delivery/ajs.php' : 'http://ruscable.su/www/delivery/ajs.php');
            var m3_r = Math.floor(Math.random() * 99999999999);
            if (!document.MAX_used) document.MAX_used = ',';
            document.write("<scr" + "ipt type='text/javascript' src='" + m3_u);
            document.write("?zoneid=119");
            document.write('&amp;cb=' + m3_r);
            if (document.MAX_used != ',') document.write("&amp;exclude=" + document.MAX_used);
            document.write(document.charset ? '&amp;charset=' + document.charset : (document.characterSet ? '&amp;charset=' + document.characterSet : ''));
            document.write("&amp;loc=" + escape(window.location));
            if (document.referrer) document.write("&amp;referer=" + escape(document.referrer));
            if (document.context) document.write("&context=" + escape(document.context));
            if (document.mmm_fo) document.write("&amp;mmm_fo=1");
            document.write("'><\/scr" + "ipt>");
        </script>
        <noscript><a href='//ruscable.su/www/delivery/ck.php?n=a964c228&amp;cb=979879' target='_blank'>
                <img src='//ruscable.su/www/delivery/avw.php?zoneid=119&amp;cb=979879&amp;n=a964c228' border='0'
                     alt=''/></a></noscript>

    </div>
<? } ?>


</aside><!-- #sideRight -->
</section><!-- #middle-->


<footer id="footer">
<div id="footerInner" class="wrapBodyStyle">
<div class="leftFotter">
    <div class="inner">
        <div class="footerZag">
            <div class="column_1">РАЗДЕЛЫ</div>
            <div class="column_2">О ПОРТАЛЕ</div>
            <div class="column_3">СЕРВИСЫ</div>
        </div>
        <ul class="column_1">

            <? if (!isset($_SESSION["login"])): ?>
                <li><a href="//www.ruscable.ru/users/logon.html">Вход на сайт</a></li>
                <li class="spaceAfter"><a href="//www.ruscable.ru/users/registr.html">Регистрация</a></li>
            <? else: ?>
                <li><a href="//www.ruscable.ru/users/">Личный кабинет</a></li>
                <li class="spaceAfter"><a href="/users/logout.html">Выход</a></li>
            <? endif; ?>

            <li><a href="//ruscable.ru/">Главная</a></li>
            <li><a href="//ruscable.ru/news/">Новости</a></li>
            <li><a href="//ruscable.ru/article/">Статьи</a></li>
            <li><a href="//ruscable.ru/board/">Объявления</a></li>
            <li><a href="//ruscable.ru/interactive/forum/">Форум</a></li>
            <li><a href="//ruscable.ru/company/">Организации</a></li>
            <li><a href="//ruscable.ru/info/wire/">Справочники</a></li>
            <li><a href="//ruscable.ru/articles/">Документы</a></li>
            <li><a href="//ruscable.ru/exhibition/russian/">Выставки</a></li>
            <li><a href="//ruscable.ru/press/">Издания</a></li>
            <li><a href="//ruscable.ru/misc/person/full/">Лица отрасли</a></li>
        </ul>

        <ul class="column_2">
            <li><a href="//ruscable.ru/map.html">Карта сайта</a></li>
            <li><a href="/search/">Поиск по сайту</a></li>
            <li class="spaceAfter"><a href="/feedback.html">Сообщение администрации</a></li>

            <li><a href="//2293336.ru/about/" target="_blank">О RusCable</a></li>
            <li><a href="//www.ruscable.ru/promotion/nagradi_i_otzivi.html">Отзывы</a></li>
            <li><a href="//www.ruscable.ru/userfiles/Mediakit2017.pdf" target="_blank">Медиа-кит</a> (pdf, 4,8&nbsp;МБ)
            </li>
            <li class="spaceAfter"><a href="//www.ruscable.ru/promotion/" style="color: #ff0000;">Реклама на портале</a>
            </li>

            <img src="//www.ruscable.ru/rc2012/img/socIcons/16/fb_16.png" style="vertical-align: sub;">
            <a href="//www.facebook.com/ruscable.ru" target="_blank" rel="nofollow">Facebook</a>
            <br>

            <img src="//www.ruscable.ru/rc2012/img/socIcons/16/vk_16.png" style="vertical-align: sub;">
            <a href="//vk.com/ruscable" target="_blank" rel="nofollow">ВКонтакте</a>
            <br>

            <img src="//www.ruscable.ru/rc2012/img/socIcons/16/twitter_16.png" style="vertical-align: sub;">
            <noindex>
                <a href="//twitter.com/ruscableru" target="_blank" rel="nofollow">Twitter</a>
            </noindex>
            <br>

            <img src="//www.ruscable.ru/rc2012/img/socIcons/16/youtube_16.png" style="vertical-align: sub;">
            <noindex>
                <a href="//www.youtube.com/user/mediaholdingruscable" target="_blank" rel="nofollow">YouTube</a>
            </noindex>
            <br>

            <img src="//www.ruscable.ru/rc2012/img/socIcons/16/instagram_16.png" style="vertical-align: sub;">
            <noindex>
                <a href="//www.instagram.com/ruscable.ru/" target="_blank" rel="nofollow">Instagram</a>
            </noindex>
            <br>

            <img src="//www.ruscable.ru/rc2012/img/socIcons/16/telegram_16.png" style="vertical-align: sub;">
            <noindex>
                <a href="//telegram.me/forum_ruscable" target="_blank" rel="nofollow">Telegram</a>
            </noindex>
            <br>

            <img src="//www.ruscable.ru/rc2012/img/socIcons/16/viber_16.png" style="vertical-align: sub;">
            <a href="viber://add?number=89990033336">Viber: 8 (999) 003-33-36</a>
        </ul>

        <ul class="column_3">
            <li><a href="//sklad.ruscable.ru/">СКЛАД</a>, <a href="//tenders.ruscable.ru/">Тендеры</a>, <a
                    href="//market.ruscable.ru/">Маркет</a></li>
            <li><a href="//www.ruscable.ru/info/ves/">Расчёт веса кабеля</a></li>
            <li><a href="//www.ruscable.ru/info/sign/">Расшифровка марки кабеля</a></li>
            <li><a href="//www.ruscable.ru/info/tara/" target="_blank">Расчёт схемы погрузки КПП</a></li>
            <li><a href="//www.ruscable.ru/gallery/">Фото</a>, <a href="//video.ruscable.ru/" rel="nofollow">Видео</a>
            </li>
            <? /*
                    <li><a href="//crm.ruscable.ru/user/login" rel="nofollow">Планировщик</a></li>
*/
            ?>
            <li><a href="//www.ruscable.ru/map/">На карте </a></li>
            <li><a href="//gost.ruscable.ru/">ГОСТы</a>, <a href="//snip.ruscable.ru/">СНиП</a></li>
            <li><a href="//job.ruscable.ru/" rel="nofollow">Вакансии, резюме</a></li>
            <li><a href="//top.ruscable.ru/" rel="nofollow">Рейтинг сайтов</a></li>

            <li><a href="//www.ruscable.ru/MobileApps/" style="color: #ff6600;">Мобильные приложения</a></li>
            <li><a href="//pda.ruscable.ru/">Версия для мобильных</a></li>
            <li><a href="//www.ruscable.ru/rss/">RSS-ленты</a></li>
            <li><a href="//eng.ruscable.ru/" rel="nofollow">English version</a></li>
        </ul>
    </div>
</div>
<div class="rightFooter">
    <div class="inner">
        <div class="footerZag">Медиахолдинг РусКабель</div>
        <ul>
            <li><a href="//www.ruscable.ru/" target="_blank">Портал «RusCable.Ru»</a></li>
            <li><a href="//www.elektroportal.ru/" target="_blank">ElektroPortal.Ru</a></li>
            <li><a href="//www.7hosting.ru/" target="_blank">Промышленный хостинг &laquo;7 Hosting&raquo;</a></li>
            <li><a href="//1el.ru/" target="_blank">Поисковая система &laquo;1EL.ru&raquo;</a></li>
            <li><a href="//rcwa.ruscable.ru/" target="_blank">Премия RCWA</a></li>
            <li><a href="//www.elpage.ru/" target="_blank">Желтая страница электротехники</a></li>
            <li><a href="//punp.ru/" target="_blank">Проект &laquo;ПУНП.РФ&raquo;</a></li>
            <li><a href="//ognestoykost.ru/" target="_blank">Проект &laquo;ОГНЕСТОЙКОСТЬ.РФ&raquo;</a></li>
            <li class="spaceAfter"><a href="//ruscableclub.ru/" target="_blank">&laquo;RusCableCLUB&raquo;</a> (<a
                    href="//www.ruscable.ru/files/gimn_ruscableclub.mp3">гимн клуба</a>)
            </li>
            <li><a href="//2293336.ru/" target="_blank">Единый сайт услуг</a></li>
        </ul>
    </div>
</div>
<div class="middleFooter">
    <img src="//www.ruscable.ru/rc2012/img/gd_rc_24x24.gif" style="margin-bottom: -8px;" alt=""/>
    <a target="_blank" href="//gd.ruscable.ru">Онлайн-приёмная секции «Кабельная промышленность»</a> Консультативного
    Совета при председателе Комитета по энергетике ГД РФ
</div>

<div id="footerLine"></div>

<div class="leftFotter">
    <div id="footerBottomText">
        <p><strong>© «РусКабель», 1999-<?= date("Y"); ?></strong></p>

        <p>Все права защищены и охраняются законом. Администрация RusCable.Ru не несет ответственности за высказывания
            третьих лиц. Мнение редакции может не совпадать с мнением авторов материалов. <strong>18+</strong>
            <br>Перепечатка информации возможна только при соблюдении <a href="//www.ruscable.ru/conditions.html">следующих
                условий</a>.</p>

    </div>
</div>

<div class="rightFooter">
    <div id="footerRcLogo">
        <img src="//www.ruscable.ru/rc2012/img/rc-logo-grey.gif"/>
    </div>
    <div id="footerAdress">
        <p><strong>Редакция портала</strong></p>

        <p>111123, Москва, Электродный проезд, д.8а, оф.18<br/>
            Телефон: +7 (495) 229-33-36 (мнк)<br/>
            <!--горячая линия Отраслевой Службы Заказов 8 (800) 500-75-76<br /-->
            e-mail: <a href="mailto:mail@ruscable.ru">mail@ruscable.ru</a><br/>
            <noindex><a href="//2293336.ru/about/contact.html" target="_blank" rel="nofollow">Контактная информация
                    медиахолдинга РусКабель</a></noindex>
        </p>
    </div>
    <div style="clear: both;"></div>
</div>
<div style="clear: both;"></div>
<noindex>
    <ul id="schrtchiki" style="margin-bottom: 0;">

        <li>

            <!--begin of Top100 logo-->
            <a href="//top100.rambler.ru/top100/">
                <img src="//top100-images.rambler.ru/top100/banner-88x31-rambler-gray2.gif" alt="Rambler's Top100"
                     width=88 height=31 border=0></a>

            <!--begin of Rambler's Top100 code --><a href="//top100.rambler.ru/top100/"><img
                    src="//counter.rambler.ru/top100.cnt?794677" alt="" width=1 height=1 border=0></a><!--end of Top100 code-->

            <!--end of Top100 logo --></li>

        <li><!-- Яндекс цитирования -->
            <a href="//www.yandex.ru/cy?base=0&host=www.ruscable.ru">
                <img src="//www.yandex.ru/cycounter?www.ruscable.ru" width=88 height=31 alt="Яндекс цитирования"
                     border=0></a>
            <!-- Яндекс цитирования --></li>


        <li><!--Rating@Mail.ru COUNTER-->
            <script language="JavaScript" type="text/javascript"><!--
                d = document;
                var a = '';
                a += ';r=' + escape(d.referrer)
                js = 10//--></script>
            <script language="JavaScript1.1" type="text/javascript"><!--
a+=';j='+navigator.javaEnabled()
js=11//--></script>
            <script language="JavaScript1.2" type="text/javascript"><!--
                s = screen;
                a += ';s=' + s.width + '*' + s.height
                a += ';d=' + (s.colorDepth ? s.colorDepth : s.pixelDepth)
                js = 12//--></script>
            <script language="JavaScript1.3" type="text/javascript"><!--
js=13//--></script>
            <script language="JavaScript" type="text/javascript"><!--
                d.write('<a href="//top.mail.ru/jump?from=973713"' +
                    ' target="_top"><img src="//db.cd.be.a0.top.mail.ru/counter' +
                    '?id=973713;t=230;js=' + js + a + ';rand=' + Math.random() +
                    '" alt="Рейтинг@Mail.ru"' + ' border="0" height="31" width="88"/><\/a>')
                if (11 < js)d.write('<' + '!-- ')//--></script>
            <noscript><a
                    target="_top" href="//top.mail.ru/jump?from=973713"><img
                        src="//db.cd.be.a0.top.mail.ru/counter?js=na;id=973713;t=230"
                        border="0" height="31" width="88"
                        alt="Рейтинг@Mail.ru"/></a></noscript>
            <script language="JavaScript" type="text/javascript"><!--
                if (11 < js)d.write('--' + '>')//--></script>
            <!--/COUNTER-->
        </li>
        <li>
            <!-- Электрорейтинг -->
            <script language="javascript">
                java = "1.0";
                java1 = "" + "&refer=" + escape(document.referrer) + "&page=" +
                    escape(window.location.href);
                document.cookie = "astratop=1; path=/";
                java1 += "&c=" + (document.cookie ? "yes" : "now");
            </script>
            <script language="javascript1.1">java="1.1";java1+="&java="+(navigator.javaEnabled()?"yes":"now")</script>
            <script language="javascript1.2">java = "1.2";
                java1 += "&razresh=" + screen.width + 'x' + screen.height + "&cvet=" +
                    (((navigator.appName.substring(0, 3) == "Mic")) ?
                        screen.colorDepth : screen.pixelDepth)</script>
            <script language="javascript1.3">java="1.3"</script>
            <script language="javascript">java1 += "&jscript=" + java + "&rand=" + Math.random();
                document.write("<a href='//top.ruscable.ru/in.php?id=1' target='_blank'><img " +
                    " src='//top.ruscable.ru/img.php?id=1&" + java1 + "&' border=0  width=88 height=31 alt='Электрорейтинг'></a>")</script>
            <noscript><a href="//www.ruscable.ru/" target=_blank><img src="//top.ruscable.ru/img.php?id=1" border=0
                                                                      width=88 height=31 alt="Электрорейтинг"></a>
            </noscript>
            <!-- /Электрорейтинг -->
        </li>

    </ul>
</noindex>

<div style="padding-bottom: 33px;">&nbsp;</div>





<?
$end_time = microtime();
$end_array = explode(" ", $end_time);
$end_time = $end_array[1] + $end_array[0];
// вычитаем из конечного времени начальное
$time = $end_time - $start_time;
// выводим в выходной поток (броузер) время генерации страницы
if ($_SESSION['login'] == "vladimir") {
    printf("<center>Страница сгенерирована за %f секунд</center>", $time);
}
?>

</div>
</footer><!-- #footer -->

</div><!-- #wrapper -->
<?




?>
<!-- NoRiSearch end 2 -->
</body>
</html>
