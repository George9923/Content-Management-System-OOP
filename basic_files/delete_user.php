<?php include("includes/init.php"); ?>

<?php if(!$session->is_signed_in()) {redirect("./login.php");} ?>

<?php 

if(empty($_GET['id'])){
    redirect("users.php");
}
$userOB = new User();
$user = $userOB ->find_by_id($_GET['id']);

if($user){
    $session->message("The {$user->username} has been deleted");
    $user->deletePhoto();
    redirect("users.php");
} else {
    redirect("users.php");
}


?>