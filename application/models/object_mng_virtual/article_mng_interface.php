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
    public function find_articles_by_status(int $approved);
    public function find_n_articles_by_status(int $approved, int $n, int $from);
    public function find_articles_by_user_id_and_status(int $user_id, int $approved);
    public function find_all_articles();
    public function find_n_articles(int $n, int $from);
}