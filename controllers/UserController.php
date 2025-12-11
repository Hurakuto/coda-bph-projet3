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
            $this->redirect('index.php');
        }
    }
}