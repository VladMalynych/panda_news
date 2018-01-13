<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 24.11.2017
 * Time: 16:14
 */

interface user_mng_interface
{
    // Create
    public function create_user(user &$user);
    // Update
    public function update_user(user &$user);
    // Delete
    public function delete_user_by_id(int $user_id);
    public function delete_user_by_username(string $username);
    // Read
    public function find_user(int $user_id);
    public function find_user_by_username(string $username);
    public function find_user_by_email(string $email);
    public function find_all_users();
}