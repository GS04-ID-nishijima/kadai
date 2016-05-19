<?php

include './base/base.php';
include './base/msg.php';

if (
    !isset($_POST["email"]) || $_POST["email"]=="" ||
    !isset($_POST["nickname"]) || $_POST["nickname"]=="" ||
    !isset($_POST["password"]) || $_POST["password"]==""
) {
    header("Location: inputRegistUserInfo.php?param=false");
    exit();
} else {
    $email = htmlEnc($_POST["email"]);
    $nickname = htmlEnc($_POST["nickname"]);
    $password = htmlEnc($_POST["password"]);
}

try {
    $pdo = new PDO($datasource, $dbUser,$dbPass);
} catch (PDOException $e) {
    exit($msgDbConnectError.$e->getMessage());
}

// ユーザー情報登録
$stmt = $pdo->prepare($insertUserInfoSQL);

$stmt->bindValue(':nickname', $nickname);
$stmt->bindValue(':email', $email);
$stmt->bindValue(':password', $password);


var_dump($stmt);

$flag = $stmt->execute();

if ($flag==false) {
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);
} else {
    session_start();
    session_regenerate_id(TRUE);
    $_SESSION["userId"] = $pdo->lastInsertId();
    $_SESSION["nickname"] = $nickname;

    header("Location: selectShop.php?regist=true");
    exit();
}

?>
