<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 31.12.2017
 * Time: 11:40
 */

class review
{
    private $user_id;
    private $article_id;
    private $status=null;
    private $id = NULL; // private key

    public function __construct(int $user_id, int $article_id, int $status=status::None, int $id=NULL){
        $this->user_id = $user_id;
        $this->article_id = $article_id;
        $this->status = $status;
        $this->id = $id;
    }

    public function getUserId(){ return $this->user_id; }
    public function setUserId(int $user_id){ $this->user_id = $user_id; }

    public function getArticleId(){ return $this->article_id; }
    public function setArticleId(int $article_id){ $this->article_id = $article_id; }

    public function getStatus(){ return $this->status; }
    public function setStatus(int $status){ $this->status = $status; }

    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }
}