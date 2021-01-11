<h1>Список новостей</h1>
<ul class="articles">
    <?php
        foreach($data as $row)
        {?>
            <li class="articles__article">
                <div class="row">
                    <div class="col-sm-4 col-xs-12 col-lg-2">
                        <a href="article?id=<?=$row['id']?>">
                            <div class="articles__image">
                                <img src="<?=$row['image']?>" alt="">
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-8 col-xs-12 col-lg-10">
                        <a class="articles__title" href="article?id=<?=$row['id']?>"> <?=$row['title']?></a>
                        <div class="articles__text">
                            <?=$row['text']?>
                        </div>
                    </div>
                </div>
            </li>
        <?php } ?>
</ul>

