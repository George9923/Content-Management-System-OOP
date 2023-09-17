<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("./login.php");} ?>

<?php 
    $user = new User();

        if(isset($_POST['create'])){

            if($user){
                $user-> username  = $_POST['username'];
                $user-> firstname = $_POST['firstname'];
                $user-> lastname  = $_POST['lastname'];
                $user-> password  = $_POST['password'];

                $user->set_file($_FILES['user_image']);
                $user->upload_photo();
                $session->message("The {$user->username} has beed added");
                $user->saveUser();
                redirect("users.php");
            }
        }
?> 


        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <!-- Top Menu Items --> <?php include_once "includes/top_nav.php";?>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <?php include_once "includes/sidebar.php";?>
            <!-- /.navbar-collapse -->
        </nav>
        <div id="page-wrapper">
                <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Add User
                    </h1>


                    <form action="" method="post" enctype="multipart/form-data">





                    <div class="col-md-6 col-md-offset-3">

                    <div class="form-group">
                            <label for="user_image">File</label>
                            <input type="file" name="user_image">
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" >
                        </div>

                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" name="firstname" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" name="lastname" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        
                        <div class="form-group">
                            <input type="submit" name="create" class="bnt btn-primary pull-right">
                        </div>
                        
                 </div>

            </form>

                </div>
            </div>
            <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>