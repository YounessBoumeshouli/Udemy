<?php
require_once 'User.php';

class Teacher extends User {
    public function __construct($db, $userData = null) {
        parent::__construct($db);
        $this->role = 'teacher';
        $this->status = $userData["status"];
        if ($userData) {
            $this->id = $userData['id_user'];
            $this->username = $userData['username'];
            $this->email = $userData['email'];
        }
    }

    public function getSpecificData() {
        $sql = "SELECT * FROM courses WHERE teacher_id = :teacher_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':teacher_id', $this->id);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $listCourse = [];
        $i = 0;
        $coursFactory = new CourseFactory($this->db);
        foreach ($data as $course ) {
            $courseObj =  $coursFactory->createCourse($course["type"], $course);
            $listCourse[$i] = $courseObj;
            $i++;
        }
        return $listCourse;
    }

    public function createCourse($courseData) {
        $sql = "INSERT INTO courses (title, description, teacher_id, category_id) 
                VALUES (:title, :description, :teacher_id, :category_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':title', $courseData['title']);
        $stmt->bindParam(':description', $courseData['description']);
        $stmt->bindParam(':teacher_id', $this->id);
        $stmt->bindParam(':category_id', $courseData['category_id']);
        return $stmt->execute();
    }
}

