<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 30.11.2017
 * Time: 9:54
 */

class view
{
    private $template_view = 'application/views/template_view.php';

    /*
    $content_file - views for content;
    $data - array of data got from db;
    */
    function generate($content_view, $data = null, $template_view = null){

        if ($template_view != null){
            $this->template_view = $template_view;
        }
        include $this->template_view;
    }
}