<?php
require_once 'models/Tags.php';
require_once 'models/Course_Tags.php';
require_once 'config/Database.php';

class TagsManager {
    private $tags;

    public function __construct() {
        $db = Database::getInstance()->getConnection();
        $this->tags = new Tags($db,null,null);
        $this->courseTags = new TagsCourse($db);
    }

    public function listTags() {
        $data =  $this->tags->getAll();
        $listTags = [];
        
        $i = 0;
        if($data){
            foreach ($data as $tag ) {
                $listTags[$i] = new Tags(null,$tag['tag_name'],$tag['id_tag']);
                $i++;
        }
        }
        return $listTags;
    }

    public function addTag($name) {
        return $this->tags->create(['name' => $name]);
    }
    public function getTag($id) {
        $data =  $this->tags->read($id);
        $tagObj = new Tags(null,$data['tag_name'],$data['id_tag']);
        return $tagObj;
    }
    public function getTags($id) {
        $data =  $this->courseTags->getTags($id);
        $tagsList=[];
        $i = 0;
        foreach ($data as $tag) {
            $tagsList[$i] = new Tags(null,$tag['tag_name'],$tag['id_tag']);
            $i++;
        }
        return $tagsList;
    }

}

