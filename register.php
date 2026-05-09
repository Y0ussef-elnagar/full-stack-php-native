<?php
session_start();
include("init_user.php");
$emailErr = $passErr = $email = $userErr = $user = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['user'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    if (empty($email)) {
        $emailErr = "Enter Email";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Enter valid email";
    }


    if (empty($pass)) {
        $passErr = "Enter Password";
    }

    if (empty($user)) {
        $userErr = "Enter Name";
    }

    if (empty($emailErr) && empty($passErr) && empty($userErr)) {
        $statment = $connect->prepare("INSERT INTO users
        (user_name,email,`password`,`status`,`role`,created_at)
        VALUES(?,?,?,'1','user',now());
        ");
        $statment->execute([$user, $email, $pass]);
        $_SESSION['user_login'] = $email;
        header("Location:index.php");
    }
}
?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-10 m-auto">
            <?php
            if ((isset($_SESSION['message_register']))) {
                echo "<h4 class='alert alert-danger text-center'>" . $_SESSION['message_register'] . "</h4>";
                unset($_SESSION['message_register']);
            }
            ?>
            <h4 class="text-center mb-4">Register Page</h4>
            <form method="post">
                <input type="text" value="<?php echo $user ?>" name="user" placeholder="Name" class="form-control mb-4">
                <h5 class="text-center alter alert-danger"><?php echo $userErr ?></h5>


                <input type="email" value="<?php echo $email ?>" name="email" placeholder="Email" class="form-control mb-4">
                <h5 class="text-center alter alert-danger"><?php echo $emailErr ?></h5>


                <input type="password" name="pass" placeholder="Password" class="form-control mb-4">
                <h5 class="text-center  alter alert-danger"><?php echo $passErr ?></h5>

                <input type="submit" value="Create new account" class="btn btn-success btn-block">
            </form>
        </div>
    </div>
</div>


<?php
include("includes/temp/footer.php");
?>