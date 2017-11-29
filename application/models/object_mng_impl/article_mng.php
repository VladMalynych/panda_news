<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 24.11.2017
 * Time: 16:58
 */

require_once('application/models/object_mng_virtual/article_mng_interface.php');

class article_mng implements article_mng_interface
{
    public function create_article(article &$article){
        $new_article = R::xdispense('article');
        $new_article->user_id = $article->getUserId();
        $new_article->name = $article->getName();
        $new_article->content = $article->getContent();
        $new_article->status = $article->getStatus();
        $new_article->post_time = $article->getPostTime();
        $article_id_ret_val = R::store($new_article);
        return $this->find_article_by_id($article_id_ret_val);
    }

    private function update_article_impl(article &$article){
        $temp_article = R::load('article', $article->getId());
        $temp_article->name = $article->getName();
        $temp_article->content = $article->getContent();
        $temp_article->status = $article->getStatus();
        $article_id_ret_val = R::store($temp_article);
        return $this->find_article_by_id($article_id_ret_val);
    }

    public function update_article(article &$article){
        if ( $this->find_article_by_id($article->getId()) == null){
            return null;
        }
        return $this->update_article_impl($article);
    }

    public function delete_article(int $article_id){
        if ( $this->find_article_by_id($article_id) == null){
            return false;
        }
        R::trash('article', $article_id);
        return true;
    }

    public function find_article_by_id(int $article_id){
        $bean_article = R::findOne('article', "`id` = ?", [$article_id]);
        if( $bean_article == null)
            return null;
        return $this->map_bean($bean_article);
    }

    public function find_articles_by_user_id(int $user_id){
        $bean_articles = R::findLike('article',
            [
                'user_id' => $user_id
            ],
            'ORDER BY `post_time` DESC' );
        if ($bean_articles == null)
            return null;
        $articles_array = array();
        foreach ($bean_articles as &$bean_article) {
            array_push($articles_array, $this->map_bean($bean_article));
        }
        return $articles_array;
    }

    public function find_articles_by_name(string $article_name){
        $bean_articles = R::findLike('article',
            [
                'name' => $article_name
            ],
            'ORDER BY `post_time` DESC' );
        if ($bean_articles == null)
            return null;
        $articles_array = array();
        foreach ($bean_articles as &$bean_article) {
            array_push($articles_array, $this->map_bean($bean_article));
        }
        return $articles_array;
    }

    public function find_articles_by_status(bool $approved){
        $bean_articles = R::findLike('article',
            [
                'status' => $approved
            ],
            'ORDER BY `post_time` DESC' );
        if ($bean_articles == null)
            return null;
        $articles_array = array();
        foreach ($bean_articles as &$bean_article) {
            array_push($articles_array, $this->map_bean($bean_article));
        }
        return $articles_array;
    }

    public function find_articles_by_user_id_and_status(int $user_id, bool $approved){
        $bean_articles = R::findLike('article',
            [
                'user_id' => $user_id,
                'status' => $approved
            ],
            'ORDER BY `post_time` DESC' );
        if ($bean_articles == null)
            return null;
        $articles_array = array();
        foreach ($bean_articles as &$bean_article) {
            array_push($articles_array, $this->map_bean($bean_article));
        }
        return $articles_array;
    }

    public function find_all_articles(){
        $bean_articles = R::findAll('article', 'ORDER BY `post_time` DESC');
        if ($bean_articles == null)
            return null;
        $article_array = array();
        foreach ($bean_articles as &$bean_article) {
            array_push($article_array, $this->map_bean($bean_article));
        }
        return $article_array;
    }

    private function map_bean(RedBeanPHP\OODBBean $bean){
        if ($bean == null){
            throw new ErrorException('Bean does not exist', 1, E_WARNING);
        }
        $bean->export();
        return new article( $bean['user_id'], $bean['name'], $bean['content'], $bean['status'],
            date_create_from_format('Y-m-d H:i:s', $bean['post_time']), $bean['id'] );
    }
}