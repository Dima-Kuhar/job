<p><b>Поиск работы:</b>
<li><a href="showallvacancie.html">Показать все вакансии</a>
<li><a href="findvacancie.html"><font color="#ff0000">Найти вакансию</font></a>
<li><a href="addresume.html">Добавить резюме</a>

<p><b>Поиск сотрудников:</b>
<li><a href="showallresume.html">Показать все резюме</a>
<li><a href="findresume.html"><font color="#ff0000">Найти резюме</font></a>
<li><a href="addvacancie.html">Добавить вакансию</a>


<?if(!isset($_SESSION['user'])):?>

<form method=post action="auth.html">
<p><b>Пользователям:</b><br>
<input type="radio" name="type" value="seeker" id="el_1"><label for="el_1"> Вы соискатель</label><br>
<input type="radio" name="type" value="employer" id="el_2"><label for="el_2"> Вы работодатель</label><br>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td>Логин:</td>
	<td><input type="text" size="10" name="login" class="ff"></td>
</tr>
<tr>
	<td>Пароль:</td>
	<td><input type="password" size="10" name="pass" class="ff"></td>
</tr>
</table>
<a href="forget.html">Забыли пароль?</a><br>
<table border="0" width="100%" height="5" cellpadding="0" cellspacing="0">
<tr>
	<td height="5"><img src="/images/empty.gif" width="1" height="5" border=0 alt=""></td>
</tr>
</table>
<input type="submit" name="submit" value=" Войти " class="ff">
<input type="hidden" name="action" value="auth">
</form>

<?elseif(isset($_SESSION['user']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'seeker'):?>

<p><b>Ваше меню:</b>
<li><a href="addresume2.html">Добавить резме</a>
<li><a href="data-allresume.html">Редактировать резюме</a>
<li><a href="data-seeker.html">Личные данные</a>
<li><a href="changepass.html">Изменить пароль</a>
<li><a href="logout.html"><font color="#ff0000">Выход</font></a>

<?elseif(isset($_SESSION['user']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'employer'):?>

<p><b>Ваше меню:</b>
<li><a href="addvacancie2.html">Добавить вакансию</a>
<li><a href="data-allvacancie.html">Редактировать вакансии</a>
<li><a href="data-employer.html">Личные данные</a>
<li><a href="changepass.html">Изменить пароль</a>
<li><a href="logout.html"><font color="#ff0000">Выход</font></a>

<?endif?>
