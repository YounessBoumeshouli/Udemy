<?php
require_once 'Course.php';

class DocumentCourse extends Course {
    private $documentUrl;

    public function __construct($db, $courseData = null) {
        parent::__construct($db);
        if ($courseData) {
              if($courseData['id']){
                $this->id = $courseData['id'] ;

              }else{
                $this->id = null;
              }
            $this->title = $courseData['title'];
            $this->description = $courseData['description'];
            $this->teacher_id = $courseData['teacher_id'];
            $this->category_id = $courseData['category_id'];
            $this->documentUrl = $courseData['document_url'];
            $this->status = $courseData['course_status'];
        }
    }

    public function display() {
        echo "Affichage du cours document : {$this->title}<br>";
        echo "URL du document : {$this->documentUrl}<br>";
    }

    public function setUrl($url) {
        $this->documentUrl = $url;
    }

    public function getUrl() {
        return $this->documentUrl;
    }
}

