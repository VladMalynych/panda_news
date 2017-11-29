<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 24.11.2017
 * Time: 14:10
 */

require "libs/rb.php";
require_once "database_properties.php";

class database_connection extends database_properties
{
    public function __construct(){
        parent::__construct();

        if ( $this->db_client == "mariadb" || $this->db_client == "mysql")
            $this->db_connect_mysql();
        elseif($this->db_client == "postgresql")
            $this->db_connect_postgresql();
        else{
            throw new ErrorException('Wrong db_client', 1, E_WARNING);
        }
        $this->test_connection();
        R::ext('xdispense', function($table_name){
            return R::getRedBean()->dispense($table_name);
        });

        /*
           This should be done only during first run
           on server to configure it correctly.
        */
        $this->configure_db();

        R::freeze(true);
    }

    private function configure_db(){
        $this->create_tables();
        $this->create_admin();
    }

    private function create_tables(){
        if (!$this->table_exists('user'))
            $this->db_create_user_table();
        if (!$this->table_exists('article'))
            $this->db_create_article_table();
        if (!$this->table_exists('comment'))
            $this->db_create_comment_table();
        if (!$this->table_exists('score'))
            $this->db_create_score_table();
    }

    private function create_admin(){
        $user = new user($this->admin_name, $this->admin_surname, $this->admin_email,
                         $this->admin_username, $this->admin_password, $this->admin_phone);
        $user_manager = new user_mng();
        $user_manager->create_user($user);
    }

    private function table_exists(string $table_name){
        if (R::exec("SELECT * FROM INFORMATION_SCHEMA.TABLES 
                     WHERE TABLE_SCHEMA = '".$this->db_name."'
                     AND TABLE_NAME = '".$table_name."';") > 0){
            return true;
        } else{
            return false;
        }
    }

    private function db_create_user_table(){
        R::exec('CREATE TABLE `user` (
                 `id` INT NOT NULL AUTO_INCREMENT,
                 `name` VARCHAR(255) NOT NULL,
                 `surname` VARCHAR(255) NOT NULL,
                 `email` VARCHAR(255) NOT NULL,
                 `username` VARCHAR(255) NOT NULL,
                 `password` VARCHAR(255) NOT NULL,
                 `phone` VARCHAR(255),
                 PRIMARY KEY (`id`) );'
        );
    }

    private function db_create_article_table(){
        R::exec('CREATE TABLE `article` (
                 `id` INT NOT NULL AUTO_INCREMENT,
                 `user_id` INT NOT NULL,
                 `name` VARCHAR(255) NOT NULL,
                 `content` MEDIUMTEXT NOT NULL,
                 `status` BOOLEAN NOT NULL,
                 `post_time` DATETIME NOT NULL,
                 PRIMARY KEY (`id`) );'
        );
    }

    private function db_create_comment_table(){
        R::exec('CREATE TABLE `comment` (
                 `id` INT NOT NULL AUTO_INCREMENT,
                 `user_id` INT NOT NULL,
                 `article_id` INT NOT NULL,
                 `content` MEDIUMTEXT NOT NULL,
                 `points` INT NOT NULL,
                 `post_time` DATETIME NOT NULL,
                 PRIMARY KEY (`id`) );'
        );
    }

    private function db_create_score_table(){
        R::exec('CREATE TABLE `score` (
                 `id` INT NOT NULL AUTO_INCREMENT,
                 `user_id` INT NOT NULL,
                 `article_id` INT NOT NULL,
                 `points` INT NOT NULL,
                 PRIMARY KEY (`id`) );'
        );
    }

    private function db_connect_mysql(){
        R::setup('mysql:host='.$this->db_host.';dbname='.$this->db_name,
            $this->db_user, $this->db_pass, false); //mysql
    }

    private function db_connect_postgresql(){
        R::setup('pgsql:host='.$this->db_host.';dbname='.$this->db_name,
            $this->db_user, $this->db_pass, false); //postgresql
    }

    private function test_connection(){
        if (!R::testConnection()){
            exit('No connection to DB');
        }
    }

    public function __destruct(){
        R::close();
    }
}