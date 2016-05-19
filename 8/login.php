<?php

include './base/base.php';
include './base/msg.php';

$email = htmlEnc($_POST["email"]);
$password = htmlEnc($_POST["password"]);

$pdo = new PDO($datasource, $dbUser,$dbPass);
$stmt = $pdo->prepare($checkPasswordSQL);

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
