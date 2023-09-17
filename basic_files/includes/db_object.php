<?php

class Db_object{

    // FROM USERS  
    public $id;
    public $user_image;

    // FROM PHOTO
    public $type;
    public $size;
    public $tmp_path;
    public $upload_directory;

    public $database;
    protected $db_table;
    protected  $db_table_fields;
    public $errors = array();
    public $upload_errors = array(
        UPLOAD_ERR_OK => 'There is no error, the file uploaded with success.',
        UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
        UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
        UPLOAD_ERR_CANT_WRITE => 'Cannot write to target directory. Please fix CHMOD.',
        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
    );

    function  __construct()
    {
        $this->database = new Database();
    }

    public function set_file($file){

        if(empty($file) || !$file || !is_array($file)){
            $this->errors[] = "There was no file uploaded here";
            return false;
        } elseif ($file['error'] != 0){
            $this -> errors[] = $this->upload_errors[$file['error']];
            return false;

        } else {

            $this->user_image = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type     = $file['type'];
            $this->size     = $file['size'];

    
        }

    }

    public function upload_photo(){

        if(!empty($this->errors)){
            return false;
        }

        if(empty($this->user_image) || empty($this->tmp_path)){
            $this->errors[] = "the file was not available";
        }

        $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;

        if(file_exists($target_path)){
            $this->errors[] = "The file {$this->user_image} already exist";
            return false;
        } 


        if(move_uploaded_file($this->tmp_path, $target_path)){
            unset($this->tmp_path);
            return true;

        } else {
            $this ->errors[] = "the folder directory does not have permission";
            return false;
        }
    }

    public function find_all(){
        return $this->find_by_query("SELECT * FROM " . $this->db_table . " ");
    }

    public function find_by_id($id){
        $result_set_array = $this->find_by_query("SELECT * FROM " . $this->db_table . "  WHERE id = $id LIMIT 1");
        return !empty($result_set_array) ? array_shift($result_set_array) : false;

    }

    public  function find_by_query($sql){
        $result_set = $this->database->query($sql);
        $object_array = array();

        while($row = mysqli_fetch_array($result_set)){
            $object_array[] = $this->instantation($row);
        }

        return $object_array;
    }
  
    public  function instantation($the_record){
                         
        $calling_class = get_called_class();

        $object = new $calling_class;
        foreach ($the_record as $the_attribute => $value){
            if($object->has_the_attribute($the_attribute)){

                $object->$the_attribute = $value;

            }
        }

        return $object;


    }

    public function has_the_attribute($the_attribute){

        $object_properties = get_object_vars($this);

        return array_key_exists($the_attribute, $object_properties);


    }


    protected function properties(){
        $properties = array();

        foreach($this->db_table_fields as $db_field){
            if(property_exists($this, $db_field)){
                $properties[$db_field] = $this->$db_field;
            }

        }

        return $properties;

    } 

    protected function clean_properties(){
        $clean_properties = array();

        foreach($this->properties() as $key => $value){
            $clean_properties[$key] = $this->database->escape_string($value);
        }

        return $clean_properties;
    }

    
    public function saveUser(){
        return isset($this->id) ? $this->create() : $this->create();
    }

    public function create(){

        $properties = $this->clean_properties();

        $sql = "INSERT INTO ". $this->db_table ." ( " . implode( ",", array_keys($properties)) . " ) ";
        $sql .= "VALUES('" . implode( "','", array_values($properties)) . " ')";


        if($this->database->query($sql)){
            $this->id = $this->database ->the_insert_id();
            return true;
        } else {
            return false;
        }
    } // END CREATE METHOD

    public function update(){

        $properties = $this->clean_properties();

        $properties_pairs = array();

        foreach($properties as $key => $value){
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE ". $this->db_table ." SET ";
        $sql .= implode(",", $properties_pairs);
        $sql .= " WHERE id = " . $this->database->escape_string($this->id);

        $this->database->query($sql);

        return (mysqli_affected_rows($this->database->connection) == 1) ? true : false;
        


    } // END UPDATE METHOD


    public function delete(){

        $sql = "DELETE FROM ".  $this->db_table ." ";
        $sql .= "WHERE id = " . $this->database->escape_string($this->id);
        $sql .= " LIMIT 1";

        $this->database->query($sql);

        return (mysqli_affected_rows($this->database->connection) == 1) ? true : false;

    }// END DELETE METHOD


    public  function count_all(){

        return count($this->find_all());
        
        }

}






?>