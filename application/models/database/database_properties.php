<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 24.11.2017
 * Time: 14:06
 */

class database_properties
{
    protected $db_client;
    protected $db_host;
    protected $db_name;
    protected $db_user;
    protected $db_pass;

    protected $admin_name;
    protected $admin_surname;
    protected $admin_email;
    protected $admin_phone;
    protected $admin_username;
    protected $admin_password;

    public function __construct()
    {
        $db_conf = parse_ini_file('configs/db_config.ini', false);
        $this->db_client = $db_conf['db_client'];
        $this->db_host   = $db_conf['db_host'];
        $this->db_name   = $db_conf['db_name'];
        $this->db_user   = $db_conf['db_user'];
        $this->db_pass   = $db_conf['db_pass'];

        $this->admin_name     = $db_conf['admin_name'];
        $this->admin_surname  = $db_conf['admin_surname'];
        $this->admin_email    = $db_conf['admin_email'];
        $this->admin_username = $db_conf['admin_username'];
        $this->admin_password = $db_conf['admin_password'];
        $this->admin_phone    = $db_conf['admin_phone'];
    }
}