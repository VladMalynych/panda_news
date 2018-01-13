<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 30.11.2017
 * Time: 0:33
 */

define('UNAUTHORIZED', array(
    'login',
    'registration',
    'contacts'
));

define('AUTHORIZED', array(
    'article',
    'create',
    'edit',
    'home',
    'profile',
    'read',
    'review'
));

class route
{
    public static function start()
    {
        if(!session_id()) session_start();
        if(isset($_SESSION) && !empty($_SESSION)) {
            $controller_name = 'home';
        } else {
            $controller_name = 'login';
        }
        $action_name['name'] = 'default_action';
        $action_name['args'] = null;

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if (sizeof($routes) > 3){ header("Location: http://localhost:8088/error"); exit(); }    // TODO: change link in production
        if ( !empty($routes[1]) ) {
            $glob_args = explode('?', $routes[1]);
            $controller_name = $glob_args[0];
            route::main_wall((isset($_SESSION) && !empty($_SESSION)),$controller_name);
            if (sizeof($glob_args) == 2){
                if($controller_name == "article" || $controller_name == "edit"){
                    $local_args = explode('=', $glob_args[1]);
                    if(sizeof($local_args) == 2 && $local_args[0] == "id"){
                        $action_name['args'] = $local_args[1];
                    }else{ header("Location: error"); exit(); }
                }else{ header("Location: error"); exit(); }
            }elseif (sizeof($glob_args) > 2){ header("Location: error"); exit(); }
        }

        // add postfix
        $controller_name = $controller_name.'_controller';
        // add file with controller class
        $controller_file = strtolower($controller_name).'.php';
        $controller_path = "application/controllers/".$controller_file;
        if(file_exists($controller_path)) {
            include "application/controllers/".$controller_file;
        }
        else {
            header("Location: error"); exit();
        }

        // init route vars
        $controller = new $controller_name;
        $action = $action_name['name'];
        $args = $action_name['args'];

        if(method_exists($controller, $action)) {
            $controller->$action($args);
        } else {
            header("Location: error"); exit();
        }
    }

    private static function main_wall($authorized,$requested_controller){
        if(!$authorized && in_array($requested_controller, AUTHORIZED)){
            session_destroy();
            header("Location: login"); exit();
        } elseif($authorized && in_array($requested_controller, UNAUTHORIZED)){
            header("Location: home"); exit();
        }
    }
}