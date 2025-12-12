<?php

class CategoryManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create(Category $category): void
    {
        $query = $this->db->prepare("INSERT INTO category(name) VALUES(:name)");
        $parameters = [
            "name" => $category->getName()
        ];

        $query->execute($parameters);
    }

    public function update(Category $category): void
    {
        $query = $this->db->prepare("UPDATE category SET name=:name WHERE id=:id");
        $parameters = [
            "id" => $category->getId(),
            "name" => $category->getName()
        ];

        $query->execute($parameters);
    }

    public function delete(Category $category): void
    {
        $query = $this->db->prepare("DELETE FROM category WHERE id=:id");
        $parameters = [
            "id" => $category->getId()
        ];

        $query->execute($parameters);
    }

    public function findOne($id): Category
    {
        $query = $this->db->prepare("SELECT * FROM category WHERE id=:id");
        $parameters = [
            "id" => $id
        ];

        $query->execute($parameters);
        $category = $query->fetch(PDO::FETCH_ASSOC);

        return new Category($category['name']);
    }

    public function findAll(): array
    {
        $query = $this->db->prepare("SELECT * FROM category");

        $query->execute();
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);

        $all_categories = [];

        foreach ($categories as $category) {
            $all_categories[] = new Category($category['name'], $category['id']);
        }

        return $all_categories;
    }

    public function checkAndCreateDefaultCategories(): void
    {
        $categories = $this->findAll();
        $transport = 0;
        $logement = 0;
        $nourriture = 0;
        $sorties = 0;

        foreach ($categories as $category) {
            if ($category->getName() === "Transport") {
                $transport = 1;
            } elseif ($category->getName() === "Logement") {
                $logement = 1;
            } elseif ($category->getName() === "Nourriture") {
                $nourriture = 1;
            } elseif ($category->getName() === "Sorties") {
                $sorties = 1;
            }
        }

        if ($transport === 0) {
            $this->create(new Category("Transport"));
        }
        if ($logement === 0) {
            $this->create(new Category("Logement"));
        }
        if ($nourriture === 0) {
            $this->create(new Category("Nourriture"));
        }
        if ($sorties === 0) {
            $this->create(new Category("Sorties"));
        }
    }
}