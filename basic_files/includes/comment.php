<?php 
    class Comment extends Db_object{

        protected $db_table = "comments";
        protected $db_table_fields = array('comment_post_id', 'author', 'body');

        public $id;
        public $comment_post_id;
        public $author;
        public $body;

        public function create_comment($comment_post_id , $author = "John Dean", $body=""){

            if(!empty($comment_post_id) && !empty($author) && !empty($body)){
                $commnet = new Comment();
                $commnet->comment_post_id   = (int)$comment_post_id ;
                $commnet->author            = $author;
                $commnet->body              =$body;

                return $commnet;
            } else {
                return false;
            }

        }  


        public function find_the_comments($comment_post_id =0){
            $sql = "SELECT * FROM " . $this->db_table;
            $sql .= " WHERE comment_post_id = " . $this->database->escape_string($comment_post_id );
            $sql .= " ORDER BY comment_post_id ASC";

            return $this->find_by_query($sql);
        }


    } // END USER CLASS 





?>