<?php
namespace app\controllers;
use app\classes\Model;
use app\models\ModelArticle;
use app\models\ModelSignup;
use app\classes\Controller;
use app\classes\Route;
class ControllerMain extends Controller
{
    private $isAdmin = false;
	function action_index()
	{
        $model = new Model();
        $data = $model->getAll('article');
        $this->view->generate('articles_view.php', 'template_view.php', $data);
	}
	//регистрация (по хорошему содать бы вообще отдельно валидацию и список с текстами ошибок)
    function  action_signup(){
        $data = $_POST;
        if(isset($data['do_signup'])) {
            $model = new ModelSignup();
            $errors = array();
            if(trim($data['login']) == '') {
                $errors[] = "Введите логин!";
            }
            if($data['password'] == '') {
                $errors[] = "Введите пароль";
            }
            if($data['password_2'] != $data['password']) {
                $errors[] = "Повторный пароль введен не верно!";
            }
            // функция mb_strlen - получает длину строки
            // Если логин будет меньше 3 символов и больше 90, то выйдет ошибка
            if(mb_strlen($data['login']) < 3 || mb_strlen($data['login']) > 90) {
                $errors[] = "Недопустимая длина логина";
            }else{
                if ($model->getUser($data['login'])){
                    $errors[] = "Логин уже занят!";
                }
            }
            if (mb_strlen($data['password']) < 2 || mb_strlen($data['password']) > 8){
                $errors[] = "Недопустимая длина пароля (от 2 до 8 символов)";
            }
            if(empty($errors)) {
                $password = password_hash($data['password'], PASSWORD_DEFAULT);
                // Сохраняем таблицу
                $user['login']=$data['login'];
                $user['pass']=$password;
                $model->insert_Data($user);
                $result = 'success';
                $this->view->generate('signup_view.php', 'template_view.php', $result);
            } else {
                $data['errors']=$errors;
                $this->view->generate('signup_view.php', 'template_view.php', $data);
            }
        }
        else{
            $this->view->generate('signup_view.php', 'template_view.php');
        }
    }
    //авторизация
    function action_login()
    {
        $data = $_POST;
        if(isset($data['do_login'])) {
            $errors = array();
            $user = $this->getUser($data);
            if($user) {
                // Если логин существует, тогда проверяем пароль
                if(password_verify($data['password'], $user['pass'])) {
                    if ($user['login'] == 'admin'){
                        $this->isAdmin = true;
                    }
                    // Все верно, пускаем пользователя
                    session_start();
                    $_SESSION['logged_user'] = $user;

                    session_write_close();
                    // Редирект на главную страницу
                    header('Location: /');
                    $this->action_index();
                } else {
                    $errors[] = 'Пароль неверно введен!';
                }
            } else {
                $errors[] = 'Пользователь с таким логином не найден!';
            }
            if(!empty($errors)) {
                $data['errors']=$errors;
                $this->view->generate('login_view.php', 'template_view.php', $data);
            }
        }
        else{
            $this->view->generate('login_view.php', 'template_view.php');
        }
    }
   //поиск пользователя по логину
    function getUser($data){
        $model = new Model();
        $field['name'] = 'login';
        $field['value']=$data['login'];
        // Проводим поиск пользователей в таблице users
        $user = $model->getOne('users', $field);
        return $user;
    }
    //выход
    function action_logout()
    {
        session_start();
        unset($_SESSION['logged_user']);
        $this->isAdmin = false;
        session_write_close();
        // Редирект на главную страницу
        header('Location:/');
    }
    //Удаление статьи
    function action_deleteArticle($id)
    {
        if ($this->isAdmin){
            $model = new ModelArticle();
            $data = $model->delete_Data($id);
            if ($data!==NULL){
                header('Location:/');
                $this->action_index();
            }
            else{
                Route::ErrorPage404();
                $this->action_404();
            }
        }
        else{
            Route::ErrorPage404();
            $this->action_404();
        }
    }
    //страница статьи
    function action_article($id)
    {
        $model = new ModelArticle();
        $field['name']='id';
        $field['value']=$id;
        $data = $model->getOne('article',$field);
        if ($data!==NULL){
            $this->view->generate('article_view.php', 'template_view.php', $data);
        }
        else{
            Route::ErrorPage404();
            $this->action_404();
        }
    }
    //Новая статья
    function action_newArticle()
    {
        if ($this->isAdmin){
            $model = new ModelArticle();
            if($model->insert_Data($_POST)){
                header('Location:/');
                $this->action_index();
            }
            else{
                header('Location:/create');
                $this->action_create('fail');
            }
        }
        else{
            Route::ErrorPage404();
            $this->action_404();
        }
    }
    //Обновить статью
    function action_updateArticle($id)
    {
        if ($this->isAdmin){
            $model = new ModelArticle();
            if($model->update_Data($_POST, $id)){
                header('Location:/');
                $this->action_index();
            }
            else{
                header('Location:/create');
                $this->action_create('fail');
            }
        }
        else{
            Route::ErrorPage404();
            $this->action_404();
        }
    }
    function action_update($id){
        if ($this->isAdmin){
            $model = new ModelArticle();
            $field['name']='id';
            $field['value']=$id;
            $data = $model->getOne('article',$field);
            $data['id'] = $id;
            if ($data!==NULL){
                $this->view->generate('update_view.php', 'template_view.php',$data);
            }
            else{
                Route::ErrorPage404();
                $this->action_404();
            }
        }
        else{
            Route::ErrorPage404();
            $this->action_404();
        }
    }
    function action_create($data){
        if ($this->isAdmin){
            $this->view->generate('create_view.php', 'template_view.php',$data);

        }
        else{
            Route::ErrorPage404();
            $this->action_404();
        }
    }
    function action_404()
    {
        $this->view->generate('404_view.php', 'template_view.php');
    }
}