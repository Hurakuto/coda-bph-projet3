<?php

class AuthController extends AbstractController
{

    public function register(){
        $this->render("_register", []);

        $user_m = new UserManager();

        if(!empty($_POST)){
            if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm-password']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm-password'])){
                if($_POST['password'] === $_POST['confirm-password']){
                    if($user_m->findByEmail($_POST['email'])===NULL)
                    {
                        $user_m->create(new User(htmlspecialchars($_POST['prenom']), htmlspecialchars($_POST['nom']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password'])));
                        $this->redirect('./index.php');
                    }
                    else
                    {
                        $msg = "veuillez taper deux fois le même mot de passe !";
                    }
                }
                else
                {
                    $msg = "cette adresse mail est déjà lié à un compte !";
                }
            }
        }
    }

    public function login(){

        $this->render("_login", []);

        $user_m = new UserManager();
        $users = $user_m->findAll();

        if(!empty($_POST)){
            if( isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password']) ){
                foreach($users as $user){
                    if($user->getEmail()===$_POST['email']){
                        if(password_verify($_POST['password'], $user->getPassword())){
                            $_SESSION["role"] = $user->getRole();
                            $_SESSION['id'] = $user->getId();

                            $this->redirect("./index.php?route=home");
                        }
                        else{
                            echo "Mot de passe incorrect !";
                        }
                    }
                    else{
                        echo "Email incorrect !";
                    }
                }
            }
        }
    }

    public function notFound(){
        $this->render('_notFound', []);
    }
}