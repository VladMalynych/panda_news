<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 24.11.2017
 * Time: 15:41
 */

require "libs/rb.php";

$db_conf = parse_ini_file('configs/db_config.ini', false);

if ( $db_conf['db_client'] == "mariadb" || $db_conf['db_client'] == "mysql"){
    R::setup('mysql:host='.$db_conf['db_host'].';dbname='.$db_conf['db_name'],
        $db_conf['db_user'], $db_conf['db_pass']);
    }
elseif($this->db_client == "postgresql"){
    R::setup('pgsql:host='.$db_conf['db_host'].';dbname='.$db_conf['db_name'],
        $db_conf['db_user'], $db_conf['db_pass']); //postgresql
} else{
    throw new ErrorException('Wrong db_client', 1, E_WARNING);
}

if (!R::testConnection()){
    exit('No connection to DB');
}
