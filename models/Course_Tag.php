<?php


class TagsCourse{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($id_course,$id_tag) {
        $sql = "INSERT INTO public.course_tag(course_id,tag_id)
	VALUES ( :course_id,:tag_id);";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':course_id', $id_course);
        $stmt->bindParam(':tag_id', $id_tag);
        
        return $stmt->execute();
    }
    public function getTags($id_course) {
        $sql = "SELECT t.id_tag , t.tag_name
	FROM public.course_tag ct inner join tags t on t.id_tag = ct.tag_id where ct.course_id =:course_id  ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':course_id', $id_course);
    
         $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
  
}

