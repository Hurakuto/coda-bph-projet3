<?php

class Refund{

    public function __construct(private int $payer_id, private int $reveiver_id, private float $amout, private ?int $id=NULL){}

    public function getPayer(){
        return $this->payer_id;
    }

    public function setPayer($id){
        $this->payer_id = $id;
    }

    public function getReveiver(){
        return $this->reveiver_id;
    }

    public function setReceiver($id){
        $this->receiver_id = $id;
    }

    public function getAmout(){
        return $this->amout;
    }

    public function setAmout($amout){
        $this->amout = $amout;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }
}