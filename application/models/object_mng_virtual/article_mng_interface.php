<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 24.11.2017
 * Time: 16:09
 */

interface article_mng_interface
{
    // Create
    public function create_article(article &$article);
    // Update
    public function update_article(article &$article);
    // Delete
    public function delete_article(int $article_id);
    // Read
    public function find_article_by_id(int $article_id);
    public function find_articles_by_name(string $article_name);
    public function find_articles_by_user_id(int $user_id);
    public function find_articles_by_status(bool $approved);
    public function find_articles_by_user_id_and_status(int $user_id, bool $approved);
    public function find_all_articles();
}