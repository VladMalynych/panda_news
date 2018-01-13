<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 30.11.2017
 * Time: 10:57
 */

require_once 'application/models/database/database_connection.php';
require_once 'application/models/object_mng_impl/user_mng.php';

class registration_controller extends controller
{
    private $userManager;

    public function __construct(){
        parent::__construct();
        new database_connection();
        $this->userManager = new user_mng();
    }

    function default_action($args){
        $post = $_POST;
        $data['input'] = $post;

        // TODO : double hash password before sending in POST (ON USER SIDE)
        if (isset($post['reg_button'])) {
            $data['input_errors'] = $this->validate_registration_data($post);
            if (empty($data['input_errors'])){
                $user = $this->create_user($post);
                $this->userManager->create_user($user);
                header('Location: login');
            }
        }
        $this->view->generate('registration_view.php', $data);
    }

    private function validate_registration_data($reg_data){
        $errors = array();
        // TODO: Improve validation of input data.
        if ($this->userManager->find_user_by_username($reg_data['reg_username']) != null){
            $errors[] = "This username is already in use";
        }
        if ($this->userManager->find_user_by_email($reg_data['reg_email']) != null){
            $errors[] = "This email is already in use";
        }
        return $errors;
    }

    private function create_user(&$data){
        if (!empty($data['reg_phone'])){
            return new user($data['reg_name'], $data['reg_surname'], $data['reg_email'], $data['reg_username'],
                password_hash($data['reg_password'],PASSWORD_DEFAULT),type::User, $data['reg_phone']);
        } else{
            return new user($data['reg_name'], $data['reg_surname'], $data['reg_email'], $data['reg_username'],
                password_hash($data['reg_password'],PASSWORD_DEFAULT), type::User);
        }
    }
}