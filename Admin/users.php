<?php
session_start();
if (isset($_SESSION['admin_login'])) {
    include("init.php");
    $page = "All";
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }


    if ($page == "All") {

        $statment = $connect->prepare("SELECT * FROM users");
        $statment->execute();
        $userCount = $statment->rowCount();
        $result = $statment->fetchAll();
?>


        <div class="container mt-5 pt-5">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo "<h4 class='alert alert-success text-center'>" . $_SESSION['message'] . "</h4>";
                        unset($_SESSION['message']);
                        header("refresh:3;url=users.php");
                    }
                    ?>
                    <h3 class="text-center">User Details <span class="badge badge-primary"><?php echo $userCount ?></span>
                        <a href="?page=create" class="btn btn-success">Create New user</a>
                    </h3>
                    <table class="table table-dark text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result as $item) {
                            ?>
                                <tr>
                                    <td><?php echo $item['user_id'] ?></td>
                                    <td><?php echo $item['user_name'] ?></td>
                                    <td><?php echo $item['email'] ?></td>
                                    <td>
                                        <a href="?page=show&user_id=<?php echo $item['user_id'] ?>" class="btn btn-success"><i class="fa-solid fa-eye"></i></a>

                                        <a href="?page=edit&user_id=<?php echo $item['user_id'] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>

                                        <a href="?page=delete&user_id=<?php echo $item['user_id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    <?php
    } else if ($page == "show") {
        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];
        }

        $statment = $connect->prepare("SELECT * FROM users WHERE user_id =?");
        $statment->execute(array($user_id));
        $result = $statment->fetch();

    ?>
        <div class="container mt-4 pt-4">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <h4 class="text-center">Details of one Record <span class="badge badge-primary">1</span></h4>
                    <table class="table table-dark text-center">
                        <thead>

                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created_at</th>
                                <th>Opreation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $result['user_id'] ?></td>
                                <td><?php echo $result['user_name'] ?></td>
                                <td><?php echo $result['email'] ?></td>
                                <td><?php echo $result['password'] ?></td>
                                <td><?php echo $result['role'] ?></td>
                                <td><?php echo $result['status'] ?></td>
                                <td><?php echo $result['created_at'] ?></td>
                                <td>
                                    <a href="users.php" class="btn btn-success"><i class="fa-solid fa-house"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php

    } else if ($page == "delete") {
        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];
        }
        $statment = $connect->prepare("DELETE FROM users WHERE user_id =?");
        $statment->execute(array($user_id));
        $_SESSION['message'] = "Deleted Successfully";
        header("Location:users.php");
    } else if ($page == "create") {
        $idErr = $userErr = $emailErr = $passErr = "";
        $id = $user = $email = "";

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $id = $_POST['id'];
            $user = $_POST['user'];
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $role = $_POST['role'];
            $status = $_POST['status'];

            if (empty($id)) {
                $idErr = 'Enter ID';
            }

            if (empty($user)) {
                $userErr = 'Enter username';
            }

            if (empty($email)) {
                $emailErr = 'Enter Email';
            }

            if (empty($pass)) {
                $passErr = 'Enter password';
            }

            if (empty($idErr) && empty($userErr) && empty($emailrErr) && empty($passErr)) {
                $statment = $connect->prepare("SELECT * FROM users Where user_id = ? ");
                $statment->execute(array($id));
                $userCount = $statment->rowCount();
                if ($userCount == 0) {
                    $_SESSION['id'] = $id;
                    $_SESSION['user'] = $user;
                    $_SESSION['email'] = $email;
                    $_SESSION['pass'] = $pass;
                    $_SESSION['status'] = $status;
                    $_SESSION['role'] = $role;
                    header("Location:users.php?page=savenew");
                } else {
                    $_SESSION['error_duplicate'] = "Duplicate ID";
                }
            }
        }

    ?>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <?php
                    if (isset($_SESSION['error_duplicate'])) {
                        echo "<h4 class='alert alert-danger text-center'>" . $_SESSION['error_duplicate'] . "</h4>";
                        unset($_SESSION['error_duplicate']);
                    }
                    ?>
                    <form method="post" action="?page=create">
                        <label>ID</label>
                        <input type="text" name="id" value="<?php echo $id ?>" class="form-control mb-4">
                        <h4 class="text-center"><?php echo $idErr ?></h4>


                        <label>Name</label>
                        <input type="text" name="user" value="<?php echo $user ?>" class="form-control mb-4">
                        <h4 class="text-center"><?php echo $userErr ?></h4>


                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo $email ?>" class="form-control mb-4">
                        <h4 class="text-center"><?php echo $emailErr ?></h4>


                        <label>Password</label>
                        <input type="password" name="pass" class="form-control mb-4">
                        <h4 class="text-center"><?php echo $passErr ?></h4>

                        <label>Role</label>
                        <select name="role" class="form-control mb-4">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>

                        <label>Status</label>
                        <select name="status" class="form-control mb-4">
                            <option value="0">Block</option>
                            <option value="1">Active</option>
                        </select>

                        <input type="submit" value="Create New user" class="btn btn-success btn-block">
                    </form>
                </div>
            </div>
        </div>

    <?php
    } else if ($page == "savenew") {

        $id = $_SESSION['id'];
        $user = $_SESSION['user'];
        $email = $_SESSION['email'];
        $pass = $_SESSION['pass'];
        $role = $_SESSION['role'];
        $status = $_SESSION['status'];
        $statment = $connect->prepare('INSERT INTO users
        (user_id, user_name , email ,`password`, `role`, `status`,created_at)
        VALUES (?,?,?,?,?,?,now())
        ');
        $statment->execute(array($id, $user, $email, $pass, $role, $status));
        $_SESSION['message'] = 'Created Successfully';
        header("Location:users.php");
    } else if ($page == "edit") {

        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];
        }

        $statment = $connect->prepare("SELECT * FROM users WHERE user_id =?");
        $statment->execute(array($user_id));
        $result = $statment->fetch();
        $idErr = $userErr = $emailErr = $passErr = "";

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $id = $_POST['id'];
            $old_id = $_POST['old_id'];
            $user = $_POST['user'];
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $role = $_POST['role'];
            $status = $_POST['status'];
        }

        if (empty($id)) {
            $idErr = 'Enter ID';
        }

        if (empty($user)) {
            $userErr = 'Enter username';
        }

        if (empty($email)) {
            $emailErr = 'Enter Email';
        }

        if (empty($pass)) {
            $passErr = 'Enter password';
        }

        if (empty($idErr) && empty($userErr) && empty($emailrErr) && empty($passErr)) {
            $statment = $connect->prepare("SELECT * FROM users Where user_id = ? and user_id!=?");
            $statment->execute(array($id, $old_id));
            $userCount = $statment->rowCount();
            if ($userCount == 0) {
                $_SESSION['old_id'] = $old_id;
                $_SESSION['id'] = $id;
                $_SESSION['user'] = $user;
                $_SESSION['email'] = $email;
                $_SESSION['pass'] = $pass;
                $_SESSION['status'] = $status;
                $_SESSION['role'] = $role;
                header("Location:users.php?page=saveupdate");
            } else {
                $_SESSION['error_duplicate'] = "Duplicate ID";
            }
        }

    ?>

        <div class="container mt-3 pt-3">
            <div class="row">
                <div class="col-md-10 m-auto">

                    <?php
                    if (isset($_SESSION['error_duplicate'])) {
                        echo "<h4 class='alert alert-danger text-center'>" . $_SESSION['error_duplicate'] . "</h4>";
                        unset($_SESSION['error_duplicate']);
                    }
                    ?>

                    <form method="post" action="?page=edit&user_id=<?php echo $result['user_id'] ?>">
                        <input type="hidden" name="old_id" value="<?php echo $result['user_id']  ?>">
                        <label>ID</label>
                        <input type="text" name="id" value="<?php echo $result['user_id'] ?>" class="form-control mb-4">
                        <h4 class="text-center"><?php echo $idErr ?></h4>

                        <label>Name</label>
                        <input type="text" name="user" value="<?php echo $result['user_name'] ?>" class="form-control mb-4">
                        <h4 class="text-center"><?php echo $userErr ?></h4>


                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo $result['email'] ?>" class="form-control mb-4">
                        <h4 class="text-center"><?php echo $emailErr ?></h4>

                        <label>Password</label>
                        <input type="text" name="pass" value="<?php echo $result['password'] ?>" class="form-control mb-4">
                        <h4 class="text-center"><?php echo $passErr ?></h4>

                        <label>Role</label>
                        <select name="role" class="form-control mb-4">
                            <?php
                            if ($result['role'] == 'admin') {
                                echo '<option value="user">User</option>';
                                echo '<option value="admin" selected>Admin</option>';
                            } else {
                                echo '<option value="user" selected>User</option>';
                                echo '<option value="admin">Admin</option>';
                            }
                            ?>
                        </select>

                        <label>Status</label>
                        <select name="status" class="form-control mb-4">
                            <?php
                            if ($result['status'] == '1') {
                                echo '<option value="0">Block</option>';
                                echo '<option value="1" selected>Active</option>';
                            } else {
                                echo '<option value="0" selected>Block</option>';
                                echo '<option value="1" >Active</option>';
                            }
                            ?>
                        </select>

                        <input type="submit" value="Update" class="btn btn-success btn-block ">
                    </form>
                </div>
            </div>
        </div>

    <?php
    } else if ($page == "saveupdate") {


        $id = $_SESSION['id'];
        $old_id = $_SESSION['old_id'];
        $user = $_SESSION['user'];
        $email = $_SESSION['email'];
        $pass = $_SESSION['pass'];
        $role = $_SESSION['role'];
        $status = $_SESSION['status'];

        $statment = $connect->prepare("UPDATE users SET user_id =?, 
        user_name =?,
        email =?,
        `password` =?,
        `role` =?,
        `status`=?,
        updated_at = now()
        WHERE user_id = ?
        ");
        $statment->execute(array($id, $user, $email, $pass, $role, $status, $old_id));
        $_SESSION['message'] = "Updated Successfully";
        header("Location:users.php");
    }
    ?>


<?php
    include("includes/temp/footer.php");
} else {
    $_SESSION['message_login'] = "Login First";
    header("Location:../login.php");
}
?>