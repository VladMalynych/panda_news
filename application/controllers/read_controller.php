<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 07.12.2017
 * Time: 10:59
 */

require_once 'application/models/database/database_connection.php';
require_once 'application/models/object_mng_impl/user_mng.php';
require_once 'application/models/object_mng_impl/article_mng.php';
class read_controller extends controller
{
    private $userManager;
    private $articleManager;

    public function __construct(){
        parent::__construct();
        new database_connection();
        $this->userManager = new user_mng();
        $this->articleManager = new article_mng();
    }

    function default_action($args){
        $post = $_POST;

        $data['input'] = $post;
        $data['articles'] = array();

        if(isset($post['find_button'])) {
            $user_selected = isset($post['user_select']) ? $post['user_select'] : false;
            $status_selected = isset($post['status_select']) ? $post['status_select'] : false;

            if ($user_selected) {
                if ($status_selected) {
                    switch ($status_selected) {
                        case 'all':
                            $articles = $this->articleManager->find_articles_by_user_id(intval($user_selected));
                            break;
                        case 'in_progress':
                            $articles = $this->articleManager->find_articles_by_user_id_and_status(intval($user_selected), status::None);
                            break;
                        case 'approved':
                            $articles = $this->articleManager->find_articles_by_user_id_and_status(intval($user_selected), status::Approved);
                            break;
                        case 'rejected':
                            $articles = $this->articleManager->find_articles_by_user_id_and_status(intval($user_selected), status::Rejected);
                            break;
                        default:
                            header('error');
                            exit();
                    }
                } else {
                    header('error');
                    exit();
                }
            } else {
                header('error');
                exit();
            }
            if (!empty($articles)) {
                foreach ($articles as $article) {
                    array_push($data['articles'], array(
                        $article,
                        $this->userManager->find_user($article->getUserId())->getUsername()
                    ));
                }
            }
        }

        $data['users'] = $this->userManager->find_all_users();
        $this->view->generate('read_view.php',$data);
    }
}