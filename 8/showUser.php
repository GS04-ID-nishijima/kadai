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

try {
    $pdo = new PDO($datasource, $dbUser,$dbPass);
} catch (PDOException $e) {
    exit($msgDbConnectError.$e->getMessage());
}

if(isset($_GET['edit'])) {
    $error = $msg003;
}


// ユーザー情報取得
$stmt = $pdo->prepare($getUserInfoSQL);

$stmt->bindValue(':id', $userId);
$flag = $stmt->execute();

if($flag==false){
    $error = $stmt->errorInfo();
    exit($msgQueryError.$error[2]);
}else{
    if( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $email = $result['email'];
        $nickname = $result['nickname'];
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>キョウココ</title>
        <link rel="stylesheet" href="css/main.css">
        <script src="./lib/jquery-2.1.3.min.js"></script>
    </head>
    <body>
        <header>
           <h1>
               キ ョ ウ コ コ
           </h1>
        </header>
        <div class="subheader clearfix">
            <h2><?=$nickname?>のユーザ情報</h2>
            <a href="./selectShop.php">TOPに戻る</a>
        </div>
        <?php
            if(isset($error)) {
                echo '<p id="errorMsg">'.$error.'</p>';
            }
        ?>
        <div id="showUser">
            <ul class="clearfix">
                <li><label class="titleLabel">email</label></li>
                <li><p><?=$email?></p></li>
            </ul>
            <ul class="clearfix">
                <li><label class="titleLabel">ニックネーム</label></li>
                <li><p><?=$nickname?></p></li>
            </ul>
            <ul class="clearfix">
                <li><label class="titleLabel">パスワード</label></li>
                <li><p>********（セキュリティのため表示していません。）</p></li>
            </ul>
            <form action="./inputUserInfo.php">
                <button class="rptSbt">ユーザ情報の<br>変更</button>
            </form>
        </div>
    </body>
</html>