<?php

    class CategoryManager extends AbstractManager{

        public function __construct(){
            parent::__construct();
        }

        public function create(Category $category) : void {
            $query = $this->db->prepare("INSERT INTO category(name) VALUES(:name)");
            $parameters = 
            [
                "name" => $category->getName()
            ];

            $query->execute($parameters);
        }

        public function update(Category $category) : void {
            $query = $this->db->prepare("UPDATE category SET name=:name WHERE id=:id");
            $parameters = 
            [
                "id" => $category->getId(),
                "name" => $category->getName()
            ];

            $query->execute($parameters);
        }

        public function delete(Category $category) : void {
            $query = $this->db->prepare("DELETE FROM category WHERE id=:id");
            $parameters = 
            [
                "id" => $category->getId()
            ];

            $query->execute($parameters);  
        }

        public function findOne($id) : Category {
            $query = $this->db->prepare("SELECT * FROM category WHERE id=:id");
            $parameters = 
            [
                "id" => $id
            ];

            $query->execute($parameters);
            $category = $query->fetch(PDO::FETCH_ASSOC);

            return  new Category($category['name']);
        }

        public function findAll() : array {
            $query = $this->db->prepare("SELECT * FROM category");

            $query->execute();
            $categories = $query->fetchAll(PDO::FETCH_ASSOC);

            $all_categories = [];

            foreach($categories as $category){
                $all_categories[] = new Category($category['name'], $category['id']);
            }

            return $all_categories;
        }
    }