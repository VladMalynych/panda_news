<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 27.11.2017
 * Time: 10:36
 */

interface score_mng_interface
{
    // Create
    public function create_score(score &$score);
    // Update
    public function update_score(score &$score);
    // Delete
    public function delete_score(int $score_id);
    public function delete_score_by_article_user_id(int $article_id, int $user_id);
    // Read
    public function find_score_by_id(int $score_id);
    public function find_scores_by_user_id(int $user_id);
    public function find_scores_by_article_id(int $article_id);
    public function find_score_by_article_user_id(int $article_id, int $user_id);
    public function find_all_scores();
}