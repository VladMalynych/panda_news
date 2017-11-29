<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 26.11.2017
 * Time: 15:04
 */

class score
{
    private $user_id;
    private $article_id;
    private $points;
    private $id = NULL; // private key

    public function __construct(int $user_id, int $article_id, int $points, int $id=NULL){
        $this->user_id = $user_id;
        $this->article_id = $article_id;
        $this->points = $points;
        $this->id = $id;
    }

    public function getUserId(){ return $this->user_id; }
    public function setUserId(int $user_id){ $this->user_id = $user_id; }

    public function getArticleId(){ return $this->article_id; }
    public function setArticleId(int $article_id){ $this->article_id = $article_id; }

    public function getPoints(){ return $this->points; }
    public function setPoints(int $points){ $this->points = $points; }

    public function getId(){ return $this->id; }
    public function setId(int $id){ $this->id = $id; }
}