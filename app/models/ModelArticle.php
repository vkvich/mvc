<?php
namespace app\models;
use app\classes\Model;
use app\config\Main;
class ModelArticle extends Model
{
    public $dataLink;
    public $tablename = 'article';

	public function insert_Data($data)
    {
        $title = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
        $image = '';
        $text = filter_var($_POST["text"], FILTER_SANITIZE_STRING);
        if (empty($title)){
            return false;
        }
        // если была произведена отправка формы
        if(isset($_FILES['image'])) {
            // проверяем, можно ли загружать изображение
            $check = $this->can_upload($_FILES['image']);

            if($check === true){
                // загружаем изображение на сервер
                $image = $this->make_upload($_FILES['image']);
            }
        }
        $statement = $this->dataLink->prepare("INSERT INTO $this->tablename (title, image, text) VALUES(?, ?, ?)");
        $statement->bind_param('sss', $title, $image, $text);
        return $statement->execute();
    }
    public function update_Data($data, $id)
    {
        $title = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
        $updateImage = false;
        $text = filter_var($_POST["text"], FILTER_SANITIZE_STRING);
        if (empty($title)){
            return false;
        }

        if(isset($_FILES['image'])) {
            // проверяем, можно ли загружать изображение

            $check = $this->can_upload($_FILES['image']);

            if($check === true){
                // загружаем изображение на сервер
                $image = $this->make_upload($_FILES['image']);
                $updateImage = true;
            }
        }
        //Так как в инпут для файлов нельзя подставить дефолтное значение, сначала проверили выбрано ли новое изображение
        //если да, то обычная загрузка как при создании
        //есл нет, то просто не загружем новое
        if ($updateImage){
            $statement = $this->dataLink->prepare("UPDATE $this->tablename SET title=?, image=?, text=? WHERE id=$id") ;
            $statement->bind_param('sss', $title, $image, $text);
        }
        else{
            $statement = $this->dataLink->prepare("UPDATE $this->tablename SET title=?, text=? WHERE id=$id") ;
            $statement->bind_param('ss', $title,  $text);
        }

        return $statement->execute();
    }


}
