<?php
require_once 'User.php';

class Admin extends User {
    public function __construct($db, $userData = null) {
        parent::__construct($db);
        $this->role = 'admin';
        if ($userData) {
            $this->id = $userData['id_user'];
            $this->username = $userData['username'];
            $this->email = $userData['email'];
        }
    }

    public function getSpecificData() {
        $sql = "SELECT 
                (SELECT COUNT(*) FROM courses) as total_courses,
                (SELECT COUNT(*) FROM users WHERE role = 'student') as total_students,
                (SELECT COUNT(*) FROM users WHERE role = 'teacher') as total_teachers";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function validateTeacher($teacherId) {
        $sql = "UPDATE users SET is_active = TRUE WHERE id = :id AND role = 'teacher'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $teacherId);
        return $stmt->execute();
    }
}
