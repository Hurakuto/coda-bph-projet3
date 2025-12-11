<?php

    class UserManager extends AbstractManager{

        public function __construct(){
            parent::__construct();
        }

        public function create(User $user) : void {
            $query = $this->db->prepare("INSERT INTO users(firstName, lastName, email, password, role, total_100) VALUES(:firstName, :lastName, :email, :password, :role, :total)");
            $parameters = 
            [
                "firstName" => $user->getFirstName(),
                "lastName" => $user->getLastName(),
                "email" => $user->getEmail(),
                "password" => password_hash($user->getPassword(), PASSWORD_BCRYPT),
                "role" => $user->getRole(),
                "total" => $user->getTotal()
            ];

            $query->execute($parameters);
        }

        public function update(User $user) : void {
            $query = $this->db->prepare("UPDATE users SET firstName=:firstName, lastName=:lastName, email=:email, password=:password, role=:role, total_100=:total WHERE id=:id");
            $parameters = 
            [
                "id" => $user->getId(),
                "firstName" => $user->getFirstName(),
                "lastName" => $user->getLastName(),
                "email" => $user->getEmail(),
                "password" => $user->getPassword(),
                "role" => $user->getRole(),
                "total" => $user->getTotal()
            ];

            $query->execute($parameters);
        }

        public function delete(User $user) : void {
            $query = $this->db->prepare("DELETE FROM users WHERE id=:id");
            $parameters = 
            [
                "id" => $user->getId()
            ];

            $query->execute($parameters);  
        }

        public function findOne($id) : User {
            $query = $this->db->prepare("SELECT * FROM users WHERE id=:id");
            $parameters = 
            [
                "id" => $id
            ];

            $query->execute($parameters);
            $user = $query->fetch(PDO::FETCH_ASSOC);

            return  new User($user['firstName'], $user['lastName'], $user['email'], $user['password'], $user['role'], $user['total_100'], $user['id']);
        }

        public function findByEmail(string $email) : ? User
        {
            $query = $this->db->prepare('SELECT * FROM users WHERE email = :email');
            $parameters = [
                "email" => $email
            ];
            $query->execute($parameters);
            $item = $query->fetch(PDO::FETCH_ASSOC);

            if($item)
            {
                return new User($item["firstName"], $item["lastName"], $item["email"], $item["password"], $item["role"], $item['total_100'], $item["id"]);
            }

            return null;
        }

        public function findAll() : array {
            $query = $this->db->prepare("SELECT * FROM users");

            $query->execute();
            $users = $query->fetchAll(PDO::FETCH_ASSOC);

            $all_users = [];

            foreach($users as $user){
                $all_users[] = new User($user['firstName'], $user['lastName'], $user['email'], $user['password'], $user['role'], $user['total_100'], $user['id']);
            }

            return $all_users;
        }
    }