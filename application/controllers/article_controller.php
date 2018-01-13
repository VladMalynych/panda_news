<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 11.12.2017
 * Time: 9:39
 */

require_once 'application/models/database/database_connection.php';
require_once 'application/models/object_mng_impl/article_mng.php';
require_once 'application/models/object_mng_impl/review_mng.php';
require_once 'application/models/object_mng_impl/score_mng.php';
require_once 'application/models/object_mng_impl/comment_mng.php';
require_once 'application/models/object_mng_impl/user_mng.php';

class article_controller extends controller
{
    private $articleManager;
    private $commentManager;
    private $reviewManager;
    private $userManager;

    public function __construct(){
        parent::__construct();
        new database_connection();
        $this->articleManager = new article_mng();
        $this->reviewManager = new review_mng();
        $this->commentManager = new comment_mng();
        $this->userManager = new user_mng();
    }

    function default_action($args){
        $post = $_POST;

        if(!empty($args) && is_numeric($args)){
            $article = $this->articleManager->find_article_by_id($args); //TODO: Validate args: wrong value w
            $data['status'] = array();
            if($article != null) {

                $review = $this->reviewManager->find_review_by_user_id_and_article_id($_SESSION['user'], $article->getId());
                if (isset($post['set_review_button'])) {
                    if($review != null) {
                        $review_status_selected = isset($post['review_status_select']) ? $post['review_status_select'] : false;
                        if ($review_status_selected) {
                            switch ($review_status_selected) {
                                case 'approved':
                                    $review->setStatus(status::Approved);
                                    $this->reviewManager->update_review($review);
                                    break;
                                case 'rejected':
                                    $review->setStatus(status::Rejected);
                                    $this->reviewManager->update_review($review);
                                    break;
                                default:
                                    header('error');
                                    exit();
                            }
                        }
                    } else{ header('error');exit(); }
                }

                if (isset($post['create_comment_button'])) {
                    $new_comment = new comment($article->getId(), $_SESSION['user'], $post['text_editor']);
                    if ($this->commentManager->create_comment($new_comment) == null){
                        header('Location: error'); exit();
                    }
                }elseif (isset($post['edit_article_button'])) {
                    header('Location: edit?id='.$article->getId()); exit();
                }

                if($article->getUserId() == $_SESSION['user']){
                    array_push($data['status'],"creator");
                }
                if($review != null){
                    array_push($data['status'],"reviewer");
                    $data['review_status_selected'] = $review->getStatus();
                }
                if($_SESSION['role'] == type::Admin){
                    array_push($data['status'],"admin");
                }

                $data['article'] = $article;
                $data['comments'] = array();
                $raw_comments = $this->commentManager->find_comments_by_article_id($article->getId());
                if(!empty($raw_comments)){
                    foreach ($raw_comments as $raw_comment) {
                        array_push($data['comments'], array(
                            $raw_comment,
                            $this->userManager->find_user($raw_comment->getUserId())->getUsername()
                        ));
                    }
                }
                $this->view->generate('article_view.php', $data);
            }else{ header('Location: error'); exit(); }
        }else{ header('Location: error'); exit(); }
    }
}