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

if(isset($_GET['param'])) {
    $error = $msg002;
}

try {
    $pdo = new PDO($datasource, $dbUser,$dbPass);
} catch (PDOException $e) {
    exit($msgDbConnectError.$e->getMessage());
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
            <h2><?=$nickname?>のユーザ情報の変更</h2>
            <a href="./selectShop.php">TOPに戻る</a>
        </div>

        <?php
            if(isset($error)) {
                echo '<p id="errorMsg">'.$error.'</p>';
            }
        ?>

        <div id="showUser">
            <form action="./editUserInfo.php" method="post">
                <ul class="clearfix">
                    <li><label class="titleLabel" for="email">email</label></li>
                    <li><div class="loginFormArea">
                        <input type="email" name="email" id="email" value="<?=$email?>" required>
                    </div></li>
                </ul>
                <ul class="clearfix">
                    <li><label class="titleLabel" for="nickname">ニックネーム</label></li>
                    <li><div class="loginFormArea">
                        <input type="text" name="nickname" id="nickname" value="<?=$nickname?>" required>
                    </div></li>
                </ul>
                <ul class="clearfix">
                    <li><label class="titleLabel" for="password">パスワード</label></li>
                    <li><div class="loginFormArea">
                        <input type="password" name="password" id="password" placeholder="変更する場合に入力してください。">
                    </div></li>
                </ul>
                <button class="rptSbt">変更</button>
            </form>
        </div>
    </body>
</html>