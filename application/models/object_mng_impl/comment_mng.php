<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 24.11.2017
 * Time: 16:59
 */

require_once ('application/models/object_mng_virtual/comment_mng_interface.php');
require_once('application/models/objects/comment.php');

class comment_mng implements comment_mng_interface
{

    public function create_comment(comment &$comment){
        $new_comment = R::xdispense('comment');
        $new_comment->article_id = $comment->getArticleId();
        $new_comment->user_id = $comment->getUserId();
        $new_comment->content = $comment->getContent();
        $new_comment->points = $comment->getPoints();
        $new_comment->post_time = $comment->getPostTime();
        $comment_id_ret_val = R::store($new_comment);
        return $this->find_comment_by_id($comment_id_ret_val);
    }

    private function update_comment_impl(comment &$comment){
        $temp_comment = R::load('comment', $comment->getId());
        $temp_comment->content = $comment->getContent();
        $temp_comment->points = $comment->getPoints();
        $comment_id_ret_val = R::store($temp_comment);
        return $this->find_comment_by_id($comment_id_ret_val);
    }

    public function update_comment(comment &$comment){
        if ( $this->find_comment_by_id($comment->getId()) == null){
            return null;
        }
        return $this->update_comment_impl($comment);
    }

    public function delete_comment(int $comment_id){
        if ( $this->find_comment_by_id($comment_id) == null){
            return false;
        }
        R::trash('comment', $comment_id);
        return true;
    }

    public function find_comment_by_id(int $comment_id){
        $bean_comment = R::findOne('comment', "`id` = ?", [$comment_id]);
        if( $bean_comment == null)
            return null;
        return $this->map_bean($bean_comment);
    }

    public function find_comments_by_user_id(int $user_id){
        $bean_comments = R::findLike('comment',
            [
                'user_id' => $user_id
            ],
            'ORDER BY `post_time` ASC');
        if ($bean_comments == null)
            return null;
        $comments_array = array();
        foreach ($bean_comments as &$bean_comment) {
            array_push($comments_array,$this->map_bean($bean_comment));
        }
        return $comments_array;
    }

    public function find_comments_by_article_id(int $article_id){
        $bean_comments = R::findLike('comment',
            [
                'article_id' => $article_id
            ],
            'ORDER BY `post_time` ASC');
        if ($bean_comments == null)
            return null;
        $comments_array = array();
        foreach ($bean_comments as &$bean_comment) {
            array_push($comments_array,$this->map_bean($bean_comment));
        }
        return $comments_array;
    }

    public function find_comments_by_article_id_for_user_id(int $article_id, int $user_id){
        $bean_comments = R::findLike('comment',
            [
                'article_id' => $article_id,
                'user_id' => $user_id
            ],
            'ORDER BY `post_time` ASC');
        if ($bean_comments == null)
            return null;
        $comments_array = array();
        foreach ($bean_comments as &$bean_comment) {
            array_push($comments_array, $this->map_bean($bean_comment));
        }
        return $comments_array;
    }

    public function find_comments_by_article_id_after_date(int $article_id, DateTime $date){
        $bean_comments = R::find('comment',
            '`article_id` = ? AND `post_time` > ? ORDER BY `post_time` ASC',
            [$article_id, $date]
        );
        if ($bean_comments == null)
            return null;
        $comments_array = array();
        foreach ($bean_comments as &$bean_comment) {
            array_push($comments_array, $this->map_bean($bean_comment));
        }
        return $comments_array;
    }

    public function find_all_comments(){
        $bean_comments = R::findAll('comment', 'ORDER BY `post_time` ASC');
        if ($bean_comments == null)
            return null;
        $comment_array = array();
        foreach ($bean_comments as &$bean_comment) {
            array_push($comment_array, $this->map_bean($bean_comment));
        }
        return $comment_array;
    }

    private function map_bean(RedBeanPHP\OODBBean $bean){
        if ($bean == null){
            throw new ErrorException('Bean does not exist', 1, E_WARNING);
        }
        $bean->export();
        return new comment( $bean['article_id'], $bean['user_id'], $bean['content'], $bean['points'],
                            date_create_from_format('Y-m-d H:i:s', $bean['post_time']), $bean['id'] );
    }
}