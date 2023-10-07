<?php

namespace Source\Models;

use Source\Core\Connect;
use PDO;
use PDOException;

class User {
    private $id_user;
    private $cpf;
    private $name;
    private $email;
    private $number;
    private $id_house;

    public function __construct (
        $cpf = null,
        $name = null,
        $email = null,
        $number = null,
        $id_house = null
    
    ){
        $this->cpf = $cpf;
        $this->name = $name;
        $this->email = $email;
        $this->number = $number;
        $this->id_house = $id_house;

    }
    
    public function insert () : bool
    {
        if($this->findByEmail($this->email)){
            $this->message = "E-mail já cadastrado!";
            return false;
        }
        $query = "INSERT INTO users VALUES (:cpf, :name, :email, :number, :id_house)";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":cpf", $this->cpf);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":number", $this->number);
        $stmt->bindParam(":id_house", $this->id_house);
        try {
            $stmt->execute();
            if($stmt->rowCount()){
                $this->message = "Usuário inserido com sucesso!";
                return true;
            }
            $this->message = "Erro ao inserir usuário, verifique os dados!";
            return false;
        } catch (PDOException $e) {
            $this->message = "Erro: {$e->getMessage()}";
            return false;
        }
    }
    
    public function selectAllUsers()
    {
        $query = "SELECT * FROM users;";
        $stmt = Connect::getInstance()->query($query);
        return $stmt->fetchAll();
    }

    public function selectUsersHouse()
    {
        $query= "SELECT * FROM users_houses 
        JOIN users ON users.id_user = users_addresses.id_users
        JOIN address ON address.id_house = users_houses.id_houses;"
        $stmt = Connect::getInstance()->query($query);
        return $stmt->fetchAll();
    }

    public function getId()
    {
    return $this->id;
    }

    public function setId($id_user): void
    {
        $this->id = $id_user;
    }
    
    public function getCpf()
    {
        return $this->cpf;
    }
    
    public function setCpf($cpf): void
    {
        $this->cpf = $cpf;
    }
    
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name): void
    {
        $this->name = $name;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function setEmail($email): void
    {
        $this->email = $email;
    }
    
    public function getNumber()
    {
        return $this->number;
    }
    
    public function setNumber($number): void
    {
        $this->number = $number;
    }
    
    public function getIdHouse()
    {
        return $this->id_house;
    }
    
    public function setIdHouse($id_house): void
    {
        $this->id_$id_house = $id_house;
    }
    
    public function getMessage(): string
    {
        return $this->message;
    }
}
