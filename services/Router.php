<?php 
    class Router
    {
        public function handleRequest(array $get) : void
        {
            $auth = new AuthController();
            $user = new UserController();

            if (isset($get["route"]))
            {
                if ($get["route"]==="home")
                {
                    $user->home();
                }
                elseif ($get['route']==="ajouter"){
                    $user->ajouter();
                }
                elseif ($get['route']==="depenser"){
                    $user->depenser();
                }
                elseif ($get['route']==="rembourser"){
                    $user->rembourser();
                }
                elseif ($get["route"]==="register")
                {
                    $auth->register();
                }
            }
            else
            {
                $auth->login();
            }
        }
    }