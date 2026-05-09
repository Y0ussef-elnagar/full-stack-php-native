<?php
session_start();
if (isset($_SESSION['admin_login'])) {



    include("init.php");
    $q1 = $connect->prepare("SELECT *FROM users");
    $q1->execute();
    $userCount = $q1->rowCount();

    $q2 = $connect->prepare("SELECT *FROM category");
    $q2->execute();
    $cateCount = $q2->rowCount();

    $q3 = $connect->prepare("SELECT *FROM posts");
    $q3->execute();
    $postCount = $q3->rowCount();

    $q4 = $connect->prepare("SELECT *FROM comments");
    $q4->execute();
    $commentCount = $q4->rowCount();

?>

    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-md-3 text-center">
                <div class="box">
                    <i class="fa-solid fa-user fa-2xl"></i>
                    <h4 class="mt-3">Users</h4>
                    <h6><?php echo $userCount ?></h6>
                    <a href="users.php" class="btn btn-success">Show</a>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="box">
                    <i class="fa-solid fa-layer-group fa-2xl"></i>
                    <h4 class="mt-3">Categories</h4>
                    <h6><?php echo $cateCount ?></h6>
                    <a href="users.php" class="btn btn-primary">Show</a>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="box">
                    <i class="fa-solid fa-address-card fa-2xl"></i>
                    <h4 class="mt-3">Posts</h4>
                    <h6><?php echo $postCount ?></h6>
                    <a href="users.php" class="btn btn-warning">Show</a>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="box">
                    <i class="fa-solid fa-comment fa-2xl"></i>
                    <h4 class="mt-3">Comments</h4>
                    <h6><?php echo $commentCount ?></h6>
                    <a href="users.php" class="btn btn-danger">Show</a>
                </div>
            </div>

        </div>
    </div>


<?php
    include("includes/temp/footer.php");
} else {
    $_SESSION['message_login'] = "Login First";
    header("Location:../login.php");
}
?>