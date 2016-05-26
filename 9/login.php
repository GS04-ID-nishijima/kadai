<?php

include './base/base.php';
include './base/msg.php';
include './base/func.php';

$email = htmlEnc($_POST["email"]);
$password = htmlEnc($_POST["password"]);

$pdo = dbConnect();
$stmt = $pdo->prepare($checkPasswordSQL);

$stmt->bindValue(':email', $email);
$stmt->bindValue(':password', $password);

$flag = $stmt->execute();

if($flag==false) {
    $error = $stmt->errorInfo();
    exit($msg007.$error[2]);
} else {
    if( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
        session_start();
        session_regenerate_id(TRUE);
        $_SESSION["chk_ssid"]  = session_id();
        $_SESSION["userId"] = $result['id'];
        $_SESSION["nickname"] = $result['nickname'];

        if($result['type'] == 10) {
            header("Location: admin/showUserList.php");
        } else {
            header("Location: selectShop.php");
        }
        exit();
    } else {
        header("Location: index.php?login=false");
        exit();
    }
}
?>
