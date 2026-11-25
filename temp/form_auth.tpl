<div>
    <h3>Авторизація</h3>
    <p style="color: #9e475a; font-size: 13px; margin: 0 0 8px;">%message_auth%</p>
    <form method="post" action="%address%functions.php">
        <div>
            <input type="text" name="login" placeholder="Логін">
        </div>
        <div>
            <input type="password" name="password" placeholder="Пароль">
        </div>
        <button type="submit" name="auth" value="1">Увійти</button>
        <p style="text-align:right; margin: -10px 0 18px;"><a href="%address%?view=reg">Зареєструватись</a></p>
    </form>
</div>
