<?php
require_once 'User.php';

class Student extends User {
    public function __construct($db, $userData) {
        parent::__construct($db);
        $this->role = 'student';
        if ($userData) {
            $this->id = $userData['id_user'];
            $this->username = $userData['username'];
            $this->email = $userData['email'];
        }
    }

    public function getSpecificData() {
        $sql = "SELECT c.* FROM courses c 
                JOIN enrollments e ON c.id = e.course_id 
                WHERE e.student_id = :student_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':student_id', $this->id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function enrollCourse($courseId) {
        $sql = "INSERT INTO enrollments (student_id, course_id) VALUES (:student_id, :course_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':student_id', $this->id);
        $stmt->bindParam(':course_id', $courseId);
        return $stmt->execute();
    }
}

