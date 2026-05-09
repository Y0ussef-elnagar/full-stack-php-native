<?php
session_start();
include("init_user.php");
$emailErr = $passErr = $email = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    if (empty($emailErr) && empty($passErr)) {

        $statment = $connect->prepare("SELECT * FROM users WHERE email = ? and `password`=?");

        $statment->execute(array($email, $pass));
        $userCount = $statment->rowCount();
        if ($userCount > 0) {
            $result = $statment->fetch();
            if ($result['status'] == 1) {


                if ($result['role'] == "admin") {

                    $_SESSION['admin_login'] = $email;

                    header("Location:Admin/dashboard.php");
                } else {
                    $_SESSION['user_login'] = $email;
                    header("Location:index.php");
                }
            } else {
                $_SESSION['message_login'] = 'Your Acount Not In Active mode';
            }
        } else {
            $_SESSION['message_login'] = 'Your Acount Not In DB';
        }
    }
}
?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-10 m-auto">
            <?php
            if ((isset($_SESSION['message_login']))) {
                echo "<h4 class='alert alert-danger text-center'>" . $_SESSION['message_login'] . "</h4>";
                unset($_SESSION['message_login']);
            }
            ?>
            <h4 class="text-center mb-4">Login Page</h4>
            <form method="post">
                <input type="text" value="<?php echo $email ?>" name="email" placeholder="Email" class="form-control mb-4">
                <h5 class="text-center alter alert-danger"><?php echo $emailErr ?></h5>


                <input type="password" name="pass" placeholder="Password" class="form-control mb-4">
                <h5 class="text-center  alter alert-danger"><?php echo $passErr ?></h5>

                <input type="submit" value="Login" class="btn btn-success btn-block">
            </form>
        </div>
    </div>
</div>


<?php
include("includes/temp/footer.php");
?>