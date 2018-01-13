<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 30.11.2017
 * Time: 10:02
 */

class error_controller extends controller
{
    function default_action($args){
        $this->view->generate('error_view.php');
    }
}