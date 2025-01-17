<?php
require_once 'CourseFactory.php';
require_once 'UserFactory.php';

class Statistics {
    private $db;
    private $courseFactory;
    public function __construct($db) {
        $this->db = $db;
        $this->courseFactory  = new CourseFactory($db);
        $this->userFactory  = new UserFactory($db);
    }

    public function getTotalCourses() {
        $sql = "SELECT COUNT(*) as total FROM courses";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    public function getTotalCoursesbyTeacher($id) {
        $sql = "SELECT COUNT(*) as total FROM courses where teacher_id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCoursesByCategory() {
        $sql = "SELECT categories.name_categorie, COUNT(courses.id) as count 
                FROM categories 
                LEFT JOIN courses ON categories.id_categorie = courses.category_id 
                GROUP BY categories.id_categorie";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMostPopularCourse() {
        $sql = "SELECT courses.*, COUNT(enrollments.id) as student_count 
                FROM courses 
                LEFT JOIN enrollments ON courses.id = enrollments.course_id 
                GROUP BY courses.id 
                ORDER BY student_count DESC 
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getMostPopularCoursebyTeacher($id) {
        $sql = "SELECT courses.*, COUNT(enrollments.id) as student_count 
                FROM courses 
                LEFT JOIN enrollments ON courses.id = enrollments.course_id  where teacher_id=:id
                GROUP BY courses.id 
                ORDER BY student_count DESC 
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $course = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($course);
        $obj =   $this->courseFactory->createCourse($course["type"], $course);
        return $obj;
        

    }
    public function getStudents($idTeacher) {
        $sql = "SELECT DISTINCT *
                FROM users 
                INNER JOIN enrollments ON users.id_user = enrollments.student_id
				INNER JOIN courses ON enrollments.course_id = courses.id	
				where courses.teacher_id =:teacher_id
                
                ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":teacher_id",$idTeacher);
        $stmt->execute();
       $data =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        $listUsers = [];
        $i = 0;
        foreach ($data as $student) {
            $user = $this->userFactory->getUser($student['id_user']);
            $listUsers[$i] = $user;
            $i++;
            # code...
        }
        return $listUsers;
    }

    public function getTopTeachers() {
        $sql = "SELECT users.*, COUNT(courses.id) as course_count 
                FROM users 
                JOIN courses ON users.id_user = courses.teacher_id 
                WHERE users.role = 'teacher' 
                GROUP BY users.id_user
                ORDER BY course_count DESC 
                LIMIT 3";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

