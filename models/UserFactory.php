<?php
require_once 'Student.php';
require_once 'Teacher.php';
require_once 'Admin.php';

class UserFactory {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }


    public function createUser($role, $userData = null) {
        switch ($role) {
            case 'student':
                return new Student($this->db, $userData);
            case 'teacher':
                return new Teacher($this->db, $userData);
            case 'admin':
                return new Admin($this->db, $userData);
            default:
                throw new Exception("Invalid user role");
        }
    }
    public function getUser($id) {
        $sql = "SELECT * FROM users WHERE id_user = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            $role = $userData['role']; 
            return $this->createUser($role, $userData);
        }
        return null;
    }
    public function authenticate($username, $password) {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData && password_verify($password, $userData['password'])) {
            return $this->createUser($userData['role'], $userData);
        }
        return null;
    }
    public function getAllTeachers() {
        $sql = "SELECT * FROM users WHERE role = 'teacher'";
        $stmt = $this->db->query($sql);
        $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $list = [];
        $i = 0;
        foreach ($teachers as $teacher) {
                var_dump($teacher);
         $list[$i] = $this->createUser($teacher['role'],$teacher);
         $i++;
        } 
        return $list;
    }
}

