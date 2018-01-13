<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 31.12.2017
 * Time: 11:49
 */

interface review_mng_interface
{
    // Create
    public function create_review(review &$review);
    // Update
    public function update_review(review &$review);
    // Delete
    public function delete_review(int $review_id);
    // Read
    public function find_review_by_id(int $review_id);
    public function find_review_by_user_id_and_article_id(int $user_id, int $article_id);
    public function find_reviews_by_user_id(int $user_id);
    public function find_reviews_by_user_id_with_status(int $user_id, int $status);
    public function find_reviews_by_article_id(int $article_id);
    public function find_reviews_by_article_id_with_status(int $article_id, int $status);
    public function find_all_reviews();
    public function find_reviews_with_status(int $status);
}