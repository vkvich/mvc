<!DOCTYPE html>

<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<title>Новости Главная</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="/css/style.css" />
	</head>
	<body>
        <header class="header">
            <div class="container">
                <div class="headr__top">
                    <div class="header__login">
                        <?php
                            session_start();
                                if(isset($_SESSION['logged_user'])) { ?>
                            Привет, <?php echo $_SESSION['logged_user']['login']; ?></br>
                            <a href="logout">Выйти</a>
                        <?php }else { ?>
                            <a href="login">Авторизоваться</a><br>
                            <a href="signup">Регистрация</a>
                        <?php }
                           session_write_close();     ?>

                    </div>
                </div>
            </div>
            <div class="container">
                <a href="/"> <h1 class="header__title">Новости</h1></a>
            </div>
        </header>
        <main>
            <div class="container">
                <?php include 'app/views/'.$content_view; ?>
            </div>
        </main>
        <footer>

        </footer>
	</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</html>