<h1><?=$data['title']?></h1>
<?php
session_start();
    if(isset($_SESSION['logged_user'])) {
?>
<p>
    <a href="/update?id=<?=$data['id']?>">Изменить</a>
    <a href="/deleteArticle?id=<?=$data['id']?>">Удалить</a>
</p>
<?php }
session_write_close();?>
<div class="article">
    <div class="article__image">
        <img src="<?=$data['image']?>" alt="">
    </div>
    <div class="article__text">
        <?=$data['text']?>
    </div>
</div>


