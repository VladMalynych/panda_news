<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 12.01.2018
 * Time: 0:39
 */

require_once 'application/models/database/database_connection.php';
require_once 'application/models/object_mng_impl/article_mng.php';
require_once 'application/models/object_mng_impl/review_mng.php';
require_once 'application/models/object_mng_impl/score_mng.php';
require_once 'application/models/object_mng_impl/comment_mng.php';
require_once 'application/models/object_mng_impl/user_mng.php';

class edit_controller extends controller
{
    private $articleManager;
    private $scoreManager;
    private $commentManager;
    private $reviewManager;
    private $userManager;

    public function __construct(){
        parent::__construct();
        new database_connection();
        $this->articleManager = new article_mng();
        $this->reviewManager = new review_mng();
        $this->scoreManager = new score_mng();
        $this->commentManager = new comment_mng();
        $this->userManager = new user_mng();
    }

    function default_action($args){
        $post = $_POST;
        if(!empty($args) && is_numeric($args)){
            $article = $this->articleManager->find_article_by_id($args); //TODO: Validate args: wrong value w
            if($article != null) {
                if ($article->getUserId() == $_SESSION['user'] || $_SESSION['role'] == type::Admin){
                    $data['article'] = $article;

                    if (isset($post['edit_article_button'])) {
                        $article->setName($post['article_name']);
                        $article->setContent($post['text_editor']);
                        $data['article'] = $this->articleManager->update_article($article);
                    } elseif (isset($post['delete_article_button'])) {
                        $this->trash_article($article);
                        header('Location: home');
                        exit();
                    }

                    $this->view->generate('edit_view.php', $data);
                }else{ header('Location: error'); exit(); }
            }else{ header('Location: error'); exit(); }
        }else{ header('Location: error'); exit(); }
    }

    private function trash_article(article &$article)
    {
        $trash['reviews'] = $this->reviewManager->find_reviews_by_article_id($article->getId());
        $trash['scores'] = $this->scoreManager->find_scores_by_article_id($article->getId());
        $trash['comments'] = $this->commentManager->find_comments_by_article_id($article->getId());

        if ($trash['reviews'] != null) {
            foreach ($trash['reviews'] as $review) {
                $this->reviewManager->delete_review($review->getId());
            }
        }
        if ($trash['scores'] != null) {
            foreach ($trash['scores'] as $score) {
                $this->scoreManager->delete_score($score->getId());
            }
        }
        if ($trash['comments'] != null) {
            foreach ($trash['comments'] as $comment) {
                $this->commentManager->delete_comment($comment->getId());
            }
        }
        $this->articleManager->delete_article($article->getId());
    }

}