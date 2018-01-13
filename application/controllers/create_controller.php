<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 05.12.2017
 * Time: 10:45
 */

require_once 'application/models/database/database_connection.php';
require_once 'application/models/object_mng_impl/article_mng.php';

class create_controller extends controller
{
    private $articleManager;

    public function __construct(){
        parent::__construct();
        new database_connection();
        $this->articleManager = new article_mng();
    }

    function default_action($args){
        $post = $_POST;

        if (isset($post['create_article_button'])) {
            // TODO : add article data validation

            $article = new article($_SESSION['user'], $post['article_name'], $post['text_editor']);
            if (empty($post['article_id'])) {
                $saved_article = $this->articleManager->create_article($article);
            } else{
                $saved_article = $this->articleManager->find_article_by_id(intval($post['article_id']));
                if($saved_article != null){
                    $article->setId($saved_article->getId());
                    $this->articleManager->update_article($article);
                }else{
                    header('Location: error');
                    exit();
                }
            }
            $data['article_id'] = $saved_article->getId();
        }

        if (!empty($data['article_id'])){
            $data['update_article'] = true;
        } else{
            $data['update_article'] = false;
        }

        $data['input'] = $post;
        $this->view->generate('create_view.php', $data);
    }
}