<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 01.12.2017
 * Time: 16:21
 */

require_once 'application/models/database/database_connection.php';
require_once 'application/models/object_mng_impl/user_mng.php';

class profile_controller extends controller
{
    private $userManager;

    public function __construct(){
        parent::__construct();
        new database_connection();
        $this->userManager = new user_mng();
    }

    function default_action($args){
        $post = $_POST;
        $user = $this->userManager->find_user($_SESSION['user']);

        if(isset($post['update_data_button'])){
            // TODO: Divide to separate functions
            // TODO: Make validation of input data
            $update_data_needed = false;
            $errors = array();
            if($post['profile_name'] != $user->getName()){
                $update_data_needed = true;
                $user->setName($post['profile_name']);
            }
            if($post['profile_surname'] != $user->getSurname()){
                $update_data_needed = true;
                $user->setSurname($post['profile_surname']);
            }
            if($post['profile_email'] != $user->getEmail()){
                if ($this->userManager->find_user_by_email($post['profile_email']) != null){
                    $errors[] = "This email is already in use";
                }
                $update_data_needed = true;
                $user->setEmail($post['profile_email']);
            }
            if($post['profile_phone'] != $user->getPhone()){
                $update_data_needed = true;
                $user->setPhone($post['profile_phone']);
            }

            $data['update_data_errors'] = $errors;

            if (empty($errors) && $update_data_needed){
                $this->userManager->update_user($user);
            }
        }

        if ( isset($post['update_password_button']) ){
            $errors = array();
            if(password_verify($post['profile_old_password'], $user->getPassword())){
                $user->setPassword(password_hash($post['profile_new_password'],PASSWORD_DEFAULT));
            }else{
                $errors[] = "Current password is wrong!";
            }

            $data['update_password_errors'] = $errors;

            if (empty($errors)){
                $this->userManager->update_user($user);
            }
        }

        if( isset($post['logout_button']) ){
            unset($_SESSION);
            session_destroy();
            header('Location: login');
        }

        $data['user'] = $user;
        $this->view->generate('profile_view.php', $data);
    }
}