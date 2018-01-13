<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 30.11.2017
 * Time: 10:03
 */

class contacts_controller extends controller
{
    function default_action($args){
        $this->view->generate('contacts_view.php');
    }
}