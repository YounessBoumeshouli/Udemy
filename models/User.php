<?php

abstract class user {
    protected $db;
    protected $id;
    protected $username;
    protected $email;
    protected $role;

    public function __construct($db, $userData = null) {
        $this->db = $db;
        if ($userData) {
            $this->id = $userData['id'];
            $this->username = $userData['username'];
            $this->email = $userData['email'];
        }
    }
    public function create($data){
        echo "<pre>";
        var_dump($data);
        var_dump($this->db);
        echo "</pre>";
        echo $this->status;
        $sql = "INSERT INTO public.users(
	     username, email, password, role, status)
	    VALUES (:username, :email, :password, :role,:status)";
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $data['role']);
        echo $password;
        try {
            $stmt->execute();
            echo "executed";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }   
    }
    public function read($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function update($id, $data) {
        $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function delete($id) {
        $sql = "DELETE FROM users WHERE id_user = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}