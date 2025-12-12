<?php

class UserController extends AbstractController{

    public function home() : void
    {
        if(isset($_SESSION['id'])){
            $user_m = new UserManager();
            $user = $user_m->findOne($_SESSION['id']);
        
            $this->render(
                "_home", 
                [
                    "id" => $user->getId(),
                    "firstName" => $user->getFirstName(),
                    "lastName" => $user->getLastName(),
                    "email" => $user->getEmail(),
                    "role" => $user->getRole(),
                    "total" => $user->getTotal()/100
                ]
            );
        }
        else{
            $this->redirect('index.php');
        }
    }

    public function ajouter(){

        if(isset($_SESSION['id'])){
            $user_m = new UserManager();
            $user = $user_m->findOne($_SESSION['id']);

            $this->render(
                "money/_ajouter", 
                [
                    "firstName" => $user->getFirstName(),
                    "total" => $user->getTotal()/100 
                ]
            );

            if(!empty($_POST['montant'])&&isset($_POST['montant'])){
                $montant = 100 * $_POST['montant'];
                $montant = (int) $montant;
                if (gettype($montant) === "integer"){
                    $total = $user->getTotal()+$montant;
                    $user->setTotal($total);

                    $user_m->update($user);

                    $user_c = new UserController();

                    $user_c->redirect("./index.php?route=home");
                }
            }
        }
        else{
            $this->redirect('./index.php');
        }
    }

    public function depenser(){

        if(isset($_SESSION['id'])){

            $category_m = new CategoryManager();
            $categories = $category_m->findAll();

            $user_m = new UserManager();
            $user = $user_m->findOne($_SESSION['id']);

            $all_categories = [];

            foreach($categories as $category){
                $all_categories[] = 
                [
                    "id" => $category->getId(),
                    "name" => $category->getName()
                ];
            }

            $this->render("money/_depenser", 
                [
                    "categories" => $all_categories,
                    "total" => $user->getTotal()/100 
                ]
            );

            if(!empty($_POST['montant'])&&isset($_POST['montant'])&&!empty($_POST['category'])&&isset($_POST['category'])){
                $montant = 100 * $_POST['montant'];
                $montant = (int) $montant;
                if (gettype($montant) === "integer"){

                    $total = $user->getTotal() - $montant;
                    $user->setTotal($total);
                    $user_m->update($user);

                    $id_category = NULL;

                    foreach($categories as $category){
                        if($category->getName()===$_POST['category']){
                            $id_category = $category->getId();
                        }
                    }

                    $expense_m = new ExpenseManager();

                    $expense_m->create(new Expense($montant, $_SESSION['id'], $id_category));

                    $user_c = new UserController();

                    $user_c->redirect("./index.php?route=home");
                }
            }
        }
        else{
            $this->redirect("./index.php");
        }    }

    public function rembourser(){

        if(isset($_SESSION['id'])){

            $user_m = new UserManager();
            $user = $user_m->findOne($_SESSION['id']);

            $category_m = new CategoryManager();

            $refund_m = new RefundManager();
            $refunds = $refund_m->findAll();

            $all_refunds = [];

            foreach($refunds as $refund){
                if($refund->getPayer()===$_SESSION['id']){
                    $all_refunds[] = 
                    [
                        "id" => $refund->getId(),
                        "receiver_firstname" => $user_m->findOne($refund->getReceiver())->getFirstName(),
                        "receiver_lastname" => $user_m->findOne($refund->getReceiver())->getLastName(),
                        "amount" => $refund->getAmout()/100
                    ];
                }
            }


            $this->render(
                "money/_rembourser", 
                [
                    "payer_firstname" => $user_m->findOne($_SESSION['id'])->getFirstName(),
                    "payer_lastname" => $user_m->findOne($_SESSION['id'])->getLastName(),
                    "total" => $user->getTotal()/100,
                    "refunds" => $all_refunds
                ]
            );

            if(!empty($_POST['id'])&&isset($_POST['id'])){
                $refund_id = $_POST['id'];
                $refund = $refund_m->findOne($refund_id);
                $amount = $refund->getAmount();

                $payer = $user_m->findOne($refund->getPayer());
                $receiver = $user_m->findOne($refund->getReceiver());

                $payer->setAmount($payer->getAmount() - $amount);
                $receiver->setAmount($receiver->getAmount() + $amount);

                $user_m->update($payer);
                $user_m->update($receiver);

                $refund_m->delete($refund);

                $this->redirect("./index.php?route=home");
            }
        }
        else{
            $this->redirect("./index.php");
        }

    }
}