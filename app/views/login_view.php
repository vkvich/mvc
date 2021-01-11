<?php
$login = '';
?>
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <!-- Форма авторизации -->
            <h2>Форма авторизации</h2>
            <?php if ($data!==NULL && isset($data['errors'])){
                $login = $data['login'];
                foreach ($data['errors'] as $error){
                    ?>
                    <div style="color: red; "><?=$error?></div>
                <?php }
            }?>
            <form action="login" method="post">
                <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин" value="<?=$login?>" required><br>
                <input type="password" class="form-control" name="password" id="pass" placeholder="Введите пароль" required><br>
                <button class="btn btn-success" name="do_login" type="submit">Авторизоваться</button>
            </form>
            <br>
            <p>Если вы еще не зарегистрированы, тогда нажмите <a href="signup.php">здесь</a>.</p>
            <p>Вернуться на <a href="/">главную</a>.</p>
        </div>
    </div>
</div>
