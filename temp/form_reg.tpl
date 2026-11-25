<h1>Форма реєстрації</h1>
%message%
<div id="reg">
    <form name="reg" action="%address%functions.php" method="post">
        <div class="form-row">
            <label>Логін</label>
            <input type="text" name="login" value="%login%">
        </div>
        <div class="form-row">
            <label>Пароль</label>
            <input type="password" name="password">
        </div>
        <div class="form-row">
            <img class="captcha-img" src="%address%captcha.php" alt="captcha">
            <label>Код перевірки</label>
            <input type="text" name="captcha" autocomplete="off">
        </div>
        <button type="submit" name="reg" value="1">Зареєструватись</button>
    </form>
</div>
