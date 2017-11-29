<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 24.11.2017
 * Time: 16:17
 */

class comment
{
    private $article_id;
    private $user_id;
    private $content;
    private $points = 0;
    private $post_time;
    private $id; //private_key

    public function __construct(int $article_id, int $user_id, string $content,
                                int $points, DateTime $post_time=NULL, int $id=NULL){
        $this->article_id = $article_id;
        $this->user_id = $user_id;
        $this->content = $content;
        $this->points = $points;
        if ($post_time == NULL){
            $this->post_time = new DateTime('now', new DateTimeZone('Europe/London'));
        } else{
            $this->post_time = $post_time;
        }
        $this->id = $id;
    }

    public function getArticleId(){ return $this->article_id; }
    public function setArticleId(int $article_id){ $this->article_id = $article_id; }

    public function getUserId(){ return $this->user_id; }
    public function setUserId(int $user_id){ $this->user_id = $user_id; }

    public function getContent(){ return $this->content; }
    public function setContent(string $content){ $this->content = $content; }

    public function getPoints(){ return $this->points; }
    public function setPoints(int $points){ $this->points = $points; }

    public function getPostTime(){ return $this->post_time; }
    public function setPostTime(DateTime $post_time){ $this->post_time = $post_time; }

    public function getId(){ return $this->id; }
    public function setId(int $id){ $this->id = $id; }
}