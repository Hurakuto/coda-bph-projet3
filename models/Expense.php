<?php

class Expense{

    public function __construct(private float $amout, private int $id_user, private int $id_category, private ?int $id=NULL){}

    public function getAmout(){
        return $this->amout;
    }

    public function setAmout($amout){
        $this->amout = $amout;
    }

    public function getUser(){
        return $this->id_user;
    }

    public function setUser($id){
        $this->id_user = $id;
    }

    public function getCategory(){
        return $this->id_category;
    }

    public function setCategory($id){
        $this->id_category = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }
}