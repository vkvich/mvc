
    <?php
    if ($data && $data === 'fail') {
        echo '<h1>Ошибка!</h1>';
    }
    ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h2>Создание статьи</h2>
                <form method="post" action="/admin/newArticle" enctype="multipart/form-data">
                    Заголовок : <input type="text" class="form-control" name="title" required placeholder="Enter title"/><br/>
                    Фото : <input type="file" class="form-control" name="image" placeholder="Enter image"/><br/>
                    Текст : <textarea class="form-control" name="text"></textarea><br/>
                    <button class="btn btn-success"  type="submit">Создать</button>
                </form>
            </div>
        </div>
    </div>


