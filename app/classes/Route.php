<?php
namespace app\classes;
use app\controllers\ControllerMain;
use app\controllers\ControllerAdmin;
/*
Класс-маршрутизатор для определения запрашиваемой страницы.
> создает экземпляры контролеров страниц и вызывает действия этих контроллеров.
*/
class Route
{
    //формирует корректные имя экшена и параметры
    static function buildRoute($routes){
        //значения по умолчанию
        $route['action']='index';
        $route['param']='';
        //в routes передается массив разбранного на составляющие URI
        //Если routes пустой, то мы на главной странице, отработает action index
        if ( !empty($routes[1]) )
        {
            //имя экшена если нет параметрови не главная страница
            $route['action'] = $routes[1];
        }
        $params = explode('?', $route['action']);
        //если в запросе есть параметры
        if (count($params)>1){
            //записывает название и значение параметра, сделано примитивно для одного параметра
            $route['param'] = explode('=',$params[1])[1];
            //переписывает имя экшена так как в первый раз он записался вместе с параметрами
            $route['action'] = $params[0];
        }
        return $route;

    }
    static function start()
	{
		// контроллер и действие по умолчанию
        $admin = new ControllerAdmin;
        $main = new ControllerMain;
        $defaultController = $main;

        $routes = explode('/', $_SERVER['REQUEST_URI']);
        $route = Route::buildRoute($routes);
		// если получили экшн admin значит нужно соответственно сменить контроллер
		if ($route['action'] == 'admin'){
            session_start();
            $user = $_SESSION;
            session_write_close();
            //  если пользователь авторизован и он админ
            if(isset($user['logged_user'])){
                if ($user['logged_user']['login'] == 'admin'){
                    $defaultController = $admin;
                    $routes = explode('/admin/', $_SERVER['REQUEST_URI']);
                    //переписываем имя экшена и параметры для контроллера админна
                    $route = Route::buildRoute($routes);
                }
                else
                {
                    Route::ErrorPage404();
                    $defaultController->action_404();
                    header('Location:/');
                    return;
                }
            }else
            {
                Route::ErrorPage404();
                $defaultController->action_404();
                header('Location:/');
                return;
            }

        }
        //формирует название метода
        $action = 'action_'.$route['action'];

		if(method_exists($defaultController, $action))
		{
			// вызываем действие контроллера
            $defaultController->$action($route['param']);
		}
		else
		{
			Route::ErrorPage404();
            $defaultController->action_404();
		}
	
	}

	static function ErrorPage404()
	{
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
    }
    
}
