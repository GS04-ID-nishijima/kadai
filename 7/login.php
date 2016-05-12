<?php

include './base/base.php';

$email = htmlEnc($_POST["email"]);
$password = htmlEnc($_POST["password"]);

$pdo = new PDO($datasource, $dbUser,$dbPass);
$stmt = $pdo->prepare("SELECT id, nickname FROM user WHERE email=:email and password = :password");

$stmt->bindValue(':email', $email);
$stmt->bindValue(':password', $password);

$flag = $stmt->execute();

if($flag==false) {
    echo "SQLエラー";
} else {
    if( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
        session_start();
        session_regenerate_id(TRUE);
        $_SESSION["userId"] = $result['id'];
        $_SESSION["nickname"] = $result['nickname'];

        header("Location: selectShop.php");
        exit();
    } else {
        header("Location: index.php?login=false");
        exit();
    }
}
?>
