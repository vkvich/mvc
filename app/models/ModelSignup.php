<?php
namespace app\models;
use app\classes\Model;
class ModelSignup extends Model
{
    public $dataLink;
    public $tablename = 'users';

	public function insert_Data($data)
    {
        $login = filter_var($data["login"], FILTER_SANITIZE_STRING);
        $pass = filter_var($data["pass"], FILTER_SANITIZE_STRING);
        if (empty($login)){
            return false;
        }

        $statement = $this->dataLink->prepare("INSERT INTO $this->tablename (login, pass) VALUES(?, ?)");
        $statement->bind_param('ss', $login, $pass);
        return $statement->execute();
//        return false;
    }
    public function getUser($login){
        $statement = $this->dataLink->prepare("SELECT * FROM $this->tablename  WHERE login=?");
        $statement->bind_param('s', $login);
        return $statement->execute();
    }


}
