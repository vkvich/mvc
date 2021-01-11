<?php
namespace app\controllers;
use app\classes\Model;
use app\models\ModelArticle;
use app\classes\Controller;
use app\classes\Route;
class ControllerAdmin extends Controller
{
	function action_index()
	{
        $this->view->generate('admin/admin_view.php', 'admin/template_view.php');
	}
	//список статей
    function action_articles()
    {
        $model = new Model();
        $data = $model->getAll('article');
        $this->view->generate('admin/articles_view.php', 'admin/template_view.php', $data);
    }
	
	function action_logout()
	{
		session_start();
		session_destroy();
		header('Location:/');
	}
    //удаление статьи
    function action_deleteArticle($id)
    {
        $model = new ModelArticle();
        $data = $model->delete_Data($id);
        if ($data!==NULL){
            header('Location:/admin/articles');
            $this->action_index();
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
            $this->view->generate('admin/article_view.php', 'admin/template_view.php', $data);
        }
        else{
            Route::ErrorPage404();
            $this->action_404();
        }
    }
    //создание статьи (можно было объеденить action_newArticle и action_create, как с формами авторизации)
    function action_newArticle()
    {
        $model = new ModelArticle();
        if($model->insert_Data($_POST)){
            header('Location:/admin/articles');
            $this->action_index();
        }
        else{
            header('Location:admin/create');
            $this->action_create('fail');
        }
    }
    //создание статьи (можно было объеденить action_updateArticle и action_update, как с формами авторизации)
    function action_updateArticle($id)
    {
        $model = new ModelArticle();
        if($model->update_Data($_POST, $id)){
            header('Location:/admin/articles');
            $this->action_index();
        }
        else{
            $this->action_update($id);
        }
    }
    function action_update($id){
        $model = new ModelArticle();
        $field['name']='id';
        $field['value']=$id;
        $data = $model->getOne('article',$field);
        $data['id'] = $id;
        if ($data!==NULL){
            $this->view->generate('admin/update_view.php', 'admin/template_view.php',$data);
        }
        else{
            Route::ErrorPage404();
            $this->action_404();
        }
    }
    function action_create($data){
        $this->view->generate('admin/create_view.php', 'admin/template_view.php',$data);
    }
    function action_404()
    {
        $this->view->generate('404_view.php', 'admin/template_view.php');
    }
}
