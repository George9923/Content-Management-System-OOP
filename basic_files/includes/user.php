<?php 

    class User extends Db_object{

        protected $db_table = "users";
        protected $db_table_fields = array('username' ,'password', 'firstname', 'lastname', 'user_image');

        public $username;
        public $password;
        public $firstname;
        public $lastname;


        public $upload_directory = "images";
        public $image_placeholder = "http://placehold.it/400x400&text=image"; 

        public function image_placeholder(){
            return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory.DS.$this->user_image;
        }
    

        public function verify_user($username, $password){
        if($this->database){
            $username = $this->database->escape_string($username);
            $password = $this->database->escape_string($password);

            $sql = "SELECT * FROM " . $this->db_table . "  WHERE ";
            $sql .= "username = '{$username}' AND ";
            $sql .= "password = '{$password}' ";
            $sql .= "LIMIT 1";

            $result_set_array = $this->find_by_query($sql);

            return !empty($result_set_array) ? array_shift($result_set_array) : false;
        } else {
            return false;
        }
        }


        public function ajax_save_user_image($user_image, $user_id) {

            $user_image = $this->database->escape_string($user_image);
            $user_id = $this->database->escape_string($user_id);

            $this->user_image = $user_image;
            $this->id         = $user_id;

            $sql  = "UPDATE " . $this->db_table . " SET user_image = '{$this->user_image}' ";
            $sql .= " WHERE id = {$this->id} ";
            $update_image = $this->database->query($sql);

            
            echo $this->image_placeholder();

        


        }

        public function deletePhoto(){

            if($this->delete()){
                $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;
                
                return unlink($target_path) ? true : false;
                
            } else {
                return false;
            }
        }


        public function photos(){
            $photoObject = new Photo();

            return $photoObject->find_by_query("SELECT * FROM photos WHERE user_id= " . $this->id);

        }

    }  // END USER CLASS 






?>