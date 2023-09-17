<?php 

    class Photo extends Db_object{

        protected  $db_table = "photos";
        protected  $db_table_fields = array('title', 'caption' ,'description', 'filename', 'alternate_text', 'type', 'size', 'user_id');
        public $title;
        public $caption;
        public $description;
        public $filename;
        public $alternate_text;
        public $user_id;
        public $upload_directory = "images";
        
        

        public function picture_path(){
            return $this->upload_directory.DS.$this->filename;
        }

        public function save(){

            if($this->id){
                $this->update();
            } else {
                if(!empty($this->errors)){
                    return false;
                }

                if(empty($this->filename) || empty($this->tmp_path)){
                    $this->errors[] = "the file was not available";
                }

                $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;

                if(file_exists($target_path)){
                    $this->errors[] = "The file {$this->filename} already exist";
                    return false;
                } 


                if(move_uploaded_file($this->tmp_path, $target_path)){
                    if($this->create()){
                        unset($this->tmp_path);
                        return true;
                    }

                } else {
                    $this ->errors[] = "the folder directory does not have permission";
                    return false;
                }

            }


        }


        public function deletePhoto(){

            if($this->delete()){
                $target_path = SITE_ROOT . DS . 'admin' . DS . $this->picture_path();
                
                return unlink($target_path) ? true : false;
                
            } else {
                return false;
            }
        }


        public function display_sidebar_data($photo_id) {
            $photo = new Photo();

            $photos = $photo->find_by_id($photo_id);


            $output = "<a class='thumbnail' href='#'><img width='100' src='{$photos->picture_path()}' ></a> ";
            $output .= "<p>{$photos->filename}</p>";
            $output .= "<p>{$photos->type}</p>";
            $output .= "<p>{$photos->size}</p>";

            echo $output;





        }

    } // END CLASS PHOTO



?>