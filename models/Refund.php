<?php

class Refund{

    private array $payers = [];

    public function __construct(private int $payer_id, private int $receiver_id, private int $amount_100, private ?int $id=NULL){}

    public function getPayer(){
        return $this->payer_id;
    }

    public function setPayer($id){
        $this->payer_id = $id;
    }

    public function getReceiver(){
        return $this->receiver_id;
    }

    public function setReceiver($id){
        $this->receiver_id = $id;
    }

    public function getAmount(){
        return $this->amount_100;
    }

    public function setAmount($amount_100){
        $this->amount_100 = $amount_100;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }
}