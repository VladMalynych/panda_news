<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 24.11.2017
 * Time: 16:59
 */

require_once 'application/models/database/database_connection.php';
require_once('application/models/object_mng_virtual/user_mng_interface.php');
require_once('application/models/objects/user.php');

class user_mng implements user_mng_interface
{
    public function create_user(user &$user){
        if( $this->find_user_by_username($user->getUsername()) == null ) {
            $new_user = R::xdispense('user');
            $new_user->name = $user->getName();
            $new_user->surname = $user->getSurname();
            $new_user->email = $user->getEmail();
            $new_user->username = $user->getUsername();
            $new_user->password = $user->getPassword();
            $new_user->phone = $user->getPhone();
            $new_user->type = $user->getType();
            $user_id_ret_val = R::store($new_user);
            return $this->find_user($user_id_ret_val);
        }
        return null;
    }

    private function update_user_impl(int $user_id, user &$user){
        $temp_user = R::load('user', $user_id);
        $temp_user->name = $user->getName();
        $temp_user->surname = $user->getSurname();
        $temp_user->email = $user->getEmail();
        $temp_user->password = $user->getPassword();
        $temp_user->phone = $user->getPhone();
        $user_id_ret_val = R::store($temp_user);
        return $this->find_user($user_id_ret_val);
    }

    public function update_user(user &$user){
        if ( $user->getId() == NULL ){
            $update_user = $this->find_user_by_username($user->getUsername());
            if ( $update_user == null){
                return null;
            }
        } else {
            $update_user = $this->find_user($user->getId());
            if ( $update_user == null){
                return null;
            }
        }
        return $this->update_user_impl($update_user->getId(), $user);
    }

    public function delete_user_by_id(int $user_id){
        if ($this->find_user($user_id) == null){
            return false;
        }
        R::trash('user', $user_id);
        return true;
    }

    public function delete_user_by_username(string $username){
        $user = $this->find_user_by_username($username);
        if( $user == null){
            return false;
        }
        return $this->delete_user_by_id($user->getId());
    }

    public function find_user(int $user_id){
        $bean_user = R::findOne('user', "`id` = ?", [$user_id]);

        if( $bean_user == null)
            return null;
        return $this->map_bean($bean_user);
    }

    public function find_user_by_username(string $username){
        $bean_user = R::findOne('user', "`username` = ?", [$username]);
        if( $bean_user == null)
            return null;
        return $this->map_bean($bean_user);
    }

    public function find_user_by_email(string $email){
        $bean_user = R::findOne('user', "`email` = ?", [$email]);
        if( $bean_user == null)
            return null;
        return $this->map_bean($bean_user);
    }

    public function find_all_users(){
        $bean_users = R::findAll('user', 'ORDER BY `name` DESC');
        if ($bean_users == null)
            return null;
        $user_array = array();
        foreach ($bean_users as &$bean_user) {
            array_push($user_array,$this->map_bean($bean_user));
        }
        return $user_array;
    }

    private function map_bean(RedBeanPHP\OODBBean $bean){
        if ($bean == null){
            throw new ErrorException('Bean does not exist', 1, E_WARNING);
        }
        $bean->export();
        return new user( $bean['name'], $bean['surname'], $bean['email'], $bean['username'],
                         $bean['password'], intval($bean['type']), $bean['phone'], $bean['id'] );
    }
}