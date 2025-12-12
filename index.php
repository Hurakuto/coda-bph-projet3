<?php

        session_start();

        require_once 'vendor/autoload.php';

        // Chargement des variables d'environnement
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();


        $category_m = new CategoryManager();
        $categories = $category_m->findAll();

        $transport = 0;
        $logement = 0;
        $nourriture = 0;
        $sorties = 0;


        foreach($categories as $category){
                if($category->getName()==="Transport"){
                        $transport=1;
                }
                elseif($category->getName()==="Logement"){
                        $logement=1;
                }
                elseif($category->getName()==="Nourriture"){
                        $nourriture=1;
                }
                elseif($category->getName()==="Sorties"){
                        $sorties=1;
                }
        }

        if($transport===0){
                $category_m->create(new Category("Transport"));
        }
        if($logement===0){
                $category_m->create(new Category("Logement"));
        }
        if($nourriture===0){
                $category_m->create(new Category("Nourriture"));
        }
        if($sorties===0){
                $category_m->create(new Category("Sorties"));
        }


        $route = new Router();
        $route->handleRequest($_GET);


//Transport

// Logement

// Nourriture

// Sorties