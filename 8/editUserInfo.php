<?php

include './base/base.php';
include './base/msg.php';

session_start();

// ログイン状態のチェック
if (!isset($_SESSION["userId"])) {
    header("Location: index.php");
    exit();
} else {
    $userId = $_SESSION["userId"];
}

if (
    !isset($_POST["email"]) || $_POST["email"]=="" ||
    !isset($_POST["nickname"]) || $_POST["nickname"]=="" 
) {
    header("Location: inputUserInfo.php?param=false");
    exit();
} else {
    $email = htmlEnc($_POST["email"]);
    $nickname = htmlEnc($_POST["nickname"]);

    if (isset($_POST["password"])) {
        $password = htmlEnc($_POST["password"]);
    }
}

try {
    $pdo = new PDO($datasource, $dbUser,$dbPass);
} catch (PDOException $e) {
    exit($msgDbConnectError.$e->getMessage());
}

if (isset($_POST["password"])) {
    // ユーザー情報更新（パスワードあり）
    $stmt = $pdo->prepare($updateUserInfoSQL);

    $stmt->bindValue(':id', $userId);
    $stmt->bindValue(':nickname', $nickname);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
} else {
    // ユーザー情報更新（パスワードなし）
    $stmt = $pdo->prepare($updateUserInfoNonPassSQL);

    $stmt->bindValue(':id', $userId);
    $stmt->bindValue(':nickname', $nickname);
    $stmt->bindValue(':email', $email);
}

var_dump($stmt);

$flag = $stmt->execute();

if ($flag==false) {
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);
} else {
    $_SESSION["nickname"] = $nickname;
    header("Location: showUser.php?edit=true");
    exit();
}

?>
