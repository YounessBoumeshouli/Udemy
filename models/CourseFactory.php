<?php
require_once 'VideoCourse.php';
require_once 'DocumentCourse.php';

class CourseFactory {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createCourse($type, $courseData) {
        switch ($type) {
            case 'video':
                return new VideoCourse($this->db, $courseData);
            case 'document':
                return new DocumentCourse($this->db, $courseData);
            default:
                throw new Exception("Invalid course type");
        }
    }

    public function getCourse($id) {
        $sql = "SELECT * FROM courses WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $courseData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($courseData) {
            $type = $courseData['type']; 
            return $this->createCourse($type, $courseData);
        }
        return null;
    }
    
    public function getCourseByStatus($status) {
        $sql = "SELECT * FROM courses WHERE course_status = :status";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        $courseData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $i = 0;
        $list = [];
        foreach ($courseData as $course) {
            $type = $course['type']; 
            $obj = $this->createCourse($type, $course);
            $list[$i] = $obj;
            $i++;
        }
        return $list;
    }

    public function getAllCourses($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM courses where course_status= 'accepted' LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $coursesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $courses = [];
        foreach ($coursesData as $courseData) {
            $courses[] = $this->createCourse($courseData['type'], $courseData);
        }
        return $courses;
    }
    public function getAllCoursesWithTag($tag) {
        $sql = "SELECT * FROM courses where course_status= 'accepted' and id in (SELECT course_id from course_tag where tag_id = :tag_id)";
        $stmt = $this->db->prepare($sql);
       
        $stmt->bindParam(':tag_id', $tag, PDO::PARAM_INT);
        $stmt->execute();
        $coursesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $courses = [];
        foreach ($coursesData as $courseData) {
            $courses[] = $this->createCourse($courseData['type'], $courseData);
        }
        return $courses;
    }

    public function searchCourses($keyword) {
        $sql = "SELECT * FROM courses WHERE title LIKE :keyword OR description LIKE :keyword";
        $stmt = $this->db->prepare($sql);
        $keyword = "%$keyword%";
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        $coursesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $courses = [];
        foreach ($coursesData as $courseData) {
            $courses[] = $this->createCourse($courseData['type'], $courseData);
        }
        return $courses;
    }

    public function deleteCourse($id) {
        try {
            $sql = "DELETE FROM courses WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error deleting course: " . $e->getMessage());
            return false;
        }
    }
    public function updateCourse($course) {
        try {
            $id = $course->getId();
            $title = $course->getTitle();
            $desc = $course->getDescription();
            $category = $course->getCategory();
            $url = $course->getUrl();
            $date = date('Y-m-d');
            $sql = "UPDATE public.courses
	SET  title=:title, description=:description,  category_id=:category_id,document_url=:document_url,updateddate=:updateddate
	WHERE id= :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':description',$desc);
            $stmt->bindParam(':title',$title);
            $stmt->bindParam(':category_id', $category);
            $stmt->bindParam(':document_url', $url);
            $stmt->bindParam(':updateddate', $date);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error deleting course: " . $e->getMessage());
            return false;
        }
    }
}
