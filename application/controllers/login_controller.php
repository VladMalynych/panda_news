<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 30.11.2017
 * Time: 10:56
 */

require_once 'application/models/database/database_connection.php';
require_once 'application/models/object_mng_impl/user_mng.php';

class login_controller extends controller
{
    private $userManager;

    public function __construct(){
        parent::__construct();
        new database_connection();
        $this->userManager = new user_mng();
    }

    function default_action($args){
        $post = $_POST;
        if(isset($post['login_username']) && isset($post['login_password'])) {
            $login = $post['login_username'];
            $password = $post['login_password'];

            $user = $this->userManager->find_user_by_username($login);
            if($user != null && password_verify($password, $user->getPassword())) {
                $data["login_status"] = "access_granted";
                $_SESSION['user'] = $user->getId();
                $_SESSION['role'] = $user->getType();
                header('Location: home');
                exit();
            }
            else {
                $data["login_status"] = "access_denied";
            }
        }
        else {
            $data["login_status"] = "";
        }
        $this->view->generate('login_view.php', $data);
    }
}

