<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 30.11.2017
 * Time: 10:03
 */

require_once 'application/models/database/database_connection.php';
require_once 'application/models/object_mng_impl/user_mng.php';
require_once 'application/models/object_mng_impl/article_mng.php';
require_once 'application/models/object_mng_impl/review_mng.php';

class home_controller extends controller
{
    private $userManager;
    private $articleManager;
    private $reviewManager;

    public function __construct(){
        parent::__construct();
        new database_connection();
        $this->userManager = new user_mng();
        $this->articleManager = new article_mng();
        $this->reviewManager = new review_mng();
    }

    function default_action($args){
        $post = $_POST;
        $data['input'] = $post;
        $data['articles'] = array();
        $data['admin_articles'] = array();

        if (isset($post['approve_article_button'])){
            $update_article = $this->articleManager->find_article_by_id(intval($post['approve_article_button']));
            if ($update_article != null){
                $update_article->setStatus(status::Approved);
                $this->articleManager->update_article($update_article);
            }else{ header('error'); exit(); }
        }

        if (isset($post['reject_article_button'])){
            $update_article = $this->articleManager->find_article_by_id(intval($post['reject_article_button']));
            if ($update_article != null){
                $update_article->setStatus(status::Rejected);
                $this->articleManager->update_article($update_article);
            }else{ header('error'); exit(); }
        }

        if (isset($post['home_status_select'])){
            switch ($post['home_status_select']) {
                case 'all':
                    $articles = $this->articleManager->find_articles_by_user_id($_SESSION['user']);
                    break;
                case 'in_progress':
                    $articles = $this->articleManager->find_articles_by_user_id_and_status($_SESSION['user'], status::None);
                    break;
                case 'approved':
                    $articles = $this->articleManager->find_articles_by_user_id_and_status($_SESSION['user'], status::Approved);
                    break;
                case 'rejected':
                    $articles = $this->articleManager->find_articles_by_user_id_and_status($_SESSION['user'], status::Rejected);
                    break;
                default:
                    header('error');
                    exit();
            }
        }else{
            $articles = $this->articleManager->find_articles_by_user_id($_SESSION['user']);
        }

        if (isset($post['article_admin_status_select'])){
            switch ($post['article_admin_status_select']) {
                case 'all':
                    $admin_articles = $this->articleManager->find_all_articles();
                    break;
                case 'in_progress':
                    $admin_articles = $this->articleManager->find_articles_by_status(status::None);
                    break;
                case 'approved':
                    $admin_articles = $this->articleManager->find_articles_by_status(status::Approved);
                    break;
                case 'rejected':
                    $admin_articles = $this->articleManager->find_articles_by_status(status::Rejected);
                    break;
                default:
                    header('error');
                    exit();
            }
        }else{
            $admin_articles = $this->articleManager->find_all_articles();
        }

        if(!empty($admin_articles)){
            foreach ($admin_articles as $admin_article){
                $admin_article_reviews = $this->reviewManager->find_reviews_by_article_id($admin_article->getId());
                $users_none = array();
                $users_approvers = array();
                $users_rejectors = array();

                if(!empty($admin_article_reviews)){
                    foreach($admin_article_reviews as $admin_article_review){
                        $temp_username = $this->userManager->find_user($admin_article_review->getUserId())->getUsername();
                        if ($temp_username != null) {
                            if ($admin_article_review->getStatus() == status::None) {
                                array_push($users_none, $temp_username);
                            } elseif ($admin_article_review->getStatus() == status::Approved) {
                                array_push($users_approvers, $temp_username);
                            } elseif ($admin_article_review->getStatus() == status::Rejected) {
                                array_push($users_rejectors, $temp_username);
                            } else { header('error'); exit(); }
                        }else{ header('error'); exit(); }
                    }
                }

                array_push($data['admin_articles'], array(
                    $admin_article,
                    $users_none,
                    $users_approvers,
                    $users_rejectors
                ));
            }
        }

        if (!empty($articles)) {
            foreach ($articles as $article) {
                array_push($data['articles'], array(
                    $article,
                    $this->userManager->find_user($_SESSION['user'])->getUsername()
                ));
            }
        }
        $this->view->generate('home_view.php',$data);
    }
}