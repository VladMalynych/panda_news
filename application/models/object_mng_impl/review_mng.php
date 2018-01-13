<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 31.12.2017
 * Time: 12:15
 */

require_once ('application/models/object_mng_virtual/review_mng_interface.php');
require_once('application/models/objects/review.php');
require_once('application/models/objects/status.php');

class review_mng implements review_mng_interface
{
    public function create_review(review &$review){
        if ( $this->find_review_by_user_id_and_article_id($review->getUserId(), $review->getArticleId()) == null) {
            $new_review = R::xdispense('review');
            $new_review->user_id = $review->getUserId();
            $new_review->article_id = $review->getArticleId();
            $new_review->status = $review->getStatus();
            $review_id_ret_val = R::store($new_review);
            return $this->find_review_by_id($review_id_ret_val);
        }
        return null;
    }

    private function update_review_impl(review &$review){
        $temp_review = R::load('review', $review->getId());
        $temp_review->user_id = $review->getUserId();
        $temp_review->article_id = $review->getArticleId();
        $temp_review->status = $review->getStatus();
        $review_id_ret_val = R::store($temp_review);
        return $this->find_review_by_id($review_id_ret_val);
    }

    public function update_review(review &$review){
        if ( $review->getId() == null ){
            $update_review = $this->find_review_by_user_id_and_article_id($review->getUserId(), $review->getArticleId());
        } else {
            $update_review = $this->find_review_by_id($review->getId());
        }

        if ( $update_review == null){
            return null;
        }
        return $this->update_review_impl($review);
    }

    public function delete_review(int $review_id){
        if ( $this->find_review_by_id($review_id) == null){
            return false;
        }
        R::trash('review', $review_id);
        return true;
    }

    public function find_review_by_id(int $review_id){
        $bean_review = R::findOne('review', "`id` = ?", [$review_id]);
        if( $bean_review == null)
            return null;
        return $this->map_bean($bean_review);
    }

    public function find_review_by_user_id_and_article_id(int $user_id, int $article_id){
        $bean_review = R::findLike('review',
            [
                'user_id' => $user_id,
                'article_id' => $article_id
            ]);
        if ($bean_review == null)
            return null;
        return $this->map_bean(array_pop($bean_review));
    }

    public function find_reviews_by_user_id(int $user_id){
        $bean_reviews = R::findLike('review', [ 'user_id' => $user_id ]);
        if ($bean_reviews == null)
            return null;
        $reviews_array = array();
        foreach ($bean_reviews as &$bean_review) {
            array_push($reviews_array,$this->map_bean($bean_review));
        }
        return $reviews_array;
    }

    public function find_reviews_by_user_id_with_status(int $user_id, int $status){
        $bean_reviews = R::findLike('review',
            [
                'user_id' => $user_id,
                'status' => $status
            ]);
        if ($bean_reviews == null)
            return null;
        $reviews_array = array();
        foreach ($bean_reviews as &$bean_review) {
            array_push($reviews_array, $this->map_bean($bean_review));
        }
        return $reviews_array;
    }

    public function find_reviews_by_article_id(int $article_id){
        $bean_reviews = R::findLike('review', [ 'article_id' => $article_id ]);
        if ($bean_reviews == null)
            return null;
        $reviews_array = array();
        foreach ($bean_reviews as &$bean_review) {
            array_push($reviews_array, $this->map_bean($bean_review));
        }
        return $reviews_array;
    }

    public function find_reviews_by_article_id_with_status(int $article_id, int $status){
        $bean_reviews = R::findLike('review',
            [
                'article_id' => $article_id,
                'status' => $status
            ]);
        if ($bean_reviews == null)
            return null;
        $reviews_array = array();
        foreach ($bean_reviews as &$bean_review) {
            array_push($reviews_array, $this->map_bean($bean_review));
        }
        return $reviews_array;
    }

    public function find_reviews_with_status(int $status){
        $bean_reviews = R::findLike('review', [ 'status' => $status ]);
        if ($bean_reviews == null)
            return null;
        $reviews_array = array();
        foreach ($bean_reviews as &$bean_review) {
            array_push($reviews_array,$this->map_bean($bean_review));
        }
        return $reviews_array;
    }

    public function find_all_reviews(){
        $bean_reviews = R::findAll('review', 'GROUP BY `article_id`');
        if ($bean_reviews == null)
            return null;
        $reviews_array = array();
        foreach ($bean_reviews as &$bean_review) {
            array_push($reviews_array, $this->map_bean($bean_review));
        }
        return $reviews_array;
    }

    private function map_bean(RedBeanPHP\OODBBean $bean){
        if ($bean == null) {
            throw new ErrorException('Bean does not exist', 1, E_WARNING);
        }
        $bean->export();
        return new review($bean['user_id'], $bean['article_id'], $bean['status'], $bean['id']);
    }
}