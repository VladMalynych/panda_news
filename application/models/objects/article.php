<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 24.11.2017
 * Time: 16:16
 */

class article
{
    private $user_id;
    private $name;
    private $content;
    private $status = status::None;
    private $post_time;
    private $id; // private_key

    public function __construct(int $user_id, string $name, string $content,
                                int $status=status::None, DateTime $post_time=NULL, int $id=NULL){
        $this->user_id = $user_id;
        $this->name = $name;
        $this->content = $content;
        $this->status = $status;
        if ($post_time == NULL){
            $this->post_time = new DateTime('now', new DateTimeZone('Europe/Prague'));
        } else{
            $this->post_time = $post_time;
        }
        $this->id = $id;
    }


    public function getName(){ return $this->name; }
    public function setName(string $name){ $this->name = $name; }

    public function getUserId(){ return $this->user_id; }
    public function setUserId(int $user_id){ $this->user_id = $user_id; }

    public function getContent(){ return $this->content; }
    public function setContent(string $content){ $this->content = $content; }

    public function getStatus(){ return $this->status; }
    public function setStatus(int $status){ $this->status = $status; }

    public function getPostTime(){ return $this->post_time; }
    public function setPostTime(DateTime $post_time){ $this->post_time = $post_time;}

    public function getId(){ return $this->id; }
    public function setId(int $id){ $this->id = $id; }
}