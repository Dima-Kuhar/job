<p><b>����� ������:</b>
<li><a href="showallvacancie.html">�������� ��� ��������</a>
<li><a href="findvacancie.html"><font color="#ff0000">����� ��������</font></a>
<li><a href="addresume.html">�������� ������</a>

<p><b>����� �����������:</b>
<li><a href="showallresume.html">�������� ��� ������</a>
<li><a href="findresume.html"><font color="#ff0000">����� ������</font></a>
<li><a href="addvacancie.html">�������� ��������</a>


<?if(!isset($_SESSION['user'])):?>

<form method=post action="auth.html">
<p><b>�������������:</b><br>
<input type="radio" name="type" value="seeker" id="el_1"><label for="el_1"> �� ����������</label><br>
<input type="radio" name="type" value="employer" id="el_2"><label for="el_2"> �� ������������</label><br>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td>�����:</td>
	<td><input type="text" size="10" name="login" class="ff"></td>
</tr>
<tr>
	<td>������:</td>
	<td><input type="password" size="10" name="pass" class="ff"></td>
</tr>
</table>
<a href="forget.html">������ ������?</a><br>
<table border="0" width="100%" height="5" cellpadding="0" cellspacing="0">
<tr>
	<td height="5"><img src="/images/empty.gif" width="1" height="5" border=0 alt=""></td>
</tr>
</table>
<input type="submit" name="submit" value=" ����� " class="ff">
<input type="hidden" name="action" value="auth">
</form>

<?elseif(isset($_SESSION['user']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'seeker'):?>

<p><b>���� ����:</b>
<li><a href="addresume2.html">�������� �����</a>
<li><a href="data-allresume.html">������������� ������</a>
<li><a href="data-seeker.html">������ ������</a>
<li><a href="changepass.html">�������� ������</a>
<li><a href="logout.html"><font color="#ff0000">�����</font></a>

<?elseif(isset($_SESSION['user']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'employer'):?>

<p><b>���� ����:</b>
<li><a href="addvacancie2.html">�������� ��������</a>
<li><a href="data-allvacancie.html">������������� ��������</a>
<li><a href="data-employer.html">������ ������</a>
<li><a href="changepass.html">�������� ������</a>
<li><a href="logout.html"><font color="#ff0000">�����</font></a>

<?endif?>
