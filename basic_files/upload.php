<?php

// if(isset($_POST['submit'])){
//     echo "<pre>";
//     print_r($_FILES['file_upload']);
//     echo "<pre>";

    $upload_errors = array(
        UPLOAD_ERR_OK => 'There is no error, the file uploaded with success.',
        UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
        UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
        UPLOAD_ERR_CANT_WRITE => 'Cannot write to target directory. Please fix CHMOD.',
        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
    );

    $temp_name = $_FILES["file_upload"]['tmp_name'];
    $file_name = $_FILES['file_upload']['name'];
    $directory = "uploads";

    if(move_uploaded_file($temp_name, $directory . "/" . $file_name)){
        $the_message = "The file uploaded with success.";
    } else {
        $the_erorr = $_FILES['file_upload']['error'];
        $the_message = $upload_errors[$the_erorr];
    }

    
// }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="upload.php" enctype="multipart/form-data" method="post">

        <h2>

        <?php 
        
            if(!empty($upload_errors)){
                echo $the_message;
            }
        
        ?>


        </h2>

        <input type="file" name="file_upload"><br>

        <input type="submit" name="submit">
    </form>
    
</body>
</html>