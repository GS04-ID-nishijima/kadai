<?php

include './base/base.php';
include './base/msg.php';
include './base/func.php';

// セッションチェック
sessionCheck();

$userId = $_SESSION["userId"];

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

$pdo = dbConnect();

if ($_POST["password"] == "") {
    // ユーザー情報更新（パスワードなし）
    $stmt = $pdo->prepare($updateUserInfoNonPassSQL);

    $stmt->bindValue(':id', $userId);
    $stmt->bindValue(':nickname', $nickname);
    $stmt->bindValue(':email', $email);
} else {
    // ユーザー情報更新（パスワードあり）
    $stmt = $pdo->prepare($updateUserInfoSQL);

    $stmt->bindValue(':id', $userId);
    $stmt->bindValue(':nickname', $nickname);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
}

$flag = $stmt->execute();

if ($flag==false) {
    $error = $stmt->errorInfo();
    exit($msg007.$error[2]);
} else {
    $_SESSION["nickname"] = $nickname;
    header("Location: showUser.php?edit=true");
    exit();
}

?>
