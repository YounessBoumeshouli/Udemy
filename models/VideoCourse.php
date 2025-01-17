<?php
require_once 'Course.php';

class VideoCourse extends Course {
    private $videoUrl;

    public function __construct($db, $courseData = null) {
        parent::__construct($db);
        if ($courseData) {
            $this->id = $courseData['id'] ?? null ;
            $this->title = $courseData['title'] ;
            $this->description = $courseData['description'] ?? null;
            $this->teacher_id = $courseData['teacher_id'];
            $this->category_id = $courseData['category_id'];
            $this->videoUrl = $courseData['document_url'];
            $this->status = $courseData['course_status'] ?? null;

        }
    }

    public function display() {
        echo "Affichage du cours vidéo : {$this->title}<br>";
        echo "URL de la vidéo : {$this->videoUrl}<br>";
    }

    public function setUrl($url) {
        $this->videoUrl = $url;
    }

    public function getUrl() {
        return $this->videoUrl;
    }
}

