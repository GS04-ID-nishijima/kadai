<?php

include '../base/base.php';
include '../base/msg.php';
include '../base/func.php';

// セッションチェック
sessionCheck();

$userId = $_POST["id"];

$pdo = dbConnect();

$stmt = $pdo->prepare($deleteUserSQL);
$stmt->bindValue(':id', $userId);

$flag = $stmt->execute();

if ($flag==false) {
    $error = $stmt->errorInfo();
    exit($msg007.$error[2]);
} else {
    $_SESSION["nickname"] = $nickname;
    header("Location: showUserList.php?delete=true");
    exit();
}

?>
