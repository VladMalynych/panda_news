<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 24.11.2017
 * Time: 16:16
 */

class user
{
    private $name;
    private $surname;
    private $email;
    private $username;
    private $password;
    private $phone = NULL;
    private $id = NULL; // private_key

    public function __construct(string $name, string $surname, string $email,
                                string $username, string $password, string $phone=NULL, int $id=NULL){
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->phone = $phone;
        $this->id = $id;
    }

    public function getName(){ return $this->name; }
    public function setName(string $name){ $this->name = $name; }

    public function getSurname(){ return $this->surname; }
    public function setSurname(string $surname) { $this->surname = $surname; }

    public function getEmail(){ return $this->email; }
    public function setEmail(string $email){ $this->email = $email; }

    public function getPassword(){ return $this->password; }
    public function setPassword(string $password){ $this->password = $password; }

    public function getUsername(){ return $this->username; }
    public function setUsername(string $username) { $this->username = $username; }

    public function getPhone(){ return $this->phone; }
    public function setPhone(string $phone){ $this->phone = $phone; }

    public function getId(){ return $this->id; }
    public function setId(int $id){ $this->id = $id; }
}