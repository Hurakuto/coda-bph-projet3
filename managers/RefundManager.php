<?php

class RefundManager extends AbstractManager{

    public function __construct(){
        parent::__construct();
    }

    public function create(Refund $refund) : void {
            $query = $this->db->prepare("INSERT INTO refunds(payer_id, receiver_id, amount_100) VALUES(:payer_id, :reveicer_id, :amount)");
            $parameters = 
            [
                "payer_id" => $refund->getPayer(),
                "receiver_id" => $refund->getReceiver(),
                "amount_100" => $refund->getAmount()
            ];

            $query->execute($parameters);
        }

        public function update(Refund $refund) : void {
            $query = $this->db->prepare("UPDATE refunds SET amount_100=:amount_100, payer_id=:payer_id, receiver_id=:receiver_id WHERE id=:id");
            $parameters = 
            [
                "id" => $refund->getId(),
                "payer_id" => $refund->getPayer(),
                "receiver_id" => $refund->getReceiver(),
                "amount_100" => $refund->getAmount()
            ];

            $query->execute($parameters);
        }

        public function delete(Refund $refund) : void {
            $query = $this->db->prepare("DELETE FROM refunds WHERE id=:id");
            $parameters = 
            [
                "id" => $refund->getId()
            ];

            $query->execute($parameters);  
        }

        public function findOne($id) : Refund {
            $query = $this->db->prepare("SELECT * FROM refunds WHERE id=:id");
            $parameters = 
            [
                "id" => $id
            ];

            $query->execute($parameters);
            $expense = $query->fetch(PDO::FETCH_ASSOC);

            return  new Refund($refund['payer_id'], $refund['receiver_id'], $refund['amount_100'], $refund['id']);
        }

        public function findAll() : array {
            $query = $this->db->prepare("SELECT * FROM refunds");

            $query->execute();
            $refunds = $query->fetchAll(PDO::FETCH_ASSOC);

            $all_refunds = [];

            foreach($refunds as $refund){
                $all_refunds[] = new Refund($refund['payer_id'], $refund['receiver_id'], $refund['amount_100'], $refund['id']);
            }

            return $all_refunds;
        }
}