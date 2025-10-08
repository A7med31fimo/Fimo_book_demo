<?php
class User{
    private $name;
    private $email;
    private $password;
    private $created_at;
    
    public function __construct($name, $email, $password, $created_at){
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = $created_at;
    }
    public function getName(){
        return $this->name;
    }
    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }
    public function getCreatedAt(){
        return $this->created_at;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function setCreatedAt($created_at){
        $this->created_at = $created_at;
    }
}


?>