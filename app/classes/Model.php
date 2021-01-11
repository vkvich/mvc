<?php
namespace app\classes;
use app\config\Main;
class Model
{
    public $dataLink;
    //Создает объект для хранения подключения к базе данных
    public function __construct()
    {
        $db = new Main();
        //теперь все созданные модели имеют доступ к базе
        $this->dataLink = $db->dbConnection;
    }
    //перевод результата запроса в массив
	public function get_data($mysqli_result)
	{
	    $data=[];
		foreach ($mysqli_result as $row){
            array_push($data, $row);
        }
		return $data;
	}
	//удаляет запись
    public function delete_Data($id)
    {
        $sql = "DELETE FROM $this->tablename WHERE id=$id";
        return mysqli_query($this->dataLink, $sql);
    }
    //выборка всех записей
    public function getAll($tablename)
    {
        $sql = 'SELECT * FROM '.$tablename;
        return mysqli_query($this->dataLink, $sql);
    }
    //выбрать одну запись
    public function getOne($tablename,$field)
    {

        $sql = 'SELECT * FROM '.$tablename.' WHERE '.$field['name'].'="'.$field['value'].'"';
        $result = mysqli_query($this->dataLink, $sql);

        if($result->num_rows>0){
            $data = $this->get_data($result)[0];
        }
        else{
            $data = NULL;
        }

        return $data;
    }
    //валидация файла
    static function can_upload($file){
        if($file['name'] == '')
            return 'Вы не выбрали файл.';

        /* если размер файла 0, значит его не пропустили настройки
        сервера из-за того, что он слишком большой */
        if($file['size'] == 0)
            return 'Файл слишком большой.';

        $getMime = explode('.', $file['name']);
        // нас интересует последний элемент массива - расширение
        $mime = strtolower(end($getMime));
        $types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');

        if(!in_array($mime, $types))
            return 'Недопустимый тип файла.';

        return true;
    }
    //загрузка картинки, изменение имени, и формирование пути до нее
    static function make_upload($file){
        // формируем уникальное имя картинки: случайное число и name
        $name = mt_rand(0, 10000) . $file['name'];
        copy($file['tmp_name'], 'images/' . $name);
        return '/images/' . $name;
    }

}