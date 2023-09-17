<?php include("includes/init.php"); ?>

<?php if(!$session->is_signed_in()) {redirect("./login.php");} ?>

<?php 

if(empty($_GET['id'])){
    redirect("photos.php");
}
$photoOB = new Photo();
$photo = $photoOB ->find_by_id($_GET['id']);

if($photo){
    $photo->deletePhoto();
    $session->message("The {$photo->filename} has been deleted");
    redirect("photos.php");
} else {
    redirect("photos.php");
}


?>