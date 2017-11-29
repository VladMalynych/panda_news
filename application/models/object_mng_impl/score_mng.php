<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 27.11.2017
 * Time: 10:35
 */

require_once('application/models/object_mng_virtual/score_mng_interface.php');

class score_mng implements score_mng_interface
{
    public function create_score(score &$score){
        if ( $this->find_score_by_article_user_id($score->getArticleId(), $score->getUserId()) == null) {
            $new_score = R::xdispense('score');
            $new_score->user_id = $score->getUserId();
            $new_score->article_id = $score->getArticleId();
            $new_score->points = $score->getPoints();
            $score_id_ret_val = R::store($new_score);
            return $this->find_score_by_id($score_id_ret_val);
        }
        return null;
    }

    private function update_score_impl(int $score_id, score &$score){
        $temp_score = R::load('score', $score_id);
        $temp_score->points = $score->getPoints();
        $score_id_ret_val = R::store($temp_score);
        return $this->find_score_by_id($score_id_ret_val);
    }

    public function update_score(score &$score){
        if ( $score->getId() == NULL ){
            $update_score = $this->find_score_by_article_user_id($score->getArticleId(), $score->getUserId());
            if ( $update_score == null){
                return null;
            }
        } else {
            $update_score = $this->find_score_by_id($score->getId());
            if ( $update_score == null){
                return null;
            }
        }
        return $this->update_score_impl($update_score->getId(), $score);
    }

    public function delete_score_by_id(int $score_id){
        R::trash('score', $score_id);
        return true;
    }

    public function delete_score_by_article_user_id(int $article_id, int $user_id){
        $score = $this->find_score_by_article_user_id($article_id, $user_id);
        if ($score == null) {
            return false;
        }
        return $this->delete_score_by_id($score->getId());
    }

    public function delete_score(score &$score){
        if ($score->getId() == null){
            return $this->delete_score_by_article_user_id($score->getArticleId(), $score->getUserId());
        }
        return $this->delete_score_by_id($score->getId());
    }

    public function find_score_by_id(int $score_id){
        $bean_score = R::findOne('score', "`id` = ?", [$score_id]);
        if( $bean_score == null)
            return null;
        return $this->map_bean($bean_score);
    }

    public function find_scores_by_user_id(int $user_id){
        $bean_scores = R::findLike('score', [ 'user_id' => $user_id ]);
        if ($bean_scores == null)
            return null;
        $scores_array = array();
        foreach ($bean_scores as &$bean_score) {
            array_push($scores_array,$this->map_bean($bean_score));
        }
        return $scores_array;
    }

    public function find_scores_by_article_id(int $article_id){
        $bean_scores = R::findLike('score', [ 'article_id' => $article_id ]);
        if ($bean_scores == null)
            return null;
        $scores_array = array();
        foreach ($bean_scores as &$bean_score) {
            array_push($scores_array,$this->map_bean($bean_score));
        }
        return $scores_array;
    }

    public function find_score_by_article_user_id(int $article_id, int $user_id){
        $bean_scores = R::findLike('score',
            [
                'user_id' => $user_id,
                'article_id' => $article_id
            ]
        );
        if ($bean_scores == null) { return null; }
        if (count($bean_scores) > 1){
            throw new ErrorException('Multiple scores for article from one user', 1, E_WARNING);
        }
        $bean_score = array_shift($bean_scores);
        return $this->map_bean($bean_score);
    }

    public function find_all_scores(){
        $bean_scores = R::findAll('score', 'GROUP BY `article_id`');
        if ($bean_scores == null)
            return null;
        $score_array = array();
        foreach ($bean_scores as &$bean_score) {
            array_push($score_array, $this->map_bean($bean_score));
        }
        return $score_array;
    }

    private function map_bean(RedBeanPHP\OODBBean $bean){
        if ($bean == null){
            throw new ErrorException('Bean does not exist', 1, E_WARNING);
        }
        $bean->export();
        return new score( $bean['user_id'], $bean['article_id'], $bean['points'], $bean['id'] );
    }
}