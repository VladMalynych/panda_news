<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 30.11.2017
 * Time: 9:54
 */

class controller
{
    public $view;

    function __construct(){
        $this->view = new view();
    }

    function default_action($args){
        // This is default action if there is no
        // overwritten one in child class.
    }
}