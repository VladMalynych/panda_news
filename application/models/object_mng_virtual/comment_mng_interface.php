<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 24.11.2017
 * Time: 16:10
 */

interface comment_mng_interface
{
    // Create
    public function create_comment(comment &$comment);
    // Update
    public function update_comment(comment &$comment);
    // Delete
    public function delete_comment(int $comment_id);
    // Read
    public function find_comment_by_id(int $comment_id);
    public function find_comments_by_user_id(int $user_id);
    public function find_comments_by_article_id(int $article_id);
    public function find_comments_by_article_id_for_user_id(int $article_id, int $user_id);
    public function find_comments_by_article_id_after_date(int $article_id, DateTime $date);
    public function find_all_comments();
}