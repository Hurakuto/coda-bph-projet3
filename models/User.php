<?php

class User
{
    public function __construct(private string $firstName, private string $lastName, private string $email, private string $password, private string $role = 'USER', private int $total = 0, private ?int $id = NULL)
    {
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($name)
    {
        $this->firstName = $name;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($name)
    {
        $this->lastName = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}