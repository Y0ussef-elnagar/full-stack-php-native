<?php
$dns = 'mysql:host=sql206.infinityfree.com;dbname=if0_41869535_finalnti';
$user = 'if0_41869535';
$pass = "PGUMXqDbms";
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    // بتعدل الترميز
);

try {
    $connect = new PDO($dns, $user, $pass, $option);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Failed To connect With DB" . $e->getMessage();
}
