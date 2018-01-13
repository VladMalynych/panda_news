<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 30.12.2017
 * Time: 23:48
 */

require_once 'application/models/database/database_connection.php';
require_once 'application/models/object_mng_impl/user_mng.php';
require_once 'application/models/object_mng_impl/article_mng.php';
require_once 'application/models/object_mng_impl/review_mng.php';

class review_controller extends controller
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
        $data['admin_articles'] = $this->articleManager->find_all_articles();
        $data['admin_users'] = $this->userManager->find_all_users();

        if(isset($post['assign_reviewer_button'])) {
            $admin_article_selected = isset($post['admin_article_select']) ? $post['admin_article_select'] : false;
            $admin_user_selected = isset($post['admin_user_select']) ? $post['admin_user_select'] : false;

            if ($admin_article_selected) {
                if ($admin_user_selected) {
                    $new_review = new review($admin_user_selected,$admin_article_selected);
                    $this->reviewManager->create_review($new_review);
                } else { header('error'); exit(); }
            } else { header('error'); exit(); }
        }

        if (isset($post['review_status_select'])){
            switch ($post['review_status_select']){
                case 'to_be_reviewed':
                    $reviews = $this->reviewManager->find_reviews_by_user_id_with_status($_SESSION['user'], status::None);
                    break;
                case 'approved':
                    $reviews = $this->reviewManager->find_reviews_by_user_id_with_status($_SESSION['user'], status::Approved);
                    break;
                case 'rejected':
                    $reviews = $this->reviewManager->find_reviews_by_user_id_with_status($_SESSION['user'], status::Rejected);
                    break;
                default:
                    header('error');
                    exit();
            }
        }else{
            $reviews = $this->reviewManager->find_reviews_by_user_id_with_status($_SESSION['user'], status::None);
        }

        if (!empty($reviews)) {
            foreach ($reviews as $review) {
                $article = $this->articleManager->find_article_by_id($review->getArticleId());
                array_push($data['articles'], array(
                    $article,
                    $this->userManager->find_user($_SESSION['user'])->getUsername()
                ));
            }
        }
        $this->view->generate('review_view.php',$data);
    }
}