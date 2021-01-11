<?php
    $login = '';
    if ($data!==NULL && $data=='success'){
        echo '<div style="color: green; ">Вы успешно зарегистрированы! Можно <a href="login">авторизоваться</a>.</div><hr>';
    }
    else{
?>
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h2>Форма регистрации</h2>
            <?php if ($data!==NULL && isset($data['errors'])){
                $login = $data['login'];
                    foreach ($data['errors'] as $error){
                        ?>
                        <div style="color: red; "><?=$error?></div>
                <?php }
            }?>
            <form action="signup" method="post">
                <input type="text" class="form-control" name="login" id="login" value="<?=$login?>" required placeholder="Введите логин"><br>
                <input type="password" class="form-control" name="password" id="password" required placeholder="Введите пароль"><br>
                <input type="password" class="form-control" name="password_2" id="password_2" required placeholder="Повторите пароль"><br>
                <button class="btn btn-success" name="do_signup" type="submit">Зарегистрировать</button>
            </form>
            <br>
            <p>Если вы зарегистрированы, тогда нажмите <a href="login">здесь</a>.</p>
            <p>Вернуться на <a href="\">главную</a>.</p>
        </div>
    </div>
</div>
<?php  }?>