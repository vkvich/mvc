
<?php
    if ($data && $data === 'fail'){
        echo '<h1>Ошибка!</h1>';
    }
?>


<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h2>Изменить статью</h2>
            <form method="post" action="/admin/updateArticle?id=<?=$data['id']?>" enctype="multipart/form-data">
                title : <input type="text" class="form-control" name="title" required placeholder="Enter title" value="<?=$data['title']?>"/><br />
                image : <input type="file" class="form-control" name="image" placeholder="Enter image" value="<?=$data['image']?>"/><br />
                text : <textarea class="form-control" name="text"><?=$data['text']?></textarea><br />
                <button class="btn btn-success"  type="submit">Изменить</button>
            </form>
        </div>
    </div>
</div>